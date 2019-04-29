<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "backendUser".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $passw
 * @property string $authkey
 * @property string $email
 * @property string $username
 */
class BackendUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backendUser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'passw', 'authkey'], 'required', 'message' => 'Este campo es requerido'],
            ['username','unique','targetClass' => '\app\models\BackendUser', 'message' => 'Este usuario ya ha sido tomado.'],
            ['email', 'unique', 'targetClass' => '\app\models\BackendUser', 'message' => 'Este correo ya se uso.'],
            [['first_name', 'last_name', 'authkey', 'username'], 'string', 'max' => 50],
            [['passw'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 80],
            [['foto_perfil'], 'string', 'max' => 200],
            [['id_rol'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Primer Nombre',
            'last_name' => 'Primer Apellido',
            'passw' => 'Contraseña',
            'authkey' => 'Authkey',
            'foto_perfil' => 'Foto de Perfil',
            'email' => 'Correos',
            'username' => 'Nombres de Usuario',
            'id_rol'=> 'Rol',
            'nombre' => 'Rol',
        ];
    }
     public function getAuthKey(){
        return $this->authkey;
    }

    public function getID(){
        return $this->id;
    }

    public function validateAuthKey($authKey){
        return $this->authKey === $authKey;
    }

    public function validatePassword ($password){
       return Yii::$app->getSecurity()->validatePassword($password,$this->passw);
          
        // return $this->passw === $password;
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new \yii\base\NotSupportedException();

    }
    public static function findByUsername($username){
        return self::findOne(['username'=>$username]);
    }

    public function setPassword($password)
    {
        $this->passw = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->authkey = Yii::$app->security->generateRandomString();
    }

    public function validarAntigPassword ($passw_antig, $passw_user){
        
        return Yii::$app->getSecurity()->validatePassword($passw_antig,$passw_user);

       // echo $passw_user;
       // Yii::$app->getSecurity()->validatePassword($passw_antig,$passw_user)){
       
    }

}
