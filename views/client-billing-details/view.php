<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BillingDetails */
?>
<div class="billing-details-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'guid',
            'billing_list_id',
            'collection_type_id',
            'amount',
            'remarks:ntext',
        ],
    ]) ?>

</div>
