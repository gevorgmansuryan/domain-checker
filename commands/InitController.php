<?php

namespace app\commands;

use app\common\services\whois\Whois;
use app\models\Server;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\StringHelper;

class InitController extends Controller
{
    public function actionIndex()
    {
        $servers = [
            '.ao' => [
                'server' => 'fred.nic.ao',
                'available' => 'No entries found'
            ],
            '.af' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.th' => [
                'server' => 'whois.thnic.co.th',
                'available' => 'No match for'
            ],
            '.id' => [
                'server' => 'whois.idnic.net.id',
                'available' => 'Not found'
            ],
            '.cat' => [
                'server' => 'whois.cat',
                'available' => 'NOT FOUND'
            ],
            '.ac' => [
                'server' => 'http://www.nic.ac/cgi-bin/whois?query=',
                'available' => 'This Domain is'
            ],
            '.ae' => [
                'server' => 'whois.aeda.net.ae',
                'available' => 'No Data Found'
            ],
            '.aero' => [
                'server' => 'whois.aero',
                'available' => 'NOT FOUND'
            ],
            '.ng' => [
                'server' => 'whois.nic.net.ng',
                'available' => 'Available'
            ],
            '.am' => [
                'server' => 'whois.amnic.net',
                'available' => 'No match'
            ],
            '.at' => [
                'server' => 'whois.nic.at',
                'available' => 'nothing found'
            ],
            '.priv.at' => [
                'server' => 'whois.nic.priv.at',
                'available' => 'No entries found for the selected source(s).'
            ],
            '.arpa' => [
                'server' => 'whois.iana.org',
                'available' => 'not found'
            ],
            '.as' => [
                'server' => 'http://www.nic.as/whois.cfm?domain=',
                'available' => 'Domain not found'
            ],
            '.asia' => [
                'server' => 'whois.nic.asia',
                'available' => 'NOT FOUND'
            ],
            '.au' => [
                'server' => 'whois-check.ausregistry.net.au',
                'available' => 'Available',
                'strict' => true
            ],
            '.be' => [
                'server' => 'whois.dns.be',
                'available' => "Status:\tAVAILABLE"
            ],
            '.bg' => [
                'server' => 'whois.register.bg',
                'available' => 'does not exist'
            ],
            '.br' => [
                'server' => 'whois.registro.br',
                'available' => 'No match for'
            ],
            '.bs' => [
                'server' => 'http://register.bs/cgi-bin/search.pl?name=',
                'available' => 'has not yet been Registered'
            ],
            '.bw' => [
                'server' => 'http://secure.coccaregistry.net/modules/addons/eppregistrarmanager/domaincheck.php?domain=',
                'available' => 'Not Registered'
            ],
            '.biz' => [
                'server' => 'whois.neulevel.biz',
                'available' => 'Not found:'
            ],
            '.ca' => [
                'server' => 'whois.cira.ca',
                'available' => 'status:         available'
            ],
            '.ch' => [
                'server' => 'whois.nic.ch',
                'available' => 'We do not have an entry'
            ],
            '.ci' => [
                'server' => 'whois.nic.ci',
                'available' => 'not found'
            ],
            '.cl' => [
                'server' => 'whois.nic.cl',
                'available' => 'no exist'
            ],
            '.cn' => [
                'server' => 'whois.cnnic.cn',
                'available' => 'no matching record'
            ],
            '.co' => [
                'server' => 'whois.nic.co',
                'available' => 'Not found:'
            ],
            '.cv' => [
                'server' => 'http://www.dns.cv/tldcv_si/do?com=DS;4186362310;online.200002;+PAGE(online.300110)+RCNT(100)+F_WHOIS(',
                'available' => 'Domain name not found / Nick-handle not found'
            ],
            '.com' => [
                'server' => 'whois.crsnic.net',
                'available' => 'No match for',
                'request' => 'domain '
            ],
            '.cc' => [
                'server' => 'whois.nic.cc',
                'available' => 'No match'
            ],
            '.cm' => [
                'server' => 'whois.netcom.cm',
                'available' => 'Not Registered'
            ],
            '.cx' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.cz' => [
                'server' => 'whois.nic.cz',
                'available' => 'no entries found'
            ],
            '.co.cz' => [
                'server' => 'whois.i-registry.cz',
                'available' => 'no entries found'
            ],
            '.de' => [
                'server' => 'whois.denic.de',
                'available' => 'free'
            ],
            '.com.de' => [
                'server' => 'whois.centralnic.com',
                'available' => 'free'
            ],
            '.ae.org' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.ar.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.br.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.cn.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.de.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.eu.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.gb.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.gb.net' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.gr.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.hu.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.hu.net' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.jp.net' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.jpn.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.kr.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.no.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.qc.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.ru.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.sa.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.se.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.se.net' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.uk.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.uk.net' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.us.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.us.org' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.uy.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.za.com' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.dk' => [
                'server' => 'whois.dk-hostmaster.dk',
                'available' => 'No entries found'
            ],
            '.dm' => [
                'server' => 'whois.nic.dm',
                'available' => 'not found...'
            ],
            '.my' => [
                'server' => 'whois.mynic.net.my',
                'available' => 'does not exist in database'
            ],
            '.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.com.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=com.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.art.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=art.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.net.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=net.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.gov.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=gov.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.gob.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=gob.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.org.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=org.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.edu.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=edu.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.sld.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=sld.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.mil.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=mil.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.web.do' => [
                'server' => 'http://www.nic.do/whoisingles.php3?dns_answer=&do=web.do&B1=Query&T1=',
                'available' => 'This domain doesn\'t exist',
                'domain_only' => true
            ],
            '.ec' => [
                'server' => 'whois.nic.ec',
                'available' => 'Not Registered'
            ],
            '.ee' => [
                'server' => 'whois.eenet.ee',
                'available' => 'No entries found'
            ],
            '.eu' => [
                'server' => 'whois.eu',
                'available' => 'Status:    AVAILABLE'
            ],
            '.edu' => [
                'server' => 'whois.internic.net',
                'available' => 'No match for'
            ],
            '.fi' => [
                'server' => 'whois.ficora.fi',
                'available' => 'Domain not found'
            ],
            '.fj' => [
                'server' => 'whois.usp.ac.fj',
                'available' => 'was not found'
            ],
            '.fr' => [
                'server' => 'whois.nic.fr',
                'available' => 'No entries found in the AFNIC Database'
            ],
            '.ga' => [
                'server' => 'whois.dot.ga',
                'available' => 'domain name not known'
            ],
            '.gd' => [
                'server' => 'whois.nic.gd',
                'available' => 'not found...'
            ],
            '.gg' => [
                'server' => 'whois.channelisles.net',
                'available' => 'Not Registered'
            ],
            '.gi' => [
                'server' => 'whois2.afilias-grs.net',
                'available' => 'NOT FOUND'
            ],
            '.gs' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.gt' => [
                'server' => 'http://www.gt/cgi-bin/whois.cgi?domain=',
                'available' => 'DOMINIO NO REGISTRADO'
            ],
            '.gy' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.hk' => [
                'server' => 'whois.hkirc.hk',
                'available' => 'The domain has not been registered'
            ],
            '.hr' => [
                'server' => 'http://whois.com.hr/domena/',
                'available' => 'nije registrirana'
            ],
            '.hn' => [
                'server' => 'http://secure.coccaregistry.net/modules/addons/eppregistrarmanager/domaincheck.php?domain=',
                'available' => 'Not Registered'
            ],
            '.hu' => [
                'server' => 'whois.nic.hu',
                'available' => 'No match'
            ],
            '.ie' => [
                'server' => 'whois.domainregistry.ie',
                'available' => 'Not Registered'
            ],
            '.il' => [
                'server' => 'whois.isoc.org.il',
                'available' => 'No data was found'
            ],
            '.in' => [
                'server' => 'whois.inregistry.net',
                'available' => 'NOT FOUND'
            ],
            '.info' => [
                'server' => 'whois.afilias.net',
                'available' => 'NOT FOUND'
            ],
            '.io' => [
                'server' => 'http://www.nic.io/cgi-bin/whois?query=',
                'available' => 'This Domain is'
            ],
            '.ir' => [
                'server' => 'whois.nic.ir',
                'available' => 'no entries found'
            ],
            '.is' => [
                'server' => 'whois.isnic.is',
                'available' => 'No entries found'
            ],
            '.it' => [
                'server' => 'whois.nic.it',
                'available' => 'AVAILABLE'
            ],
            '.jp' => [
                'server' => 'whois.jprs.jp',
                'available' => 'No match!!'
            ],
            '.je' => [
                'server' => 'whois.channelisles.net',
                'available' => 'Not Registered'
            ],
            '.ke' => [
                'server' => 'whois.kenic.or.ke',
                'available' => 'Not Registered'
            ],
            '.ki' => [
                'server' => 'whois.nic.ki',
                'available' => 'Status: Available'
            ],
            '.kr' => [
                'server' => 'whois.nic.or.kr',
                'available' => 'not registered'
            ],
            '.kz' => [
                'server' => 'whois.nic.kz',
                'available' => 'Nothing found'
            ],
            '.la' => [
                'server' => 'whois.nic.la',
                'available' => 'NOT FOUND'
            ],
            '.lb' => [
                'server' => 'http://www.aub.edu.lb/cgi-bin/lbdr.pl?B1=Search&cn=',
                'available' => 'No matching entries in root domain'
            ],
            '.lt' => [
                'server' => 'whois.domreg.lt',
                'available' => "Status:            available"
            ],
            '.li' => [
                'server' => 'whois.nic.li',
                'available' => 'We do not have an entry'
            ],
            '.lk' => [
                'server' => 'whois.nic.lk',
                'available' => 'This Domain is not available in our whois database'
            ],
            '.ls' => [
                'server' => 'http://www.co.ls/co.asp?CT_DNS_NAME=',
                'available' => 'No records returned.'
            ],
            '.lu' => [
                'server' => 'whois.dns.lu',
                'available' => 'No such domain'
            ],
            '.lv' => [
                'server' => 'whois.nic.lv',
                'available' => 'Status: free'
            ],
            '.ly' => [
                'server' => 'whois.nic.ly',
                'available' => 'Not found'
            ],
            '.ma' => [
                'server' => 'whois.iam.net.ma',
                'available' => 'No Objects Found'
            ],
            '.me' => [
                'server' => 'whois.nic.me',
                'available' => 'NOT FOUND'
            ],
            '.mg' => [
                'server' => 'whois.nic.mg',
                'available' => 'Available'
            ],
            '.ms' => [
                'server' => 'whois.nic.ms',
                'available' => 'Available'
            ],
            '.mx' => [
                'server' => 'whois.mx',
                'available' => 'Object_Not_Found'
            ],
            '.mobi' => [
                'server' => 'whois.dotmobiregistry.net',
                'available' => 'NOT FOUND'
            ],
            '.moe' => [
                'server' => 'whois.nic.moe',
                'available' => 'Not found'
            ],
            '.name' => [
                'server' => 'whois.nic.name',
                'available' => 'No match'
            ],
            '.na' => [
                'server' => 'whois.na-nic.com.na',
                'available' => 'Status: Not Registered'
            ],
            '.no' => [
                'server' => 'whois.norid.no',
                'available' => '% No match'
            ],
            '.co.no' => [
                'server' => 'whois.co.no',
                'available' => 'AVAILABLE'
            ],
            '.nu' => [
                'server' => 'whois.nic.nu',
                'available' => 'NO MATCH for domain'
            ],
            '.nl' => [
                'server' => 'whois.domain-registry.nl',
                'available' => 'is free'
            ],
            '.nz' => [
                'server' => 'whois.srs.net.nz',
                'available' => '220 Available'
            ],
            '.pa' => [
                'server' => 'http://www.nic.pa/whois.php?nombre_d=',
                'available' => 'El dominio'
            ],
            '.org' => [
                'server' => 'whois.publicinterestregistry.net',
                'available' => 'NOT FOUND'
            ],
            '.pe' => [
                'server' => 'kero.yachay.pe',
                'available' => 'Not Registered'
            ],
            '.pl' => [
                'server' => 'whois.dns.pl',
                'available' => 'No information available about domain'
            ],
            '.pm' => [
                'server' => 'whois.nic.pm',
                'available' => 'No entries found'
            ],
            '.pr' => [
                'server' => 'whois.nic.pr',
                'available' => 'available'
            ],
            '.pro' => [
                'server' => 'whois.registry.pro',
                'available' => 'NOT FOUND'
            ],
            '.ru' => [
                'server' => 'whois.ripn.net',
                'available' => 'No entries found',
                'expiry' => 'free-date',
            ],
            '.ro' => [
                'server' => 'whois.rotld.ro',
                'available' => 'No entries found'
            ],
            '.rs' => [
                'server' => 'whois.rnids.rs',
                'available' => '%ERROR:103: Domain is not registered'
            ],
            '.re' => [
                'server' => 'whois.nic.re',
                'available' => 'No entries found'
            ],
            '.sa' => [
                'server' => 'whois.nic.net.sa',
                'available' => 'No match'
            ],
            '.se' => [
                'server' => 'whois.iis.se',
                'available' => 'not found.'
            ],
            '.sc' => [
                'server' => 'whois2.afilias-grs.net',
                'available' => 'NOT FOUND'
            ],
            '.sg' => [
                'server' => 'whois.nic.net.sg',
                'available' => 'Domain Not Found'
            ],
            '.sh' => [
                'server' => 'http://www.nic.sh/cgi-bin/whois?query=',
                'available' => 'This Domain is'
            ],
            '.si' => [
                'server' => 'whois.arnes.si',
                'available' => 'No entries found'
            ],
            '.st' => [
                'server' => 'whois.nic.st',
                'available' => 'No entries found'
            ],
            '.tel' => [
                'server' => 'whois.nic.tel',
                'available' => 'Not found:'
            ],
            '.tc' => [
                'server' => 'whois.adamsnames.tc',
                'available' => 'not registered'
            ],
            '.tf' => [
                'server' => 'whois.nic.tf',
                'available' => 'No entries found'
            ],
            '.tk' => [
                'server' => 'whois.dot.tk',
                'available' => 'domain name not known'
            ],
            '.tl' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.tm' => [
                'server' => 'http://www.nic.tm/cgi-bin/whois?query=',
                'available' => 'This Domain is'
            ],
            '.tr' => [
                'server' => 'whois.nic.tr',
                'available' => 'No match found'
            ],
            '.tw' => [
                'server' => 'whois.twnic.net.tw',
                'available' => 'No Found'
            ],
            '.tz' => [
                'server' => 'whois.tznic.or.tz',
                'available' => 'ERROR:101: no entries found'
            ],
            '.tv' => [
                'server' => 'tvwhois.verisign-grs.com',
                'available' => 'No match for'
            ],
            '.travel' => [
                'server' => 'whois.nic.travel',
                'available' => 'Not found:'
            ],
            '.ua' => [
                'server' => 'whois.ua',
                'available' => '% No entries found'
            ],
            '.us' => [
                'server' => 'whois.nic.us',
                'available' => 'Not found:'
            ],
            '.uk' => [
                'server' => 'whois.nic.uk',
                'available' => 'No match for'
            ],
            '.ug' => [
                'server' => 'whois.co.ug',
                'available' => 'No entries found'
            ],
            '.uz' => [
                'server' => 'whois.cctld.uz',
                'available' => 'not found in database'
            ],
            '.vc' => [
                'server' => 'whois2.afilias-grs.net',
                'available' => 'NOT FOUND'
            ],
            '.ve' => [
                'server' => 'whois.nic.ve',
                'available' => 'No match for'
            ],
            '.vg' => [
                'server' => 'whois.adamsnames.tc',
                'available' => 'not registered'
            ],
            '.vu' => [
                'server' => 'http://www.vunic.vu/whois?',
                'available' => 'No match for domain'
            ],
            '.wf' => [
                'server' => 'whois.nic.wf',
                'available' => 'No entries found'
            ],
            '.ws' => [
                'server' => 'whois.worldsite.ws',
                'available' => 'No match for'
            ],
            '.yt' => [
                'server' => 'whois.nic.yt',
                'available' => 'No entries found'
            ],
            '.coop' => [
                'server' => 'whois.nic.coop',
                'available' => 'No domain records'
            ],
            '.net' => [
                'server' => 'whois.verisign-grs.com',
                'available' => 'No match for'
            ],
            '.int' => [
                'server' => 'whois.iana.org',
                'available' => 'not found'
            ],
            '.museum' => [
                'server' => 'whois.museum',
                'available' => 'NOT FOUND'
            ],
            '.za' => [
                'server' => 'http://co.za/cgi-bin/whois.sh?Domain=',
                'available' => 'No Matches'
            ],
            '.ac.za' => [
                'server' => 'http://whois.ac.za/cgi_domainquery.exe?domain=',
                'available' => 'is not registered'
            ],
            '.org.za' => [
                'server' => 'http://www.org.za/cgi-bin/rwhois?domain=',
                'available' => 'Domain not found'
            ],
            '.zw' => [
                'server' => 'http://www.zispa.org.zw/cgi-bin/search?domain=',
                'available' => 'is available for registration.'
            ],
            '.es' => [
                'server' => 'http://whois.domaintools.com/',
                'available' => 'This domain name is not registered'
            ],
            '.ph' => [
                'server' => 'http://www2.dot.ph/WhoIs.asp?Domain=',
                'available' => 'is still available'
            ],
            '.pk' => [
                'server' => 'http://pk6.pknic.net.pk/pk5/lookup.PK?name=',
                'available' => 'Domain not found:'
            ],
            '.pt' => [
                'server' => 'whois.dns.pt',
                'available' => 'no match'
            ],
            '.co.pt' => [
                'server' => 'whois.co.pt',
                'available' => 'no match'
            ],
            '.lta.pt' => [
                'server' => 'whois.co.pt',
                'available' => 'no match'
            ],
            '.so' => [
                'server' => 'whois.nic.so',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.ag' => [
                'server' => 'whois.nic.ag',
                'available' => "NOT FOUND"
            ],
            '.ai' => [
                'server' => 'http://whois.ai/cgi-bin/newdomain.py?domain=',
                'available' => 'not registered'
            ],
            '.fm' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.al' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.az' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.ba' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.bd' => [
                'server' => 'http://www.whois.com.bd/?query=',
                'available' => "Domain you requested does not exist."
            ],
            '.bi' => [
                'server' => 'whois1.nic.bi',
                'available' => 'Available'
            ],
            '.info.bi' => [
                'server' => 'whois.nic.bi',
                'available' => 'No match for'
            ],
            '.bj' => [
                'server' => 'whois.nic.bj',
                'available' => 'No records matching'
            ],
            '.bt' => [
                'server' => 'whois.netnames.net',
                'available' => "No match for"
            ],
            '.by' => [
                'server' => 'whois.cctld.by',
                'available' => 'Object does not exist'
            ],
            '.bz' => [
                'server' => 'whois.afilias-grs.info',
                'available' => 'NOT FOUND'
            ],
            '.cd' => [
                'server' => '41.76.213.175',
                'available' => 'Available'
            ],
            '.cf' => [
                'server' => 'whois.dot.cf',
                'available' => 'domain name not known'
            ],
            '.ck' => [
                'server' => 'whois.nic.ck',
                'available' => "No entries found "
            ],
            '.co.nl' => [
                'server' => 'whois.co.nl',
                'available' => 'AVAILABLE'
            ],
            '.cy' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.dz' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.eg' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.fo' => [
                'server' => 'whois.nic.fo',
                'available' => "ERROR:101: no entries found"
            ],
            '.gb' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.ge' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.gl' => [
                'server' => 'whois.ripe.net',
                'available' => " no entries found"
            ],
            '.gm' => [
                'server' => 'http://www.nic.gm/scripts/checkdom.asp?dname=',
                'available' => 'is still available'
            ],
            '.gov' => [
                'server' => 'whois.nic.gov',
                'available' => "No match for"
            ],
            '.gr' => [
                'server' => 'http://grwhois.ics.forth.gr:800/plainwhois/plainWhois?domainName=',
                'available' => 'not exist'
            ],
            '.hm' => [
                'server' => 'whois.registry.hm',
                'available' => "Domain not found."
            ],
            '.kg' => [
                'server' => 'whois.domain.kg',
                'available' => "Data not found."
            ],
            '.mc' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.md' => [
                'server' => 'whois.nic.md',
                'available' => "No match for"
            ],
            '.mk' => [
                'server' => 'http://reg.marnet.net.mk/registar.php?dom=',
                'available' => '.mk '
            ],
            '.ml' => [
                'server' => 'whois.dot.ml',
                'available' => 'domain name not known'
            ],
            '.mm' => [
                'server' => '61.4.68.21',
                'available' => 'Domain Not Found'
            ],
            '.mt' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.mu' => [
                'server' => 'whois.nic.mu',
                'available' => 'Available'
            ],
            '.mw' => [
                'server' => 'http://www.registrar.mw/index.php?d=0&Submit=Search&domain=',
                'available' => 'was NOT found'
            ],
            '.nf' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.sb' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.sk' => [
                'server' => 'whois.sk-nic.sk',
                'available' => "Not found."
            ],
            '.sm' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.sn' => [
                'server' => 'http://whois.nic.sn/whois.php?domain=',
                'available' => 'Ce domaine n\'existe pas'
            ],
            '.su' => [
                'server' => 'whois.tcinet.ru',
                'available' => 'No entries found'
            ],
            '.sx' => [
                'server' => 'whois.sx',
                'available' => 'AVAILABLE'
            ],
            '.tn' => [
                'server' => 'whois.tn',
                'available' => 'not found'
            ],
            '.to' => [
                'server' => 'http://www.tonic.to/whois?',
                'available' => 'No match for domain'
            ],
            '.uy' => [
                'server' => 'nic.uy',
                'available' => "No match for"
            ],
            '.va' => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.xxx' => [
                'server' => 'whois.nic.xxx',
                'available' => "NOT FOUND"
            ],
            '.xyz' => [
                'server' => 'whois.nic.xyz',
                'available' => "DOMAIN NOT FOUND"
            ],
            '.yu'
            => [
                'server' => 'whois.ripe.net',
                'available' => "no entries found"
            ],
            '.ht' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.info.ht' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.net.ht' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.org.ht' => [
                'server' => 'whois.coccaregistry.org',
                'available' => 'Available'
            ],
            '.qa' => [
                'server' => 'whois.registry.qa',
                'available' => 'No Data Found ' // server was down temorary
            ],
            '.lc' => [
                'server' => 'whois.afilias-grs.info',
                'available' => 'NOT FOUND'
            ],
            '.im' => [
                'server' => 'whois.nic.im',
                'available' => 'was not found'
            ],
            '.mn' => [
                'server' => 'whois.afilias-grs.info',
                'available' => 'NOT FOUND'
            ],
            '.ps' => [
                'server' => 'http://www.pnina.ps/domains/whois/?d=',
                'available' => 'has not been registered.'
            ],
            '.pw' => [
                'server' => 'whois.nic.pw',
                'available' => 'DOMAIN NOT FOUND',
            ],
            '.py' => [
                'server' => 'http://www.nic.py/cgi-nic/consultas/dquery?nombre_dominio=',
                'available' => 'No se encontraron datos para el dominio solicitado.'
            ],
            '.academy' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.actor' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.agency' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.audio' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.bar' => [
                'server' => 'whois.nic.bar',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.bargains' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.berlin' => [
                'server' => 'whois.nic.berlin',
                'available' => 'No match'
            ],
            '.best' => [
                'server' => 'whois.nic.best',
                'available' => 'Not found'
            ],
            '.bid' => [
                'server' => 'whois.nic.bid',
                'available' => 'Not found'
            ],
            '.bike' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.blue' => [
                'server' => 'whois.afilias.net',
                'available' => 'NOT FOUND'
            ],
            '.boutique' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.build' => [
                'server' => 'whois.nic.build',
                'available' => 'No Data Found'
            ],
            '.builders' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.buzz' => [
                'server' => 'whois.nic.buzz',
                'available' => 'Not found'
            ],
            '.cab' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.camera' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.camp' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.cards' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.careers' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.catering' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.center' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.ceo' => [
                'server' => 'whois.nic.ceo',
                'available' => 'Not found'
            ],
            '.cheap' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.christmas' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.cleaning' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.clothing' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.club' => [
                'server' => 'whois.nic.club',
                'available' => 'Not found'
            ],
            '.codes' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.coffee' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.cologne' => [
                'server' => 'whois-fe1.pdt.cologne.tango.knipp.de',
                'available' => 'no matching objects found'
            ],
            '.community' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.company' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.computer' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.construction' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.contractors' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.condos' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.cool' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.cruises' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.dance' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.dating' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.democrat' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.diamonds' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.directory' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.domains' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.education' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.email' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.enterprises' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.equipment' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.estate' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.events' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.expert' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.exposed' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.farm' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.fail' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.fish' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.flights' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.florist' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.foundation' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.futbol' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.gallery' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.gift' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.glass' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.graphics' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.guitars' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.guru' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.holdings' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.holiday' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.host' => [
                'server' => 'whois.nic.host',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.house' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.immobilien' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.industries' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.ink' => [
                'server' => 'whois.centralnic.com',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.institute' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.international' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.jetzt' => [
                'server' => 'whois.nic.jetzt',
                'available' => 'Not found'
            ],
            '.jobs' => [
                'server' => 'jobswhois.verisign-grs.com',
                'available' => 'No match for'
            ],
            '.kaufen' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.kim' => [
                'server' => 'whois.afilias.net',
                'available' => 'NOT FOUND'
            ],
            '.kitchen' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.kiwi' => [
                'server' => 'whois.dot-kiwi.com',
                'available' => 'Not Registered'
            ],
            '.koeln' => [
                'server' => 'whois-fe1.pdt.koeln.tango.knipp.de',
                'available' => 'no matching objects found'
            ],
            '.kred' => [
                'server' => 'whois.nic.kred',
                'available' => 'Not found'
            ],
            '.land' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.life' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.lighting' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.limo' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.link' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.london' => [
                'server' => 'whois-lon.mm-registry.com',
                'available' => 'Not Registered'
            ],
            '.luxury' => [
                'server' => 'whois.nic.luxury',
                'available' => 'No Data Found'
            ],
            '.management' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.mango' => [
                'server' => 'whois.mango.coreregistry.net',
                'available' => 'no matching objects found'
            ],
            '.marketing' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.media' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.menu' => [
                'server' => 'whois.nic.menu',
                'available' => 'No Data Found'
            ],
            '.moda' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.monash' => [
                'server' => 'whois.nic.monash',
                'available' => 'No Data Found'
            ],
            '.nagoya' => [
                'server' => 'whois.gmoregistry.net',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.ninja' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.nyc' => [
                'server' => 'whois.nic.nyc',
                'available' => 'Not found'
            ],
            '.okinawa' => [
                'server' => 'whois.gmoregistry.ne',
                'available' => 'Domain not found'
            ],
            '.partners' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.parts' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.photo' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.photography' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.photos' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.pics' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.pink' => [
                'server' => 'whois.afilias.net',
                'available' => 'NOT FOUND'
            ],
            '.plumbing' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.productions' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.properties' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.pub' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.qpon' => [
                'server' => 'whois.nic.qpon',
                'available' => 'Not found'
            ],
            '.recipes' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.red' => [
                'server' => 'whois.nic.red',
                'available' => 'NOT FOUND'
            ],
            '.rentals' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.repair' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.report' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.reviews' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.rich' => [
                'server' => 'whois.afilias-srs.net',
                'available' => 'NOT FOUND'
            ],
            '.ruhr' => [
                'server' => 'whois.nic.ruhr',
                'available' => 'no matching objects found'
            ],
            '.sexy' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.shiksha' => [
                'server' => 'whois.nic.shiksha',
                'available' => 'NOT FOUND'
            ],
            '.shoes' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.singles' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.social' => [
                'server' => 'whois.unitedtld.com',
                'available' => 'Domain not found'
            ],
            '.sohu' => [
                'server' => 'whois.gtld.knet.cn',
                'available' => 'No match'
            ],
            '.solar' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.solutions' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.supplies' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.supply' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.support' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.systems' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.tattoo' => [
                'server' => 'whois.uniregistry.net',
                'available' => 'is available for'
            ],
            '.technology' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.tienda' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.tips' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.today' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.tokyo' => [
                'server' => 'whois.nic.tokyo',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.tools' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.trade' => [
                'server' => 'whois.nic.trade',
                'available' => 'Not found'
            ],
            '.training' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.uno' => [
                'server' => 'whois.nic.uno',
                'available' => 'Not found'
            ],
            '.vacations' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.ventures' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.viajes' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.villas' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.vision' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.vote' => [
                'server' => 'whois.afilias.net',
                'available' => 'Domain not found'
            ],
            '.voting' => [
                'server' => 'whois.nic.voting',
                'available' => 'No match'
            ],
            '.voto' => [
                'server' => 'whois.afilias.net',
                'available' => 'Domain not found'
            ],
            '.voyage' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.wang' => [
                'server' => 'whois.gtld.knet.cn',
                'available' => 'Domain not found'
            ],
            '.watch' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.webcam' => [
                'server' => 'whois.nic.webcam',
                'available' => 'Domain not found'
            ],
            '.wed' => [
                'server' => 'whois.nic.wed',
                'available' => 'No Object Found'
            ],
            '.wien' => [
                'server' => 'whois.nic.wien',
                'available' => 'No match'
            ],
            '.wiki' => [
                'server' => 'whois.nic.wiki',
                'available' => 'DOMAIN NOT FOUND'
            ],
            '.works' => [
                'server' => 'whois.donuts.co',
                'available' => 'Domain not found'
            ],
            '.wtf' => [
                'server' => 'whois.nic.wtf',
                'available' => 'Domain not found'
            ],
            '.zone' => [
                'server' => 'whois.nic.zone',
                'available' => 'Domain not found'
            ],
        ];
        $total = count($servers);
        $progress = 0;
        Console::startProgress(0, $total, 'Initializing...');

        Server::deleteAll();

        foreach ($servers as $tld => $config) {
            $server = new Server();
            $server->tld = trim($tld, '.');
            $server->whois = $config['server'];
            $server->is_http = (int) StringHelper::startsWith($config['server'], 'http');
            $server->domain_only = (int) ArrayHelper::getValue($config, 'domain_only', false);
            $server->available_string = $config['available'];
            $server->expire_string = ArrayHelper::getValue($config, 'expiry', 'Expir');
            $server->status = Server::STATUS_NOT_LEARNED;
            $server->save();

            Console::updateProgress(++$progress, $total, 'Initializing...done.');
        }

        Console::endProgress();

        return ExitCode::OK;
    }

    public function actionLearn()
    {
        /** @var Server[] $servers */
        $servers = Server::find()->where(['status' => Server::STATUS_NOT_LEARNED])->all();
        $total = count($servers);
        $done = 0;
        Console::startProgress($done, $total, 'Learning...');

        foreach ($servers as $server) {
            $domain = 'test' . Yii::$app->security->generateRandomString(8) . '.' . $server->tld;
            Console::updateProgress(++$done, $total, "Learning zone '.{$server->tld}'");
            Whois::instance()->check($domain, false);
        }

        Console::endProgress('Learning...done.');

        return ExitCode::OK;
    }
}
