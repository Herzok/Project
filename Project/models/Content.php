<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property int $id_content
 * @property int $id_user
 * @property string $title
 * @property string $text
 * @property string $password
 * @property string $link
 *
 * @property AccessContent[] $accessContents
 * @property Users $user
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user'], 'integer'],
            [['title', 'text', 'password', 'link'], 'string', 'max' => 200],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id_user']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_content' => 'Id Content',
            'id_user' => 'Id User',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'password' => 'Пароль',
            'link' => 'Ссылка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessContents()
    {
        return $this->hasMany(AccessContent::className(), ['id_content' => 'id_content']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'id_user']);
    }
}
