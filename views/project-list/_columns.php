<?php
use yii\helpers\Url;

use yii\helpers\Html;
return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'guid',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'client_list_id',
        'value'=>function($model){ return $model->client->company_name . '<br>' .$model->client->client_name; },
        'format'=>'html'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'project_title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'contract_price',
        'format'=>['decimal',2]
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'deposit_percent',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'retention_percent',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'deposit_amount',
        'format'=>['decimal',2]
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'retention_amount',
        'format'=>['decimal',2]
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'project_ref_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header'=>'Progress Percent',
        'value'=>function($model){ return $model->computeProgress($model->id); } 
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'end_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'is_active',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'header'=>'View',
        'template'=>'{view}',
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'header'=>'Update',
        'template'=>'{update}',
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>'{user}',
        'header'=>'Billing List',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
            'user' => function($url, $model, $key) {     // render your custom button
                return Html::a('<i class="fa fa-bitcoin fa-fw"></i>',['/billing-list/','pid'=>$model->guid],['data-pjax'=>0,'class'=>'btn btn-success']);
            }
        ]
      
    ],

];   