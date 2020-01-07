<?php

namespace app\models;

use Yii;
use Ramsey\Uuid\Uuid;
/**
 * This is the model class for table "project_list".
 *
 * @property int $id
 * @property string $guid
 * @property int $client_list_id
 * @property string $project_title
 * @property string $contract_price
 * @property string $deposit_percent
 * @property string $retention_percent
 * @property string $deposit_amount
 * @property string $retention_amount
 * @property string $project_ref_id
 * @property string $start_date
 * @property string $end_date
 * @property int $created_by
 * @property string $created_date
 * @property int $updated_by
 * @property string $updated_date
 * @property int $is_active
 */
class ProjectList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_title','location','contract_price','deposit_amount','retention_amount'], 'required'],
            [['client_list_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['project_title','location'], 'string'],
            [['contract_price', 'deposit_amount', 'retention_amount'], 'number'],
            [['start_date', 'end_date', 'created_date', 'updated_date'], 'safe'],
            [['guid'], 'string', 'max' => 36],
            [['deposit_percent', 'retention_percent', 'project_ref_id'], 'string', 'max' => 45],
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
            'client_list_id' => 'Client Name',
            'project_title' => 'Project Title',
            'contract_price' => 'Contract Price',
            'deposit_percent' => 'Deposit Percent',
            'retention_percent' => 'Retention Percent',
            'deposit_amount' => 'Deposit Amount',
            'retention_amount' => 'Retention Amount',
            'project_ref_id' => 'Project Ref ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
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
            $series = \app\models\Series::findOne(2);
            $series->series = sprintf('%04d', $series->series  + 1);
            $this->project_ref_id = "FBCDC-PID-". date('Y') . '-' . $series->series;
            $series->save(false);
        }
        $this->updated_by = Yii::$app->user->id;
        $this->updated_date = date('Y-m-d');

        return true;
    }

    public function getClient()
    {
        return $this->hasOne(ClientList::className(), ['id' => 'client_list_id']);
    }

    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function computeProgress($pid)
    {
        $result = 0.0000;
        $data = \app\models\BillingList::find()->where(['project_list_id'=>$pid,'bill_status_id'=>[2,3]])->all();
        foreach($data as $row)
        {
            $result += $row->progress_percent;
        }
        return $result . '%';
    }
}
