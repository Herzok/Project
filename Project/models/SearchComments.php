<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comments;

/**
 * SearchComments represents the model behind the search form of `app\models\FileComments`.
 */
class SearchComments extends Comments
{
    public $verifyCode;
    public function rules()
    {
        return [
            [['id_comments'], 'integer'],
            [['text','date','nickname'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'text' => 'Комментарий',
            'nickname' => 'Никнейм',
            'verifyCode' => 'Верификация',
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Comments::find()
            ->orderBy('comments.date DESC');

        // add conditions that should always apply here

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
}