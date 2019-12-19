<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client User Access';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>