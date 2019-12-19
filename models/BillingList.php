<?php

namespace app\models;

use Yii;

use Ramsey\Uuid\Uuid;
/**
 * This is the model class for table "billing_list".
 *
 * @property int $id
 * @property string $guid
 * @property int $project_list_id
 * @property string $progress_percent
 * @property int $billing_no
 * @property string $billing_date
 * @property int $bill_status_id
 * @property int $payment_mode_id
 * @property string $payment_date
 * @property string $payment_reference
 * @property string $prepared_by
 * @property string $noted_by
 * @property string $checked_by
 * @property int $created_by
 * @property string $created_date
 * @property int $updated_by
 * @property string $updated_date
 * @property int $is_active
 */
class BillingList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'billing_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['progress_percent'], 'required'],
            [['project_list_id', 'billing_no', 'bill_status_id', 'payment_mode_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['progress_percent'], 'number'],
            [['billing_date', 'payment_date', 'created_date', 'updated_date'], 'safe'],
            [['payment_reference','remarks'], 'string'],
            [['guid'], 'string', 'max' => 36],
            [['prepared_by', 'noted_by', 'checked_by'], 'string', 'max' => 100],
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
            'project_list_id' => 'Project List ID',
            'progress_percent' => 'Progress Percent',
            'billing_no' => 'Billing No',
            'billing_date' => 'Billing Date',
            'bill_status_id' => 'Bill Status ID',
            'payment_mode_id' => 'Payment Mode ID',
            'payment_date' => 'Payment Date',
            'payment_reference' => 'Payment Reference',
            'prepared_by' => 'Prepared By',
            'noted_by' => 'Noted By',
            'checked_by' => 'Checked By',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'is_active' => 'Is Active',
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
        }
        $this->updated_by = Yii::$app->user->id;
        $this->updated_date = date('Y-m-d');

        
        

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {

        if (parent::afterSave($insert, $changedAttributes)) {

            // some serious cache deleting here

            return true;

        }

        $cType = \app\models\CollectionType::find()->where(['id'=>[1,2,3]])->all();
        foreach($cType as $row)
        {
            $model = BillingDetails::findOne(['collection_type_id'=>$row->id,'billing_list_id'=>$this->id]);
            if($model == null){
                $model = new BillingDetails;
                    
                $model->guid = Uuid::uuid4();
                $model->billing_list_id = $this->id;
                $model->collection_type_id	= $row->id;
            }
         

            switch($row->id)
            {
                case 1: $model->amount = ($this->project->contract_price * $this->progress_percent) / 100;
                        $model->remarks = number_format($this->project->contract_price,2) . ' X ' . $this->progress_percent .'%';
                        break;        
                case 2: $progress_bill = ($this->project->contract_price * $this->progress_percent) / 100;
                        
                        $model->amount = ($progress_bill * $this->project->deposit_percent) / 100;
                        $model->remarks = number_format($this->project->contract_price,2) . ' X ' . $this->progress_percent .'% X ' .  $this->project->deposit_percent.'%';
                        break;        
                case 3: $progress_bill = ($this->project->contract_price * $this->progress_percent) / 100;
                        
                        $model->amount = ($progress_bill * $this->project->retention_percent) / 100;

                        $model->remarks = number_format($this->project->contract_price,2) . ' X ' . $this->progress_percent .'% X ' .  $this->project->retention_percent.'%';
                        break;        
            }
            $model->save(false);
        }

        return false;

    }


    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getProject()
    {
        return $this->hasOne(ProjectList::className(), ['id' => 'project_list_id']);
    }


    public function getBillStatus()
    {
        return $this->hasOne(BillStatus::className(), ['id' => 'bill_status_id']);
    }

    public function getBillDetails()
    {
        return $this->hasMany(BillingDetails::className(), ['billing_list_id' => 'id']);
    }

    public function computeDueAmount($blid)
    {

        $progress = (new \yii\db\Query())
            ->select(['a.amount'])
            
            ->from('billing_details a')
            ->leftJoin('collection_type b', 'a.collection_type_id = b.id')
            ->where([
                'a.billing_list_id' => $blid,
                'b.deductible'=>0,
            ])
            ->sum('a.amount');
    
        $deductibles = (new \yii\db\Query())
            ->select(['a.amount'])
            
            ->from('billing_details a')
            ->leftJoin('collection_type b', 'a.collection_type_id = b.id')
            ->where([
                'a.billing_list_id' => $blid,
                'b.deductible'=>1,
            ])
            ->sum('a.amount');
    

        return $progress - $deductibles;     
    }
}
