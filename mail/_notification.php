<?php 
use yii\helpers\Url;
?>
<p>Dear <?= $model->project->client->client_name .' / ' . $model->project->client->company_name?>, <br>
1
<br />Please click the following link to download your Billing Statement Notice for project title :<?= $model->project->project_title ?>.</p>
<p><?= Url::base(true);  ?> <br>

<br />For security purposes, you will be required to log in first to your Personal Page in the Fortbuilders ePayment System.</p>

<p>
For inquiries, you may contact us through any of the following:
    <br /> <br />Email: fortbuildersco@gmail.com
    <br />Customer Support: (+632) 990 0218, (+632) 989 2833
    <br />Business Hours: 8:00 AM - 5:00 PM, Mondays to Fridays

    <br />Have a bright day!</p>
<p>

<br />*This email are strictly confidential and may be legally protected. If you are not the intended recipient, kindly notify us at fortbuildersco@gmail.com, delete permanently and do not forward, copy, or print any of the contents.</p>