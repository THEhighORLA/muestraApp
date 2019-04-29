<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vista_usuarios".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $username
 * @property string $nombre
 */
class VistaUsuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vista_usuarios';
    }

    public static function primaryKey()
    {
        return "id";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','id_rol'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['first_name', 'last_name', 'username', 'nombre'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 80],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Nombre',
            'last_name' => 'Apellido',
            'email' => 'Correo',
            'username' => 'Nombre de Usuario',
            'nombre' => 'Rol',
        ];
    }
}
