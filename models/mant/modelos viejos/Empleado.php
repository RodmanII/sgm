<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "empleado".
 *
 * @property integer $Id
 * @property integer $IdUnidad
 * @property integer $IdPersona
 * @property string $Cargo
 *
 * @property Unidad $idUnidad
 * @property Persona $idPersona
 * @property EmpleadoRecoleccion[] $empleadoRecoleccions
 * @property Usuario $usuario
 */
class Empleado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empleado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdUnidad', 'IdPersona', 'Cargo'], 'required'],
            [['IdUnidad', 'IdPersona'], 'integer'],
            [['Cargo'], 'string', 'max' => 100],
            [['IdPersona'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'Id',
            'IdUnidad' => 'Id de Unidad',
            'IdPersona' => 'Id de Persona',
            'Cargo' => 'Cargo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUnidad()
    {
        return $this->hasOne(Unidad::className(), ['Id' => 'IdUnidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPersona()
    {
        return $this->hasOne(Persona::className(), ['Id' => 'IdPersona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleadoRecoleccions()
    {
        return $this->hasMany(EmpleadoRecoleccion::className(), ['IdEmpleado' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['IdEmpleado' => 'Id']);
    }
}
