<?php

namespace app\controllers;

use Yii;
use app\models\BackendUser;
use app\models\BackendUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\VistaUsuarios;
use yii\data\ArrayDataProvider;
use yii\web\ForbiddenHttpException;
use app\models\Asignaraccion;
/**
 * BackendUserController implements the CRUD actions for BackendUser model.
 */
class BackendUserController extends Controller 
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['perfil','index'],
                'rules' => [
                    [
                        'actions' => ['perfil'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionIndex()
    {

        $accionesUser = Asignaraccion::findOne(['id_accion'=>2, 'id_rol'=>Yii::$app->user->identity->id_rol]);
        if($accionesUser){
            $searchModel = new BackendUserSearch();
            $vistaModel = new VistaUsuarios();
            // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider  = new ArrayDataProvider([
                'allModels' => $vistaModel->find()->orderBy(['id'=>SORT_ASC])->asArray()->all(),
                'key' => 'id',
                'pagination' => [
                    'pageSize' => 10,
                ],
                'sort' => [
                    'attributes' => ['id','id_rol','first_name', 'last_name', 'username', 'nombre', 'email'],
                ],
            ]);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        }else{
            throw new ForbiddenHttpException('Su usuario no posee los privilegios para accceder a este medio');
        }
        
    }

     public function actionPerfil()
    {
        // $searchModel = new BackendUserSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('perfil', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BackendUser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $accionesUser = Asignaraccion::findOne(['id_accion'=>2, 'id_rol'=>Yii::$app->user->identity->id_rol]);
        if($accionesUser){
            return $this->render('view', [
                'model' => $this->findModel2($id),
            ]);
        }else{
            throw new ForbiddenHttpException('Su usuario no posee los privilegios para accceder a este medio');
        }
        
    }

    /**
     * Creates a new BackendUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BackendUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BackendUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $accionesUser = Asignaraccion::findOne(['id_accion'=>1, 'id_rol'=>Yii::$app->user->identity->id_rol]);
        if($accionesUser || $_GET['userRequest'] ){
            $model = $this->findModel($id);
            $vista_user = new VistaUsuarios;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if(array_key_exists('userRequest', $_GET)){
                    return $this->redirect(['perfil','id'=>$model->id]);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                
            }

            return $this->render('update', [
                'model' => $model,
                'vista_user' =>$vista_user,
            ]);


        }else{
            throw new ForbiddenHttpException('Su usuario no posee los privilegios para accceder a este medio');
        }
       
    }

    /**
     * Deletes an existing BackendUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $accionesUser = Asignaraccion::findOne(['id_accion'=>1, 'id_rol'=>Yii::$app->user->identity->id_rol]);
        if($accionesUser){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);

        }else{
            throw new ForbiddenHttpException('Su usuario no posee los privilegios para accceder a este medio');
            
        }
       
    }

    public function actionCambiarpassword($flag,$passw_antig,$passw_user)
    {
            
            $user = new BackendUser();
            
            if($flag == 1){
                
                $currentUser = BackendUser::findOne(['id'=>$passw_antig]);
                $currentUser->setPassword($passw_user);
                echo $currentUser->passw;

                $currentUser->save();
                print_r($user->getErrors());
                echo 'Contraseña cambiada exitosamente';
                // echo'<script type="text/javascript">alert("Tarea Guardada");;</script>';
                return $this->redirect(['perfil','alertFlag'=>'1']);
            }else{
                // print_r($user);
                // echo 'Se vino por donde es';
                // echo $passw_antig.' ----'.$passw_user;
                if($passw_antig == '')echo $flag;

                 return $user->validarAntigPassword($passw_antig,$passw_user);
                
                
               
            }

    }

    public function actionCambiopasswdirecto($id_user,$passw_nueva){
        echo 'id: '.$id_user;
        $userSelected = BackendUser::findOne(['id'=>$id_user]);
        $userSelected->setPassword($passw_nueva);
        $userSelected->save();
        return $this->redirect(['update', 'id' => $id_user]);

    }

    /**
     * Finds the BackendUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BackendUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BackendUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel2($id)
    {

        if (($model = VistaUsuarios::findOne(['id'=>$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
