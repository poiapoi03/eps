<?php

namespace app\controllers;

use yii\rest\ActiveController;
use Yii;
use Crazymeeks\Foundation\PaymentGateway\Dragonpay;

class PaymentController extends ActiveController
{
    public $modelClass = 'app\models\ClientList';
	
	
	
	public function actionHandler()
	{
		
		Yii::info('poiapoi-start');
		$merchant_account = [
              'merchantid' => 'FORTBUILDERS',
              'password'   => 'Anv31af7q8y6JCj'
        ];
		
		$dragonpay = new Dragonpay($merchant_account);
		
		$dragonpay->handlePostback(function($data){
			 // do your stuff here like save data to your database.
			 //$insert = "Insert INTO mytable(`txnid`, `refno`, `status`) VALUES ($data['txnid'], $data['refno'])";
			 //mysql_query($insert);

			 # or if you are in Laravel, you can use Model or DB Facade...
			 // DB::table('mytable')->insert($data);
             
             $model = \app\models\BillingList::findOne(['bs_ref_no'=>$data['param1']]);

             if($model != null)
             {
                 if($data['status']=='S')
                 {
                     $model->bill_status_id = 3;
                     $model->payment_mode_id = 1;
                     $model->payment_date = date('Y-m-d h:i:s');
                     $model->payment_reference = $data['refno'];
                 }
                 $model->online_payment_message = $data['message'];
                 $model->online_payment_status = $data['status'];
                 $model->online_payment_digest = $data['digest'];
                 $model->txnid = $data['txnid'];

             }
			 Yii::info($data['txnid']);
			 Yii::info($data['refno']);
			 Yii::info($data['status']);
			 Yii::info($data['message']);
             Yii::info($data['digest']);
             $model->save(false);
			return 'result=OK';
			 
		});
		

	}
}