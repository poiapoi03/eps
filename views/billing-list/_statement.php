

<?php 
use kartik\helpers\Enum;
use Da\QrCode\QrCode;
$sysSettings = \app\models\SystemSettings::findOne(1);

$qrCode = (new QrCode($model->project->project_ref_id . ' - BS#'.$model->billing_no))
    ->setSize(100)
    ->setMargin(5);
    // ->useForegroundColor(51, 153, 255);

?>

<table width="100%" border=0>
    <tr>
        <td><img src="/images/fb_header.png" alt="Image" height="100px"></td>
        <td align="right"><img src="<?= $qrCode->writeDataUri()?>"></td>
    </tr>
</table>





<div class="clearfix">

</div>

<p align="right">BILLING STATEMENT</p>

<p><?= Yii::$app->formatter->asDate($model->billing_date,'php: F d, Y') ?></p>

<br>

<div style="font-size: 13px;">
<b><?= strtoupper($model->project->client->client_name); ?></b><br>
<b><?= strtoupper($model->project->client->company_name); ?></b><br>
<?= strtoupper($model->project->client->address); ?>
</div>

<br>

<table width="100%" style="font-size: 13px;font-weight:bold">
    <tr>
        <td width="20%">Project Title</td>
        <td>: <?= $model->project->project_title ?></td>
    </tr>
    <tr>
        <td>Location</td>
        <td>: <?= $model->project->location ?></td>
    </tr>
    <tr>
        <td>Subject</td>
        <td>: <?= Yii::$app->formatter->asOrdinal($model->billing_no) .' Progress Billing (Paymenr Request)' ?></td>
    </tr>
</table>

<br>

<?php 
    $amount_due = $model->computeDueAmount($model->id);
    $amount = explode('.', $amount_due);
    $peso = Enum::numToWords($amount[0]);
    $centavos = Enum::numToWords($amount[1]);
    $amountW = ucwords($peso) . ' Pesos and ' . ucwords($centavos) .' Centavos.';
?>

<table border=1 width="100%" style="font-size: 13px;" cellspacing=0 cellpadding=3>
    <tr>
        <th align="center" width="10%"><b>ITEM NO.</b></th>
        <th align="center" width="10%"><b>PERIOD</b></th>
        <th align="center"><b>PARTICULARS</b></th>
        <th align="center" width="20%"><b>AMOUNT</b></th>
    </tr>
    <?php $x=1; foreach($model->billDetails as $row){ ?>
       <tr>
            <td align="center"><?= $x ?></td>
            <td align="center"></td>
            <td><?= $row->collectionType->description .' - '. $row->remarks ?></td>
            <td align="right">P <?= number_format($row->amount,2) ?></td>
       </tr>
    <?php
            $x++;
        } 
    ?>

    <tr>
        <td colspan=2 align="right"><i>Amount in Words:</i></td>
        <td><?= $amountW ?></td>
        <td align="right"> <b>P <?= number_format($amount_due,2) ?></b></td>
    </tr>
</table>

<br><br>
<div style="font-size: 13px;">
* Make all check payments payable to FORTBUILDERS CONST & DEVT CORP. <br>
* You may make payment thru our Metrobank Account # <?= $sysSettings->bank_account_no ?> <br>
* Make your payments within 7 days upon receipt of your Billing Statement <br>
* Our collecting Staff will issue a Provisional receipt upon collection of your payment. <br>
* Please allow us Five (5) Working days to issue and Official receipt, if our staff cannot issue an OR
   please do address your concern to <?= $sysSettings->billing_contact_person ?> at Tel No. <?=  $sysSettings->billing_contact_no ?>



<br><br>

Thank you for doing business with us!

<br><br><br><br>

<p>Prepared By: <?= $model->prepared_by ?></p>
<br><br><br>


<p>Noted By: <?= $model->noted_by ?></p>
<br><br><br>


<p align="right">Checked By: <?= $model->checked_by ?></p>
</div>