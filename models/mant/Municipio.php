<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "municipio".
 *
 * @property integer $codigo
 * @property string $nombre
 * @property integer $cod_departamento
 *
 * @property Hospital[] $hospitals
 * @property Departamento $codDepartamento
 * @property Partida[] $partidas
 * @property Persona[] $personas
 */
class Municipio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'cod_departamento'], 'required'],
            [['cod_departamento'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre', 'cod_departamento'], 'unique', 'targetAttribute' => ['nombre', 'cod_departamento'], 'message' => 'The combination of Nombre and Cod Departamento has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'cod_departamento' => 'Cod Departamento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitals()
    {
        return $this->hasMany(Hospital::className(), ['cod_municipio' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['codigo' => 'cod_departamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidas()
    {
        return $this->hasMany(Partida::className(), ['cod_municipio' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['cod_municipio' => 'codigo']);
    }
}
