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
            [['address','contact_no','first_name','last_name','email','contact_no','address','address2','city','province','country'], 'required'],
            [['client_name','address','first_name','last_name','name_prefix','middle_name','company_name','ext_name','address','address2','city','province'], 'filter', 'filter'=>'strtoupper'],
            [['contact_no', 'address', 'address2'], 'string'],
            [['created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['guid'], 'string', 'max' => 36],
            [['client_name', 'email', 'city', 'province'], 'string', 'max' => 100],
            [['company_name', 'last_name', 'first_name', 'middle_name'], 'string', 'max' => 200],
            [['country', 'zipCode', 'ext_name'], 'string', 'max' => 10],
            [['client_ref_id'], 'string', 'max' => 45],
            [['name_prefix'], 'string', 'max' => 20],
            ['email','email'],
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
            'address' => 'Address 1',
            'address2' => 'Address 2',
            'city' => 'City',
            'province' => 'Province',
            'country' => 'Country',
            'zipCode' => 'Zip Code',
            'client_ref_id' => 'Client Ref ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'is_active' => 'Is Active',
            'name_prefix' => 'Name Prefix',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'ext_name' => 'Extension Name',
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

        //set client_name
        $prefix = $this->name_prefix != '' ? $this->name_prefix . ' ' : '';
        $mname =  $this->middle_name != '' ? $this->middle_name . ' ' : '';
        $extname = $this->ext_name != '' ? ' '. $this->ext_name  : '';

        $this->client_name = strtoupper($prefix . $this->first_name . ' ' . $mname . $this->last_name . $extname);

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

    public function getCompleteAddress()
    {
        return $this->address . ' ' . $this->address2 . ' ' . $this->city . ' ' . $this->province . ' '. $this->zipCode;
    }
}
