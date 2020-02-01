<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <!-- <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?> -->

    
    <div class="col-md-6 col-lg-6">

        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
        
        <p>Client Details</p>
        <?= $form->field($model, 'name_prefix')->textInput(['maxlength' => true])->hint('Mr., Ms., Engr.(optional)') ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true])->hint('(optional)') ?>

        <?= $form->field($model, 'ext_name')->textInput(['maxlength' => true])->hint('Jr., Sr., III (optional)') ?>
        
    <?= $form->field($model, 'is_active')->dropDownList(['1' => 'Active', '0'=>'Inactive']) ?>

        
    </div>
    <div class="col-md-6 col-lg-6">
        <?= $form->field($model, 'contact_no')->textarea(['rows' => 1]) ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'address')->textarea(['rows' => 1]) ?>

        <?= $form->field($model, 'address2')->textarea(['rows' => 1]) ?>

        <?= $form->field($model, 'city')->textInput() ?>

        <?= $form->field($model, 'province')->textInput() ?>

        <?= $form->field($model, 'country')->dropDownList(['PH' => 'PH'])?>

        <?= $form->field($model, 'zipCode')->textInput()->hint('Optional') ?>
        
    </div>
    
    <div class="clearfix">
    
    </div>
    

    
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
