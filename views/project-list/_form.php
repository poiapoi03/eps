<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View; 
use app\models\ClientList;
use kartik\number\NumberControl;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\ProjectList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-list-form">
    <?php if($model->isNewRecord){
        $system_setting = \app\models\SystemSettings::findOne(1);
        $model->deposit_percent = $system_setting->default_deposit;
        $model->retention_percent = $system_setting->default_retention;
    } ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
       
        <?php 
        echo $form->field($model, 'client_list_id')
        ->dropDownList(
            ArrayHelper::map(ClientList::find()->where(['is_active'=>1])->all(), 'id', function($model){ return $model->client_name .' - ' . $model->company_name; }),        
            ['prompt'=>'']    // options
        );
        ?>
    
    <div class="row">
 
    
        <div class="col-md-6 col-lg-6">
            
           

            <?= $form->field($model, 'project_title')->textarea(['rows' => 3]) ?>

            <?= $form->field($model, 'location')->textarea(['rows' => 3]) ?>

        </div>
        <div class="col-md-6 col-lg-6">
            <?php 
                echo $form->field($model, 'contract_price')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'allowMinus' => false
                    ],
                ]);
            ?>

            <?= $form->field($model, 'deposit_percent',['addon' => ['append' => ['content'=>'%']]])->textInput(['maxlength' => true, 'type'=>'number']) ?>
            
            <?= $form->field($model, 'retention_percent',['addon' => ['append' => ['content'=>'%']]])->textInput(['maxlength' => true, 'type'=>'number']) ?>
        </div>
        
        <div class="clearfix">
        
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-6 col-lg-6">
          
            <?php 
                echo $form->field($model, 'deposit_amount')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'allowMinus' => false
                    ],
                    'displayOptions' => ['readOnly'=>true], 
                ]);
            ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?php 
                echo $form->field($model, 'retention_amount')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'allowMinus' => false
                    ],
                    'displayOptions' => ['readOnly'=>true], 
                ]);
            ?>
        </div>
        <div class="clearfix">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <?php 
                echo $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Project Start Date'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?php 
                echo $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Project Start Date'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>
        </div>
        <div class="clearfix">
        </div>
    </div>
    
    <?= $form->field($model, 'is_active')->dropDownList(['1' => 'Active', '0'=>'Inactive']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php 
$this->registerJs(
    "
    $('#projectlist-contract_price-disp').on('change', function() { 
        var deposit = $('#projectlist-deposit_percent').val();
        var retention = $('#projectlist-retention_percent').val();
        var contract_price = $('#projectlist-contract_price').val();
        var deposit_amount = (parseFloat(contract_price) * deposit) / 100.00;
        var retention_amount = (parseFloat(contract_price) * retention) / 100.00;
        $('#projectlist-deposit_amount-disp').val(deposit_amount);
        $('#projectlist-deposit_amount').val(deposit_amount);
        $('#projectlist-retention_amount-disp').val(retention_amount);
        $('#projectlist-retention_amount').val(retention_amount);
     });


    $('#projectlist-deposit_percent').on('change', function() { 
        var deposit = $('#projectlist-deposit_percent').val();
        var retention = $('#projectlist-retention_percent').val();
        var contract_price = $('#projectlist-contract_price').val();
        var deposit_amount = (parseFloat(contract_price) * deposit) / 100.00;
        var retention_amount = (parseFloat(contract_price) * retention) / 100.00;
        $('#projectlist-deposit_amount-disp').val(deposit_amount);
        $('#projectlist-deposit_amount').val(deposit_amount);
        $('#projectlist-retention_amount-disp').val(retention_amount);
        $('#projectlist-retention_amount').val(retention_amount);
     });

    $('#projectlist-retention_percent').on('change', function() { 
        var deposit = $('#projectlist-deposit_percent').val();
        var retention = $('#projectlist-retention_percent').val();
        var contract_price = $('#projectlist-contract_price').val();
        var deposit_amount = (parseFloat(contract_price) * deposit) / 100.00;
        var retention_amount = (parseFloat(contract_price) * retention) / 100.00;
        $('#projectlist-deposit_amount-disp').val(deposit_amount);
        $('#projectlist-deposit_amount').val(deposit_amount);
        $('#projectlist-retention_amount-disp').val(retention_amount);
        $('#projectlist-retention_amount').val(retention_amount);
     });
     
     
     
     ",
    View::POS_READY,
    'computation-handler'
);
?>