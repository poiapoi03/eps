<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'password_hash',
            'auth_key',
            'unconfirmed_email:email',
            'registration_ip',
            'flags',
            'confirmed_at',
            'blocked_at',
            'updated_at',
            'created_at',
            'last_login_at',
            'last_login_ip',
            'auth_tf_key',
            'auth_tf_enabled',
            'password_changed_at',
            'gdpr_consent',
            'gdpr_consent_date',
            'gdpr_deleted',
            'status',
            'user_type',
            'client_list_id',
        ],
    ]) ?>

</div>
