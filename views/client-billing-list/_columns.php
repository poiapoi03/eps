<?php
use yii\helpers\Url;
use yii\web\View; 
use yii\helpers\Html;

use kartik\grid\GridView;
return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'guid',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'project_list_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'billing_no',
        'width'=>'10px',
        'hAlign'=>'center'

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'progress_percent',
        'pageSummary' => $model->computeProgress($model->id),
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'billing_date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'bill_status_id',
        'value'=>function($model){ return $model->billStatus->description; }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header'=>'Amount Due',
        'value'=>function($model){ 
            return $model->computeDueAmount($model->id);
         },
         'format'=>['decimal',2]

    ],
    
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'payment_mode_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'payment_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'payment_reference',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'prepared_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'noted_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'checked_by',
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
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'header'=>'Update',
    //     'template'=>'{update}',
    //     'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
    //     'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
    //     'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
    //                       'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
    //                       'data-request-method'=>'post',
    //                       'data-toggle'=>'tooltip',
    //                       'data-confirm-title'=>'Are you sure?',
    //                       'data-confirm-message'=>'Are you sure want to delete this item'], 
    // ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'header'=>'Delete',
    //     'template'=>'{delete}',
    //     'visibleButtons' => [
    //         'delete' => function ($model) {
    //             return $model->bill_status_id == 1;
    //         },
    //     ],
    //     'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
    //     'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
    //     'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 'class'=>'btn btn-danger',
    //                       'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
    //                       'data-request-method'=>'post',
    //                       'data-toggle'=>'tooltip',
    //                       'data-confirm-title'=>'Are you sure?',
    //                       'data-confirm-message'=>'Are you sure want to delete this item'], 
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$model->guid]);
        },
        'header'=>'View Details',
        'template'=>'{view}',
        // 'visibleButtons' => [
        //     'delete' => function ($model) {
        //         return $model->bill_status_id == 1;
        //     },
        // ],
        'viewOptions'=>['data-pjax'=>0,'title'=>'View','data-toggle'=>'tooltip','class'=>'btn btn-primary'],
        // 'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        // 'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 'class'=>'btn btn-danger',
        //                   'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
        //                   'data-request-method'=>'post',
        //                   'data-toggle'=>'tooltip',
        //                   'data-confirm-title'=>'Are you sure?',
        //                   'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'template'=>'{user}',
    //     'header'=>'Billing<br>Breakdown',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'buttons' => [
    //         'user' => function($url, $model, $key) {     // render your custom button
    //             return Html::a('<i class="fa fa-list fa-fw"></i>',['/client-billing-details/','blid'=>$model->guid],['role'=>'modal-remote','class'=>'btn btn-primary']);
    //         }
    //     ]
      
    // ],

    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'template'=>'{user}',
    //     'header'=>'Print <br>Billing <br>Statement',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'visibleButtons' => [
    //         'user' => function ($model) {
    //             return $model->bill_status_id > 1;
    //         },
    //     ],
    //     'buttons' => [
    //         'user' => function($url, $model, $key) {     // render your custom button
    //             return Html::a('<i class="fa fa-print fa-fw"></i>',['/client-billing-list/print-billing-statement','blid'=>$model->guid],['data-pjax'=>0,'class'=>'btn btn-default','target'=>'_blank']);
    //         }
    //     ]
      
    // ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'template'=>'{user}',
    //     'header'=>'Pay Online',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'visibleButtons' => [
    //         'user' => function ($model) {
    //             return $model->bill_status_id > 1;
    //         },
    //     ],
    //     'buttons' => [
    //         'user' => function($url, $model, $key) {     // render your custom button
    //             // return Html::a('<i class="fa fa-credit-card fa-fw"></i>',['#','blid'=>$model->guid],['data-pjax'=>0,'class'=>'btn btn-success',]);
    //             if($model->bill_status_id == 2){
    //                 return Html::a('<i class="fa fa-credit-card fa-fw"></i>',['/client-billing-list/online-payment','guid'=>$model->guid],['data-pjax'=>0,'class'=>'btn btn-success','data-confirm'=>'You will be redirected to our Online Payment Partner, Continue?']);
    //             }
                
    //         }
    //     ]
      
    // ],


];


