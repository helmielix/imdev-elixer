<?php
namespace common\widgets;

use Yii;
use common\models\UserAuth;
use common\models\UserWarehouse;

class Email
{
    /*
     * input $idwarehouse jika yang menerima email harus punya akses pada halaman tersebut, dan data tersebut
    */
    public function sendEmail($arrAuth, $header, $subject, $idwarehouse = NULL)
    {
		$users = UserAuth::find()->select(['username','email', 'id_user'])->where(['child'=>$arrAuth])->groupBy(['username','email', 'id_user'])->all();
		$i=0;
		$arrUsers = [];
		foreach($users as $user) {
			if ($idwarehouse != NULL) {
				$userwhexists = UserWarehouse::find()->where(['and',['id_user' => $user->id_user],['id_warehouse' => $idwarehouse]])->exists();
				if ($userwhexists && !in_array($user->email, $arrUsers)) {
					array_push($arrUsers, $user->email);
				}
			}else{
				array_push($arrUsers, $user->email);
			}
				
		}
		Yii::$app->mailer->compose()
			-> setFrom (['foro@mail2.mncplaymedia.com' => 'IM System'])
			-> setTo($arrUsers)
			//-> setTo([
			//	'yasin@elixer.co.id',
			//	'syifa@elixer.co.id',
			//	'robi@elixer.co.id',
			//	])
			-> setSubject ( $header )
			-> setHtmlBody( $subject)
			-> send();
			$i++;
    }
    
}
