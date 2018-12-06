<?php

namespace console\controllers;
use ppl\models\PplIkoAtp;

class PplAtpController extends \yii\console\Controller
{
    public function actionIndex()
    {
        // return $this->render('index');
        echo 'asdasdasdad';
    }

    public function actionTerminatp()
    {
        // periksa IKO ATP
        echo 'ini console';
        /*
        $modelIko = PplIkoAtp::find()->all();
        foreach ($modelIko as $ikoatp) {
            $olddate = new \Datetime($ikoatp->date_atp);
            $nowdate = new \Datetime(date('Y-m-d'));
            $interval = $oltdate->diff($nowdate);
            // if ($interval->days > 7)  {
            //     if ((($ikoatp->pic_ca == '' && $ikoatp->decline_remark_ca == '') || $ikoatp->decline_remark_ca != '')
            //       &&(($ikoatp->pic_planning == '' && $ikoatp->decline_remark_planning == '' )|| $ikoatp->decline_remark_planning != '')
            //       &&(($ikoatp->pic_osp == '' && $ikoatp->decline_remark_osp == '') || $ikoatp->decline_remark_osp != '')
            //       &&(($ikoatp->pic_ospm == '' && $ikoatp->decline_remark_ospm == '' )|| $ikoatp->decline_remark_ospm != '')
            //       &&(($ikoatp->pic_iko == '' && $ikoatp->decline_remark_iko == '' )|| $ikoatp->decline_remark_iko != '')
            //       &&(($ikoatp->pic_ikr == '' && $ikoatp->decline_remark_ikr == '' )|| $ikoatp->decline_remark_ikr != '')
            //       &&(($ikoatp->pic_project_control == '' && $ikoatp->decline_remark_project_control == '' )|| $ikoatp->decline_remark_project_control != '')
            //         // no respon or decline
            //         ) {
            //         $ikoatp->status_schedule = 32;
            //     }else {
            //         // ada respon
            //     }
            // }

        } */
    }

}
