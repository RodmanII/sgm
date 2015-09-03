<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property integer $codigo
 * @property string $nombre
 * @property string $apellido
 * @property string $dui
 * @property string $nit
 * @property string $fecha_nacimiento
 * @property string $genero
 * @property string $direccion
 * @property string $profesion
 * @property string $estado
 * @property integer $cod_municipio
 * @property integer $cod_nacionalidad
 * @property integer $cod_estado_civil
 *
 * @property CarnetMinoridad[] $carnetMinoridads
 * @property Defuncion $defuncion
 * @property Empleado $empleado
 * @property MatrimonioPersona[] $matrimonioPersonas
 * @property Nacimiento $nacimiento
 * @property Nacimiento[] $nacimientos
 * @property Nacimiento[] $nacimientos0
 * @property EstadoCivil $codEstadoCivil
 * @property Municipio $codMunicipio
 * @property Nacionalidad $codNacionalidad
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'fecha_nacimiento', 'genero', 'direccion', 'cod_municipio', 'cod_nacionalidad', 'cod_estado_civil'], 'required'],
            [['fecha_nacimiento'], 'safe'],
            [['cod_municipio', 'cod_nacionalidad', 'cod_estado_civil'], 'integer'],
            [['nombre', 'apellido', 'genero', 'profesion', 'estado'], 'string', 'max' => 50],
            [['dui'], 'string', 'max' => 9],
            [['nit'], 'string', 'max' => 10],
            [['direccion'], 'string', 'max' => 200],
            [['dui'], 'unique'],
            [['nit'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'dui' => 'DUI',
            'nit' => 'NIT',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'genero' => 'Género',
            'direccion' => 'Dirección',
            'profesion' => 'Profesión',
            'estado' => 'Estado',
            'cod_municipio' => 'Municipio',
            'cod_nacionalidad' => 'Nacionalidad',
            'cod_estado_civil' => 'Estado Civil',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarnetMinoridads()
    {
        return $this->hasMany(CarnetMinoridad::className(), ['cod_persona' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefuncion()
    {
        return $this->hasOne(Defuncion::className(), ['cod_difunto' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['cod_persona' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatrimonioPersonas()
    {
        return $this->hasMany(MatrimonioPersona::className(), ['cod_persona' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNacimiento()
    {
        return $this->hasOne(Nacimiento::className(), ['cod_asentado' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNacimientos()
    {
        return $this->hasMany(Nacimiento::className(), ['cod_madre' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNacimientos0()
    {
        return $this->hasMany(Nacimiento::className(), ['cod_padre' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodEstadoCivil()
    {
        return $this->hasOne(EstadoCivil::className(), ['codigo' => 'cod_estado_civil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['codigo' => 'cod_municipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodNacionalidad()
    {
        return $this->hasOne(Nacionalidad::className(), ['codigo' => 'cod_nacionalidad']);
    }
}