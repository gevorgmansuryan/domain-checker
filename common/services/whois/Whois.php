<?php

namespace app\common\services\whois;


use app\models\Server;
use Yii;
use yii\base\BaseObject;
use yii\helpers\StringHelper;
use yii\httpclient\Client as HttpClient;
use yii\base\StaticInstanceInterface;
use yii\base\StaticInstanceTrait;
use yii\helpers\ArrayHelper;
use yii\httpclient\CurlTransport;
use app\common\services\whois\Exception as WhoisException;
use yii\httpclient\Exception as HttpClientException;

class Whois extends BaseObject implements StaticInstanceInterface
{
    use StaticInstanceTrait;

    private ?Server $server;
    private ?HttpClient $httpClient;
    private ?int $requestTimeout;

    public function init()
    {
        $this->requestTimeout = ArrayHelper::getValue(Yii::$app->params, 'whois_timeout');

        $this->httpClient = new HttpClient([
            'transport' => CurlTransport::class,
            'requestConfig' => [
                'options' => [
                    CURLOPT_TIMEOUT => $this->requestTimeout,
                    CURLOPT_CONNECTTIMEOUT => $this->requestTimeout,
                    CURLOPT_NOSIGNAL => 1,
                    CURLOPT_FOLLOWLOCATION => true,
                ]
            ],
        ]);;
    }

    public function check($url, $useFallback = true)
    {
        $request = $this->parseUrl($url);

        try {
            return $this->primaryRequest($request);
        } catch (WhoisException $e) {
            Yii::error($e->getMessage());

            if ($useFallback) {
                try {
                    return $this->fallbackRequest($request);
                } catch (WhoisException $e) {
                    Yii::error($e->getMessage());
                    return null;
                }
            }
        }

        return null;
    }

    public function parseUrl($url)
    {
        $domain = strtolower($url);

        $ex = explode('.', trim(trim($domain), '.'));
        $sld = $ex[0];
        $tld = trim((count($ex) > 2) ? '.' . $ex[1] . '.' . $ex[2] : '.' . end($ex), '.');

        $sld = str_replace(['http://', 'https://', ".", "_", " ", ",", "}", "{", "[", "]", ")", "(", "&", "^", "%", "\$", "#", "@", "!", "'", "\"", ";", ":", "/", "\\", "|"], '', $sld);

        return new Request([
            'sld' => $sld,
            'tld' => $tld,
        ]);
    }

    private function prepareWhoisServerClient(Request $request)
    {
        $this->server = Server::findOne(['tld' => $request->tld]);
        if (!$this->server) {
            throw new WhoisException("tld '{$request->tld}' not found");
        }

        if (empty($this->server->available_string)) {
            $this->server->status = Server::STATUS_CAN_NOT_PARSE_AVAILABLE;
        }
    }

    private function primaryRequest(Request $request)
    {
        $this->prepareWhoisServerClient($request);

        $requestString = $this->server->domain_only ? $request->sld : $request->domain;

        if ($this->server->is_http) {
            try {
                $httpResponse = $this->httpClient->get($this->server->whois . $requestString)->send();
                $data = $httpResponse->content;
                if (!$httpResponse->isOk) {
                    throw new WhoisException($data);
                }
            } catch (HttpClientException $e) {
                throw new WhoisException($e->getMessage());
            }

        } else {
            $sh = @fsockopen($this->server->whois, 43, $errno, $errstr, $this->requestTimeout);

            if (!$sh || $errno == '110') {
                $this->server->status = Server::STATUS_SERVER_NOT_WORKING;
                $this->server->save();

                throw new WhoisException('Cannot connect to whois server. Port 43 is being blocked');
            }

            stream_set_timeout($sh, $this->requestTimeout);

            if ($request->tld == 'de') {
                $requestString = '-T dn ' . $requestString;
            }

            socket_set_blocking($sh, false);

            fputs($sh, $requestString . PHP_EOL);

            $data = '';
            while (!feof($sh)) {
                $data .= fread($sh, 8192);
            }
            fclose($sh);
        }

        $this->server->server_response = $data;
        $response = $this->parsePrimaryResponse($data);

        if ($this->server->isAttributeChanged('status')) {
            $this->server->save();
        }

        return $response;
    }

    private function parsePrimaryResponse($data)
    {
        $response = new Response(['payload' => $data]);

        $rows = explode(PHP_EOL, $data);
        $response->available = false;
        foreach ($rows as $row) {
            if (strpos($row, $this->server->available_string) !== false) {
                $response->available = true;
                break;
            }
        }

        if (!$response->available) {
            $this->server->status = Server::STATUS_CAN_NOT_PARSE_EXPIRED;

            if (!empty($this->server->expire_string)) {
                foreach ($rows as $row) {
                    if (strpos($row, $this->server->expire_string) !== false) {
                        if ($date = $this->findDate($row)) {
                            $response->expires = $date;
                            $this->server->status = Server::STATUS_LEARNED;
                        }
                        break;
                    }
                }
            }

            if (empty($response->expires)) {
                foreach ($rows as $row) {
                    if (StringHelper::startsWith(trim($row), '<')) {
                        continue;
                    }
                    if ($date = $this->findDate($row)) {
                        $response->expires = $date;
                    }
                }
                if ($response->expires) {
                    $this->server->status = Server::STATUS_EXPIRED_MAY_NOT_CORRECT;
                }
            }
        }

        return $response;
    }

    private function fallbackRequest(Request $request)
    {
        $response = $this->httpClient->get('http://api.whoapi.com', [
            'apikey' => ArrayHelper::getValue(Yii::$app->params, 'whoapi_api_key'),
            'r' => 'whois',
            'domain' => $request->domain,
        ])->send();

        if (ArrayHelper::getValue($response->data, 'limit_hit')) {
            throw new WhoisException('Whoapi limit hit');
        }

        return new Response([
            'available' => ArrayHelper::getValue($response->data, 'status', -1) == 0,
            'expires' => ArrayHelper::getValue($response->data, 'date_expires'),
            'payload' => $response->content,
        ]);
    }

    private function findDate($string)
    {
        $string = trim(substr(trim($string), mb_strlen($this->server->expire_string)));

        while (mb_strlen($string) > 9) {
            if ($time = strtotime($string)) {
                return date('Y-m-d', $time);
            }
            $string = trim(substr($string, 1));
        }

        return null;
    }
}