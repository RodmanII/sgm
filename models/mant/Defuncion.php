<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "defuncion".
 *
 * @property integer $codigo
 * @property string $determino_causa
 * @property string $familiares
 * @property integer $cod_difunto
 * @property integer $cod_causa
 * @property integer $num_partida
 *
 * @property CausaDefuncion $codCausa
 * @property Partida $numPartida
 * @property Persona $codDifunto
 */
class Defuncion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'defuncion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['determino_causa', 'familiares', 'cod_difunto', 'cod_causa', 'num_partida'], 'required'],
            [['cod_difunto', 'cod_causa', 'num_partida'], 'integer'],
            [['determino_causa'], 'string', 'max' => 100],
            [['familiares'], 'string', 'max' => 300],
            [['cod_difunto'], 'unique'],
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
            'determino_causa' => 'Profesional quién determino la causa',
            'familiares' => 'Familiares',
            'cod_difunto' => 'Persona Difunta',
            'cod_causa' => 'Causa de Defunción',
            'num_partida' => 'Número',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodCausa()
    {
        return $this->hasOne(CausaDefuncion::className(), ['codigo' => 'cod_causa']);
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
    public function getCodDifunto()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_difunto']);
    }
}
