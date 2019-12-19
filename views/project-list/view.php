<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectList */
?>
<div class="project-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'id',
            #'guid',
            [                     
                'label' => 'Client',
                'value' => $model->client->company_name . '<br>' .$model->client->client_name,
                'format'=>'html'
            ],
            'project_title:ntext',
            [                      
                'label' => 'Contract Price',
                'value' => $model->contract_price,
                'format'=>['decimal',2]
            ],
         
            'deposit_percent',
            'retention_percent',
            
            [                      
                'label' => 'Deposit Amount',
                'value' => $model->deposit_amount,
                'format'=>['decimal',2]
            ],

            [                      
                'label' => 'Retention Amount',
                'value' => $model->retention_amount,
                'format'=>['decimal',2]
            ],
            'project_ref_id',
            'start_date',
            'end_date',
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
            'is_active',
        ],
    ]) ?>

</div>
