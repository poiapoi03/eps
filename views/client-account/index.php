<?php
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
/* @var $this yii\web\View */
/* @var $model app\models\ClientList */

CrudAsset::register($this);

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="client-list-view">

    
    <div class="col-md-6 col-lg-6">
        <?= DetailView::widget([
            'model' => Yii::$app->user->identity->client,
            'attributes' => [
                'client_name',
                'company_name',
                'completeAddress',
            ],
        ]) ?>
    </div>
    
    <div class="col-md-6 col-lg-6">
        <?= DetailView::widget([
            'model' => Yii::$app->user->identity->client,
            'attributes' => [
                'email:ntext',
                'contact_no:ntext',
                'client_ref_id',
                
            ],
        ]) ?>
    </div>
    
    <div class="clearfix">
    
    </div>


</div>

<div class="client-list-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>'',
                    // Html::a('<i class="glyphicon glyphicon-plus"></i> Add Client', ['create'],
                    // ['role'=>'modal-remote','title'=> 'Add new Client','class'=>'btn btn-primary'])
                    // .
                    // Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    // ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    // '{toggleData}'.
                    // '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Project Listing',
                // 'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                // 'after'=>BulkButtonWidget::widget([
                //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                //                 ["bulk-delete"] ,
                //                 [
                //                     "class"=>"btn btn-danger btn-xs",
                //                     'role'=>'modal-remote-bulk',
                //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                //                     'data-request-method'=>'post',
                //                     'data-confirm-title'=>'Are you sure?',
                //                     'data-confirm-message'=>'Are you sure want to delete this item'
                //                 ]),
                //         ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

