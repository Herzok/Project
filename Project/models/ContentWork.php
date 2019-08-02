<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Content;
use yii\db\Query;

class ContentWork extends Content
{
    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['id_content', 'id_user'], 'integer'],
            [['title', 'text', 'password', 'link'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_receiver($params)
    {
        $query = (new Query())
            ->select (['content.id_content','content.title','content.link','users.name'])
            ->from('access_content')
            ->join ('INNER JOIN','content','content.id_content = access_content.id_content')
            ->join ('INNER JOIN','users','users.id_user = access_content.sender_id')
            ->where(['access_content.receiver_id'=> Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }

    public function search($params)
    {
        $query = (new Query())
            ->select (['content.id_content','content.title','content.text','content.link'])
            ->from('content')
            ->join('INNER JOIN','users','content.id_user = users.id_user')
            ->where(['users.id_user'=> Yii::$app->user->id]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }
}