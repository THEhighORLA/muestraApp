<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\BackendUser;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $passw;
    public $first_name;
    public $last_name;
    public $foto_perfil;
    public $id_rol;

     public function attributeLabels()
    {
        return [
            
            'first_name' => 'Primer Nombre',
            'last_name' => 'Primer Apellido',
            'passw' => 'Contraseña',
            'foto_perfil' => 'Foto de Perfil',
            'email' => 'Correo',
            'username' => 'Nombre De Usuario',
            'id_rol'=> 'Rol',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required' ,'message' => 'Este campo es requerido'],
            ['username', 'unique', 'targetClass' => '\app\models\BackendUser', 'message' => 'Este usuario ya ha sido tomado.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username','filter','filter'=>'strtolower'],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Este campo es requerido'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\BackendUser', 'message' => 'Este correo ya se ha usado.'],

            ['passw', 'required', 'message' => 'Este campo es requerido'],
            ['passw', 'string', 'min' => 6],
            ['first_name','trim'],
            ['first_name','required', 'message' => 'Este campo es requerido'],
            ['first_name','filter','filter'=>'strtolower'],
            ['last_name','trim'],
            ['last_name','required', 'message' => 'Este campo es requerido'],
            ['last_name','filter','filter'=>'strtolower'],
            ['id_rol', 'integer'],
            // [['foto_perfil'], 'string', 'max' => 200],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new BackendUser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->passw);
        $user->generateAuthKey();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->foto_perfil = $this->foto_perfil;
        $user->id_rol = $this->id_rol;
        return $user->save();
        // print_r($user->getErrors());

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom('ocuabro@gmail.com')
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
