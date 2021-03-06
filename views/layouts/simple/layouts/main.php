<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */

/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code `$this->layout = 'login';` in your controller.
 * (`yii\web\ErrorAction` also support changing layout by setting `layout` property)
 */
$action = Yii::$app->controller->action->id;
if (in_array($action, ['login', 'error'])) { 

    echo $this->render('login', ['content' => $content]);
    return;
}

/**
 * You could set your AppAsset depended with AdminlteAsset 
 */
// \backend\assets\AppAsset::register($this);
 \app\assets\AppAsset::register($this);
$adminlteAsset = yidas\adminlte\AdminlteAsset::register($this);

$distPath = $adminlteAsset->baseUrl;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

    <?php if(!Yii::$app->user->isGuest): ?>
        <body class="hold-transition skin-red sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">

        <?= $this->render('main/header.php', [
            'directoryAsset' => $distPath
            ]) ?>

        <?= $this->render('main/aside.php', [
            'directoryAsset' => $distPath
            ]) ?>

        <?= $this->render('main/content.php', [
            'content' => $content, 'directoryAsset' => $distPath
            ]) ?>

        </div>

        <?php $this->endBody() ?>
        </body>

    <?php else: ?>
        <body class="hold-transition login-page">

            <?php $this->beginBody() ?>

            <?= $content ?>
            <div class="text-center">
            <a href="<?= Url::home() ?>" class="btn btn-default">Back to main page</a>
            </div>
            <?php $this->endBody() ?>
    </body>
  <?php endif; ?>
</html>
<?php $this->endPage() ?>

