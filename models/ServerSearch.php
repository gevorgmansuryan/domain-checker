<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class ServerSearch extends Server
{
    public function rules()
    {
        return [
            [['tld', 'whois', 'status'], 'trim'],
            [['tld', 'whois'], 'string', 'max' => 255],
            [['status'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'AND',
            ['like', 'tld', $this->tld],
            ['like', 'whois', $this->whois],
            ['=', 'status', $this->status],
        ]);

        return $dataProvider;
    }
}
