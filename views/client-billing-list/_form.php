<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\BillingList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-list-form">
    <h3>Billing Statement # <?= $model->billing_no ?></h3>
    <?php $form = ActiveForm::begin(); ?>

    <div class="hidden">
        <?= $form->field($model, 'project_list_id')->textInput() ?>
        <?= $form->field($model, 'billing_no')->textInput() ?>
    </div>

    
    <div class="row">
        
        <div class="col-md-6 col-lg-6">
            <label class="label-default">Billing Details</label>

            <?php 
                echo $form->field($model, 'bill_status_id')
                ->dropDownList(
                    ArrayHelper::map(\app\models\BillStatus::find()->all(), 'id', 'description'),        
                   // ['prompt'=>'']    // options
                );
                ?>

            <?= $form->field($model, 'progress_percent',['addon' => ['append' => ['content'=>'%']]])->textInput(['maxlength' => true,'type'=>'number']) ?>

            <?php 
                echo $form->field($model, 'billing_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date of Billing'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>

        </div>
        <div class="col-md-6 col-lg-6">
            
            <label class="label-success">Payment Details</label>
            <?php 
                echo $form->field($model, 'payment_mode_id')
                ->dropDownList(
                    ArrayHelper::map(\app\models\PaymentMode::find()->all(), 'id', 'description'),        
                    ['prompt'=>'--Leave blank if Unpaid--']    // options
                );
                ?>

            <?php 
                echo $form->field($model, 'payment_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => '--Leave blank if Unpaid--'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>
            <?= $form->field($model, 'payment_reference')->textarea(['rows' => 3]) ?>

            <?= $form->field($model, 'remarks')->textarea(['rows' => 3]) ?>

        </div>
        
        <div class="clearfix">
        
        </div>
        
    </div>


    <?= $form->field($model, 'prepared_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noted_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'checked_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->dropDownList(['1' => 'Active', '0'=>'Inactive']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
