<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaraccion".
 *
 * @property int $id_rol
 * @property int $id_accion
 *
 * @property Accion $accion
 * @property Rol $rol
 */
class Asignaraccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignaraccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_accion'], 'default', 'value' => null],
            [['id_rol', 'id_accion'], 'integer'],
            [['id_accion'], 'exist', 'skipOnError' => true, 'targetClass' => Accion::className(), 'targetAttribute' => ['id_accion' => 'id']],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['id_rol' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_rol' => 'Id Rol',
            'id_accion' => 'Id Accion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccion()
    {
        return $this->hasOne(Accion::className(), ['id' => 'id_accion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'id_rol']);
    }
}
