<?php
namespace app\controllers;

use app\models\AccessContent;
use app\models\Users;
use Yii;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Content;
use app\models\ContentWork;
use yii\web\User;

class TextController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
    public function actionUserinterface()
    {
        $model_access = new AccessContent();
        $model = new Content();
        $model_content = new ContentWork();
        $dataProviderAccess = $model_content->search_receiver(Yii::$app->request->queryParams);
        $dataProviderContent = $model_content->search(Yii::$app->request->queryParams);
        return $this->render('interface', [
            'model'=> $model,
            'model_access' => $model_access,
            'model_content' => $model_content,
            'dataProviderContent' => $dataProviderContent,
            'dataProviderAccess'=> $dataProviderAccess
        ]);
    }
    public function actionAddText()
    {
        $model = new Content();
        $model_access = new AccessContent();
        if ($model->load(Yii::$app->request->post()) && $model_access->load(Yii::$app->request->post())) {
            $model->setAttributes(['text' => openssl_encrypt($model['text'], 'idea', $model['password'], $options = 0, '34546561'),
                'password' => Yii::$app->getSecurity()->generatePasswordHash($model['password']),
                'id_user' => Yii::$app->user->id,
                'link' => 'http://secret.arealidea.ru/' . Yii::$app->getSecurity()->generateRandomString(6)]);
            $model->save();
            $model_access->setAttributes([
                'sender_id' => $model['id_user'],
                'id_content' => $model['id_content']
            ]);
            if ($model_access->save())
            {
                $result ['status'] = true;
            }
            else
            {
                $result ['status'] = false;
            }
        }
        return json_encode($result);
    }
    public function actionValidatePassword()
    {
        $session = Yii::$app->session;
        $session->open();
        $session['id_content'] = Yii::$app->request->get('id');
        $model = new Content();
        return $this->render('password',[
            'model' =>$model
            ]);

    }
    public function actionViewText()
    {
        $model = new Content();
        $model->load(Yii::$app->request->post());
        $session = Yii::$app->session;
        $model_findcontent = $this->findContent($session['id_content']);
        $session->destroy();
        $session->close();
        if ( Yii::$app->getSecurity()->validatePassword($model['password'],$model_findcontent['password']) == true)
        {
            echo (openssl_decrypt($model_findcontent['text'],'idea',$model['password'],$options = 0,'34546561'));
        }
    }
    public function actionDeletecontent()
    {
        if(Yii::$app->request->post('id') != null)
        {
            AccessContent::deleteAll('id_content = '.Yii::$app->request->post('id'));
            $model = $this->findContent(Yii::$app->request->post('id'));
        }
        else
        {
            AccessContent::deleteAll('id_content = '.Yii::$app->request->get('id'));
            $model = $this->findContent(Yii::$app->request->get('id'));
        }
        if($model->delete())
        {
            $result ['status'] = true;
        }
        else
        {
            $result ['status'] = false;
        }
        return json_encode($result);
    }

    // findfunctions
    protected function findContent($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
?>