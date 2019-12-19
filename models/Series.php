<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "series".
 *
 * @property int $id
 * @property int $type 1-Client, 2-Project
 * @property string $series
 */
class Series extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'series';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'series'], 'required'],
            [['type'], 'integer'],
            [['series'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'series' => 'Series',
        ];
    }
}
