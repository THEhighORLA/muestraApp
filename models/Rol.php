<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property Asignaraccion[] $asignaraccions
 * @property BackendUser[] $backendUsers
 */
class Rol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaraccions()
    {
        return $this->hasMany(Asignaraccion::className(), ['id_rol' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackendUsers()
    {
        return $this->hasMany(BackendUser::className(), ['id_rol' => 'id']);
    }
}
