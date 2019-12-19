<?php

namespace app\models;

use Yii;
use Ramsey\Uuid\Uuid;
/**
 * This is the model class for table "billing_details".
 *
 * @property int $id
 * @property string $guid
 * @property int $billing_list_id
 * @property int $collection_type_id
 * @property string $amount
 * @property string $remarks
 */
class BillingDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'billing_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['billing_list_id', 'collection_type_id'], 'integer'],
            [['amount'], 'number'],
            [['remarks'], 'string'],
            [['guid'], 'string', 'max' => 36],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'billing_list_id' => 'Billing List ID',
            'collection_type_id' => 'Collection Type ID',
            'amount' => 'Amount',
            'remarks' => 'Remarks',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->guid = Uuid::uuid4();
            
        }

        return true;
    }

    public function getBillingList()
    {
        return $this->hasOne(BillingList::className(), ['id' => 'billing_list_id']);
    }

    public function getCollectionType()
    {
        return $this->hasOne(CollectionType::className(), ['id' => 'collection_type_id']);
    }
}
