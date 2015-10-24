<?php

namespace app\models\mant;

use Yii;

/**
* This is the model class for table "persona".
*
* @property integer $codigo
* @property string $nombre
* @property string $apellido
* @property string $apellido_casada
* @property integer $empleado
* @property string $dui
* @property string $nit
* @property string $otro_doc
* @property string $fecha_nacimiento
* @property string $genero
* @property string $direccion
* @property string $profesion
* @property string $estado
* @property integer $cod_municipio
* @property integer $cod_nacionalidad
* @property integer $cod_estado_civil
* @property string $nombre_usuario
* @property integer $cod_mun_origen
*
* @property CarnetMinoridad[] $carnetMinoridads
* @property Defuncion $defuncion
* @property Empleado $empleado0
* @property Informante $informante
* @property MatrimonioPersona[] $matrimonioPersonas
* @property Nacimiento $nacimiento
* @property Nacimiento[] $nacimientos
* @property Nacimiento[] $nacimientos0
* @property EstadoCivil $codEstadoCivil
* @property Municipio $codMunOrigen
* @property Municipio $codMunicipio
* @property Nacionalidad $codNacionalidad
* @property Usuario $nombreUsuario
* @property Solicitud[] $solicituds
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
      [['nombre', 'apellido', 'fecha_nacimiento', 'genero', 'direccion', 'cod_mun_origen', 'cod_municipio', 'cod_nacionalidad', 'cod_estado_civil'], 'required'],
      [['empleado', 'cod_municipio', 'cod_nacionalidad', 'cod_estado_civil', 'cod_mun_origen'], 'integer'],
      [['fecha_nacimiento'], 'safe'],
      [['nombre', 'apellido', 'apellido_casada', 'genero', 'profesion', 'estado', 'nombre_usuario'], 'string', 'max' => 50],
      [['dui'], 'string', 'max' => 9],
      [['nit'], 'string', 'max' => 14],
      [['otro_doc'], 'string', 'max' => 80],
      [['direccion'], 'string', 'max' => 200],
      [['dui'], 'unique'],
      [['nit'], 'unique'],
      [['nombre_usuario'], 'unique']
    ];
  }

  public function attributeLabels()
  {
    return [
      'codigo' => 'Código',
      'nombre' => 'Nombre',
      'apellido' => 'Apellido',
      'apellido_casada' => 'Apellido de Casada',
      'empleado' => 'Empleado',
      'dui' => 'DUI',
      'nit' => 'NIT',
      'fecha_nacimiento' => 'Fecha de Nacimiento',
      'genero' => 'Sexo',
      'direccion' => 'Dirección',
      'profesion' => 'Profesión',
      'estado' => 'Estado',
      'cod_municipio' => 'Municipio',
      'cod_nacionalidad' => 'Nacionalidad',
      'cod_estado_civil' => 'Estado Civil',
      'nombre_usuario' => 'Usuario',
      'cod_mun_origen' => 'Originario de',
      'otro_doc' => 'Documento Alternativo',
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
  public function getCodEmpleado()
  {
    return $this->hasOne(Empleado::className(), ['cod_persona' => 'codigo']);
  }

  /**
  * @return \yii\db\ActiveQuery
  */
  public function getInformante()
  {
    return $this->hasOne(Informante::className(), ['cod_persona' => 'codigo']);
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
  public function getCodMunOrigen()
  {
    return $this->hasOne(Municipio::className(), ['codigo' => 'cod_mun_origen']);
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

  /**
  * @return \yii\db\ActiveQuery
  */
  public function getNombreUsuario()
  {
    return $this->hasOne(Usuario::className(), ['nombre' => 'nombre_usuario']);
  }

  /**
  * @return \yii\db\ActiveQuery
  */
  public function getSolicituds()
  {
    return $this->hasMany(Solicitud::className(), ['cod_persona' => 'codigo']);
  }
}
