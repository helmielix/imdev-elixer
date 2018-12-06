<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\DashboardRequest;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
	public function actionGetdashboardrequest(){
		if(DashboardRequest::find()->exists()){
			$arrRequest = DashboardRequest::find()->select('id_module')->distinct()->all();
			//var_dump($arrRequest);
			foreach($arrRequest as $data){
				switch ($data->id_module) {
					case 1:
						$command = Yii::$app->db->createCommand("select _temp_dash_iko_wo_daily_region();")->query();
						$upsert = Yii::$app->db->createCommand("select _upsert_dash_iko_wo_daily_region();")->query();
						Yii::$app->db->createCommand()->truncateTable('temp_dash_iko_wo_daily_region')->execute();
						break;
					case 2:
						$commanda = Yii::$app->db->createCommand("select _temp_osp_itp_total_by_region();")->query();
						$commandb = Yii::$app->db->createCommand("select _temp_osp_itp_total_by_region_vendor();")->query();
						$upserta = Yii::$app->db->createCommand("select _upsert_osp_itp_total_by_region();")->query();
						$upsertb = Yii::$app->db->createCommand("select _upsert_osp_itp_total_by_region_vendor();")->query();
						Yii::$app->db->createCommand()->truncateTable('temp_osp_itp_total_by_region')->execute();
						Yii::$app->db->createCommand()->truncateTable('temp_osp_itp_total_by_region_vendor')->execute();
						break;
					case 3:
						$command = Yii::$app->db->createCommand("select _temp_dash_planning_boq_by_city();")->query();
						$upsert = Yii::$app->db->createCommand("select _upsert_dash_planning_boq_by_city();")->query();
						Yii::$app->db->createCommand()->truncateTable('temp_dash_planning_boq_by_city')->execute();
						break;
					case 4:
						$command = Yii::$app->db->createCommand("select _temp_dash_gov_permit_by_region();")->query();
						$upsert = Yii::$app->db->createCommand("select _upsert_dash_gov_permit_by_region();")->query();
						Yii::$app->db->createCommand()->truncateTable('temp_dash_planning_boq_by_city')->execute();
						break;
				}
			}
			Yii::$app->db->createCommand()->truncateTable('dashboard_request')->execute();
		}
	}
}
