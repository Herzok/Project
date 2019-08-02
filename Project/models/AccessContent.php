<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access_content".
 *
 * @property int $id_access_content
 * @property int $id_content
 * @property int $sender_id
 * @property int $receiver_id
 *
 * @property Content $content
 * @property Users $sender
 * @property Users $receiver
 */
class AccessContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_content', 'sender_id', 'receiver_id'], 'required'],
            [['id_content', 'sender_id', 'receiver_id'], 'integer'],
            [['id_content'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['id_content' => 'id_content']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender_id' => 'id_user']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['receiver_id' => 'id_user']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_access_content' => 'Id Access Content',
            'id_content' => 'Id Content',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id_content' => 'id_content']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'sender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'receiver_id']);
    }
}
