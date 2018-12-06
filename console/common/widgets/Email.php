<?php
namespace common\widgets;

use Yii;
use common\models\UserAuth;
use common\models\EmailParameter;

class Email
{
    
    public function sendEmail($arrAuth, $header, $subject)
    {
		$users = UserAuth::find()->select(['username','email'])->where(['child'=>$arrAuth])->groupBy(['username','email'])->all();
		$i=0;
		$arrUsers = [];
		foreach($users as $user) {
			array_push($arrUsers, $user->email);	
		}
		Yii::$app->mailer->compose()
			-> setFrom (['foro@mail2.mncplaymedia.com' => 'FORO System'])
			-> setTo($arrUsers)
			-> setSubject ( $header )
			-> setHtmlBody( $subject)
			-> send();
			$i++;
    }

    public function sendEmailNetpro($problem_type, $header, $subject)
    {
		$users = EmailParameter::find()->select(['type_problem','email'])->where(['type_problem'=>$problem_type])->groupBy(['type_problem','email'])->all();
		$i=0;
		$arrUsers = [];
		foreach($users as $user) {
			array_push($arrUsers, $user->email);	
		}
		Yii::$app->mailer->compose()
			-> setFrom (['foro@mail2.mncplaymedia.com' => 'FORO System'])
			-> setTo($arrUsers)
			-> setSubject ( $header )
			-> setHtmlBody( $subject)
			-> send();
			$i++;
    }
}
