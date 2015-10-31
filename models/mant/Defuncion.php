<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "defuncion".
 *
 * @property integer $codigo
 * @property string $determino_causa
 * @property string $alc_partida
 * @property string $datos_partida
 * @property string $familiares
 * @property integer $con_asistencia
 * @property integer $cod_difunto
 * @property integer $cod_causa
 * @property integer $cod_partida
 *
 * @property CausaDefuncion $codCausa
 * @property Partida $codPartida
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
            [['determino_causa', 'familiares', 'con_asistencia', 'cod_difunto', 'cod_causa', 'cod_partida'], 'required'],
            [['con_asistencia', 'cod_difunto', 'cod_causa', 'cod_partida'], 'integer'],
            [['determino_causa', 'alc_partida'], 'string', 'max' => 100],
            [['datos_partida', 'familiares'], 'string', 'max' => 300],
            [['cod_difunto'], 'unique'],
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
         'determino_causa' => 'Profesional quién determino la causa',
         'familiares' => 'Familiares',
         'cod_difunto' => 'Difunto',
         'cod_causa' => 'Causa de Defunción',
         'cod_partida' => 'Número',
         'alc_partida' => 'Alcaldía de Origen de la Partida',
         'datos_partida' => 'Datos de Partida',
         'con_asistencia' => 'Recibió Asistencia',
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
    public function getCodPartida()
    {
        return $this->hasOne(Partida::className(), ['codigo' => 'cod_partida']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodDifunto()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_difunto']);
    }
}
