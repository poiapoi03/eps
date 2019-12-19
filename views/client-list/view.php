<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ClientList */
?>
<div class="client-list-view">

 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           # 'id',
            'client_name',
            'company_name',
            'contact_no:ntext',
            'email:ntext',
            'address',
            'client_ref_id',
            [                    
                'label' => 'Created By',
                'value' => $model->createdByUser->username,
            ],
            'created_date',
            [                    
                'label' => 'Created By',
                'value' => $model->updatedByUser->username,
            ],
            'updated_date',
        ],
    ]) ?>

</div>
