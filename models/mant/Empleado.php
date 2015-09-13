<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "empleado".
 *
 * @property integer $codigo
 * @property string $cargo
 * @property integer $cod_unidad
 * @property integer $cod_persona
 *
 * @property CarnetMinoridad[] $carnetMinoridads
 * @property Cuadrilla[] $cuadrillas
 * @property Persona $codPersona
 * @property Unidad $codUnidad
 * @property Partida[] $partidas
 * @property Vehiculo $vehiculo
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
            [['cargo', 'cod_unidad', 'cod_persona'], 'required'],
            [['cod_unidad', 'cod_persona'], 'integer'],
            [['cargo'], 'string', 'max' => 50],
            [['cod_persona'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Código',
            'cargo' => 'Cargo',
            'cod_unidad' => 'Unidad',
            'cod_persona' => 'Registro de Persona',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarnetMinoridads()
    {
        return $this->hasMany(CarnetMinoridad::className(), ['cod_empleado' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuadrillas()
    {
        return $this->hasMany(Cuadrilla::className(), ['cod_empleado' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodPersona()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_persona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodUnidad()
    {
        return $this->hasOne(Unidad::className(), ['codigo' => 'cod_unidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidas()
    {
        return $this->hasMany(Partida::className(), ['cod_empleado' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculo::className(), ['cod_conductor' => 'codigo']);
    }
}
