<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property integer $Id
 * @property string $Nombre
 * @property string $DUI
 * @property string $NIT
 * @property string $FechaNacimiento
 * @property string $Genero
 * @property string $Direccion
 * @property string $Profesion
 * @property integer $IdEstadoCivil
 * @property integer $Fallecido
 * @property integer $IdTipoCliente
 * @property integer $Activo
 * @property integer $IdMunicipio
 * @property integer $IdPadre
 * @property integer $IdMadre
 *
 * @property Asentamiento $asentamiento
 * @property Defuncion $defuncion
 * @property Empleado $empleado
 * @property Partida[] $partidas
 * @property Persona $idMadre
 * @property Persona[] $personas
 * @property Persona $idPadre
 * @property Persona[] $personas0
 * @property EstadoCivil $idEstadoCivil
 * @property Municipio $idMunicipio
 * @property TipoCliente $idTipoCliente
 * @property Unyon[] $unyons
 * @property Unyon[] $unyons0
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
            [['Nombre', 'FechaNacimiento', 'Genero', 'Direccion', 'IdMunicipio'], 'required'],
            [['FechaNacimiento'], 'safe'],
            [['IdEstadoCivil', 'Fallecido', 'IdTipoCliente', 'Activo', 'IdMunicipio', 'IdPadre', 'IdMadre'], 'integer'],
            [['Nombre'], 'string', 'max' => 80],
            [['DUI'], 'string', 'max' => 9],
            [['NIT'], 'string', 'max' => 10],
            [['Genero'], 'string', 'max' => 20],
            [['Direccion'], 'string', 'max' => 250],
            [['Profesion'], 'string', 'max' => 50],
            [['DUI'], 'unique'],
            [['NIT'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Nombre' => 'Nombre',
            'DUI' => 'Dui',
            'NIT' => 'Nit',
            'FechaNacimiento' => 'Fecha Nacimiento',
            'Genero' => 'Genero',
            'Direccion' => 'Direccion',
            'Profesion' => 'Profesion',
            'IdEstadoCivil' => 'Id Estado Civil',
            'Fallecido' => 'Fallecido',
            'IdTipoCliente' => 'Id Tipo Cliente',
            'Activo' => 'Activo',
            'IdMunicipio' => 'Id Municipio',
            'IdPadre' => 'Id Padre',
            'IdMadre' => 'Id Madre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsentamiento()
    {
        return $this->hasOne(Asentamiento::className(), ['IdPersona' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefuncion()
    {
        return $this->hasOne(Defuncion::className(), ['IdDifunto' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['IdPersona' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidas()
    {
        return $this->hasMany(Partida::className(), ['IdPersona' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMadre()
    {
        return $this->hasOne(Persona::className(), ['Id' => 'IdMadre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['IdMadre' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPadre()
    {
        return $this->hasOne(Persona::className(), ['Id' => 'IdPadre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas0()
    {
        return $this->hasMany(Persona::className(), ['IdPadre' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstadoCivil()
    {
        return $this->hasOne(EstadoCivil::className(), ['Id' => 'IdEstadoCivil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['Id' => 'IdMunicipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoCliente()
    {
        return $this->hasOne(TipoCliente::className(), ['Id' => 'IdTipoCliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnyons()
    {
        return $this->hasMany(Unyon::className(), ['IdEsposa' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnyons0()
    {
        return $this->hasMany(Unyon::className(), ['IdEsposo' => 'Id']);
    }
}
