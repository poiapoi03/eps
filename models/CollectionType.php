<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collection_type".
 *
 * @property int $id
 * @property string $description
 * @property int $is_active
 */
class CollectionType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'integer'],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'is_active' => 'Is Active',
        ];
    }
}
