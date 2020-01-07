<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use kartik\number\NumberControl;
/* @var $this yii\web\View */
/* @var $model app\models\BillingDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-details-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="hidden">
    <?= $form->field($model, 'billing_list_id')->textInput() ?>
    </div>
    <?php 
        echo $form->field($model, 'collection_type_id')
        ->dropDownList(
            ArrayHelper::map(\app\models\CollectionType::find()->where(['is_active'=>1,'auto_compute'=>0])->all(), 'id', 'description'),        
            // ['prompt'=>'']    // options
        );
    ?>


    <?php 
        echo $form->field($model, 'amount')->widget(NumberControl::classname(), [
            'maskedInputOptions' => [
                'allowMinus' => false
            ],
        ]);
    ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
