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
 * @property integer $num_partida
 *
 * @property Hospital $codHospital
 * @property Partida $numPartida
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
            [['cod_padre', 'cod_madre', 'cod_asentado', 'cod_hospital', 'num_partida'], 'integer'],
            [['cod_asentado', 'cod_hospital', 'num_partida'], 'required'],
            [['cod_asentado'], 'unique'],
            [['num_partida'], 'unique']
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
            'cod_asentado' => 'Menor Asentado',
            'cod_hospital' => 'Hospital',
            'num_partida' => 'Número de Partida',
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
    public function getNumPartida()
    {
        return $this->hasOne(Partida::className(), ['numero' => 'num_partida']);
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
