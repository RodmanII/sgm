<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "matrimonio".
 *
 * @property integer $codigo
 * @property string $notario
 * @property string $testigos
 * @property string $padre_contrayente_h
 * @property string $madre_contrayente_h
 * @property string $padre_contrayente_m
 * @property string $madre_contrayente_m
 * @property integer $cod_reg_patrimonial
 * @property integer $num_partida
 *
 * @property Divorcio $divorcio
 * @property Partida $numPartida
 * @property RegimenPatrimonial $codRegPatrimonial
 * @property MatrimonioPersona[] $matrimonioPersonas
 */
class Matrimonio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'matrimonio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notario', 'testigos', 'cod_reg_patrimonial', 'num_partida'], 'required'],
            [['cod_reg_patrimonial', 'num_partida'], 'integer'],
            [['notario', 'padre_contrayente_h', 'madre_contrayente_h', 'padre_contrayente_m', 'madre_contrayente_m'], 'string', 'max' => 50],
            [['testigos'], 'string', 'max' => 300],
            [['num_partida'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'notario' => 'Notario',
            'testigos' => 'Testigos',
            'padre_contrayente_h' => 'Padre del Contrayente',
            'madre_contrayente_h' => 'Madre del Contrayente',
            'padre_contrayente_m' => 'Padre de la Contrayente',
            'madre_contrayente_m' => 'Madre de la Contrayente',
            'cod_reg_patrimonial' => 'Régimen Patrimonial',
            'num_partida' => 'Num Partida',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivorcio()
    {
        return $this->hasOne(Divorcio::className(), ['cod_matrimonio' => 'codigo']);
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
    public function getCodRegPatrimonial()
    {
        return $this->hasOne(RegimenPatrimonial::className(), ['codigo' => 'cod_reg_patrimonial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatrimonioPersonas()
    {
        return $this->hasMany(MatrimonioPersona::className(), ['cod_matrimonio' => 'codigo']);
    }
}
