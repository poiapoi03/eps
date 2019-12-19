<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
?>
<div class="profile-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'name',
            'public_email:email',
            'gravatar_email:email',
            'gravatar_id',
            'location',
            'website',
            'timezone',
            'bio:ntext',
        ],
    ]) ?>

</div>
