<?php

namespace app\models;

use Yii;
use Ramsey\Uuid\Uuid;
/**
 * This is the model class for table "client_list".
 *
 * @property int $id
 * @property string $client_name
 * @property string $company_name
 * @property string $contact_no
 * @property int $address
 * @property string $client_ref_id
 * @property int $created_by
 * @property string $created_date
 * @property int $updated_by
 * @property string $updated_date
 */
class ClientList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_name','address','contact_no'], 'required'],
            [['contact_no','address'], 'string'],
            [['email'], 'email'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date','is_active'], 'safe'],
            [['client_name'], 'string', 'max' => 100],
            [['company_name'], 'string', 'max' => 200],
            [['client_ref_id'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_name' => 'Client Name',
            'company_name' => 'Client Company Name',
            'contact_no' => 'Contact Number/s',
            'address' => 'Address',
            'client_ref_id' => 'Client Ref ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->id;
            $this->created_date = date('Y-m-d');
            $this->guid = Uuid::uuid4();
            $series = \app\models\Series::findOne(1);
            $series->series = sprintf('%04d', $series->series  + 1);
            $this->client_ref_id = "FBCDC-CID-". date('Y') . '-' . $series->series;
            $series->save(false);
        }
        $this->updated_by = Yii::$app->user->id;
        $this->updated_date = date('Y-m-d');

        return true;
    }

    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
