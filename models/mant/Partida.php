<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "partida".
 *
 * @property integer $numero
 * @property integer $folio
 * @property string $fecha_emision
 * @property string $fecha_suceso
 * @property string $hora_suceso
 * @property string $lugar_suceso
 * @property integer $cod_empleado
 * @property integer $cod_municipio
 * @property integer $cod_informante
 * @property integer $cod_libro
 *
 * @property Defuncion $defuncion
 * @property Divorcio $divorcio
 * @property Matrimonio $matrimonio
 * @property Nacimiento $nacimiento
 * @property Empleado $codEmpleado
 * @property Informante $codInformante
 * @property Libro $codLibro
 * @property Municipio $codMunicipio
 */
class Partida extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partida';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['folio', 'fecha_emision', 'fecha_suceso', 'hora_suceso', 'lugar_suceso', 'cod_empleado', 'cod_municipio', 'cod_informante', 'cod_libro'], 'required'],
            [['folio', 'cod_empleado', 'cod_municipio', 'cod_informante', 'cod_libro'], 'integer'],
            [['fecha_emision', 'fecha_suceso', 'hora_suceso'], 'safe'],
            [['lugar_suceso'], 'string', 'max' => 100],
            [['folio', 'cod_libro'], 'unique', 'targetAttribute' => ['folio', 'cod_libro'], 'message' => 'The combination of Folio and Cod Libro has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Número',
            'folio' => 'Folio',
            'fecha_emision' => 'Fecha de Emisión',
            'fecha_suceso' => 'Fecha de Suceso',
            'hora_suceso' => 'Hora de Suceso',
            'lugar_suceso' => 'Lugar de Suceso',
            'cod_empleado' => 'Empleado',
            'cod_municipio' => 'Municipio',
            'cod_informante' => 'Informante',
            'cod_libro' => 'Libro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefuncion()
    {
        return $this->hasOne(Defuncion::className(), ['num_partida' => 'numero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivorcio()
    {
        return $this->hasOne(Divorcio::className(), ['num_partida' => 'numero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatrimonio()
    {
        return $this->hasOne(Matrimonio::className(), ['num_partida' => 'numero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNacimiento()
    {
        return $this->hasOne(Nacimiento::className(), ['num_partida' => 'numero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['codigo' => 'cod_empleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodInformante()
    {
        return $this->hasOne(Informante::className(), ['codigo' => 'cod_informante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodLibro()
    {
        return $this->hasOne(Libro::className(), ['codigo' => 'cod_libro']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['codigo' => 'cod_municipio']);
    }
}
