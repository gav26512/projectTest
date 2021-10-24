<?php

namespace app\models\records;

use Yii;

/**
 * This is the model class for table "requests_landing".
 *
 * @property int $id
 * @property string $url url запроса
 * @property string $date_request Дата запроса
 */
class RequestsLanding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requests_landing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'date_request'], 'required'],
            [['date_request'], 'safe'],
            [['url'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'date_request' => 'Date Request',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\RequestsLandingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\RequestsLandingQuery(get_called_class());
    }
}
