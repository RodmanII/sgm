<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "nacimiento".
 *
 * @property integer $codigo
 * @property integer $cod_padre
 * @property integer $cod_madre
 * @property integer $cod_asentado
 * @property integer $cod_hospital
 * @property integer $cod_partida
 * @property string $rel_informante
 * @property integer $edad_padre
 * @property integer $edad_madre
 * @property string $doc_presentado
 *
 * @property Hospital $codHospital
 * @property Partida $codPartida
 * @property Persona $codAsentado
 * @property Persona $codMadre
 * @property Persona $codPadre
 */
class Nacimiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nacimiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_padre', 'cod_madre', 'cod_asentado', 'cod_hospital', 'cod_partida', 'edad_padre', 'edad_madre'], 'integer'],
            [['cod_asentado', 'cod_partida', 'rel_informante', 'doc_presentado'], 'required'],
            [['rel_informante', 'doc_presentado'], 'string', 'max' => 50],
            [['cod_asentado'], 'unique'],
            [['cod_partida'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Código',
            'cod_padre' => 'Padre',
            'cod_madre' => 'Madre',
            'cod_asentado' => 'Asentado',
            'cod_hospital' => 'Hospital',
            'cod_partida' => 'Partida',
            'rel_informante' => 'Relación del Informante',
            'edad_padre' => 'Edad del Padre',
            'edad_madre' => 'Edad de la Madre',
            'doc_presentado' => 'Documento Presentado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodHospital()
    {
        return $this->hasOne(Hospital::className(), ['codigo' => 'cod_hospital']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodPartida()
    {
        return $this->hasOne(Partida::className(), ['codigo' => 'cod_partida']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodAsentado()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_asentado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodMadre()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_madre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodPadre()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_padre']);
    }
}
