<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_settings".
 *
 * @property int $id
 * @property string $bank_account_no
 * @property string $prepared_by
 * @property string $prepared_by_position
 * @property string $noted_by
 * @property string $noted_by_position
 * @property string $checked_by
 * @property string $checked_by_position
 * @property string $default_deposit
 * @property string $default_retention
 * @property string $billing_contact_person
 * @property string $billing_contact_no
 */
class SystemSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bank_account_no', 'default_deposit', 'default_retention'], 'string', 'max' => 45],
            [['prepared_by', 'prepared_by_position', 'noted_by', 'noted_by_position', 'checked_by', 'checked_by_position', 'billing_contact_person', 'billing_contact_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_account_no' => 'Bank Account No',
            'prepared_by' => 'Prepared By',
            'prepared_by_position' => 'Prepared By Position',
            'noted_by' => 'Noted By',
            'noted_by_position' => 'Noted By Position',
            'checked_by' => 'Checked By',
            'checked_by_position' => 'Checked By Position',
            'default_deposit' => 'Default Deposit',
            'default_retention' => 'Default Retention',
            'billing_contact_person' => 'Billing Contact Person',
            'billing_contact_no' => 'Billing Contact No',
        ];
    }
}
