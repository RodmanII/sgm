<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "divorcio".
 *
 * @property integer $codigo
 * @property string $juez
 * @property string $fecha_ejecucion
 * @property string $detalle
 * @property integer $num_partida
 * @property integer $cod_mod_divorcio
 * @property integer $cod_matrimonio
 *
 * @property Matrimonio $codMatrimonio
 * @property ModalidadDivorcio $codModDivorcio
 * @property Partida $numPartida
 */
class Divorcio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'divorcio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['juez', 'fecha_ejecucion', 'num_partida', 'cod_mod_divorcio', 'cod_matrimonio'], 'required'],
            [['fecha_ejecucion'], 'safe'],
            [['num_partida', 'cod_mod_divorcio', 'cod_matrimonio'], 'integer'],
            [['juez'], 'string', 'max' => 50],
            [['detalle'], 'string', 'max' => 300],
            [['num_partida'], 'unique'],
            [['cod_matrimonio'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Número',
            'juez' => 'Juez',
            'fecha_ejecucion' => 'Fecha de Ejecución de Sentencia',
            'detalle' => 'Detalles Adicionales',
            'num_partida' => 'Num Partida',
            'cod_mod_divorcio' => 'Modalidad de Divorcio',
            'cod_matrimonio' => 'Partida de Matrimonio Asociada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodMatrimonio()
    {
        return $this->hasOne(Matrimonio::className(), ['codigo' => 'cod_matrimonio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodModDivorcio()
    {
        return $this->hasOne(ModalidadDivorcio::className(), ['codigo' => 'cod_mod_divorcio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumPartida()
    {
        return $this->hasOne(Partida::className(), ['numero' => 'num_partida']);
    }
}
