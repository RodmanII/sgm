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
 * @property string $est_civ_h
 * @property string $est_civ_m
 * @property string $apellido_casada
 * @property integer $cod_reg_patrimonial
 * @property integer $cod_partida
 * @property integer $num_etr_publica
 *
 * @property Divorcio $divorcio
 * @property Partida $codPartida
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
            [['notario', 'testigos', 'est_civ_h', 'est_civ_m', 'cod_reg_patrimonial', 'cod_partida', 'num_etr_publica'], 'required'],
            [['cod_reg_patrimonial', 'cod_partida', 'num_etr_publica', 'est_civ_h', 'est_civ_m'], 'integer'],
            [['notario', 'padre_contrayente_h', 'madre_contrayente_h', 'padre_contrayente_m', 'madre_contrayente_m', 'apellido_casada'], 'string', 'max' => 50],
            [['testigos'], 'string', 'max' => 300],
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
         'notario' => 'Notario',
         'testigos' => 'Testigos',
         'padre_contrayente_h' => 'Padre del Contrayente',
         'madre_contrayente_h' => 'Madre del Contrayente',
         'padre_contrayente_m' => 'Padre de la Contrayente',
         'madre_contrayente_m' => 'Madre de la Contrayente',
         'cod_reg_patrimonial' => 'Régimen Patrimonial',
         'num_etr_publica' => 'Número de Escritura Pública',
         'est_civ_h' => 'Estado Civil del Contrayente',
         'est_civ_m' => 'Estado Civil de la Contrayente',
         'apellido_casada' => 'Apellido de Casada',
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
    public function getCodPartida()
    {
        return $this->hasOne(Partida::className(), ['codigo' => 'cod_partida']);
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
