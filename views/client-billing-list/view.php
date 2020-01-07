<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BillingList */
?>
<div class="billing-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'guid',
            'project_list_id',
            'progress_percent',
            'billing_no',
            'billing_date',
            'bill_status_id',
            'payment_mode_id',
            'payment_date',
            'payment_reference:ntext',
            'prepared_by',
            'noted_by',
            'checked_by',
            'created_by',
            'created_date',
            'updated_by',
            'updated_date',
            'is_active',
        ],
    ]) ?>

</div>
