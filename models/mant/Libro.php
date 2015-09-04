<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "libro".
 *
 * @property integer $codigo
 * @property integer $numero
 * @property string $anyo
 * @property string $tipo
 * @property integer $cerrado
 *
 * @property Partida[] $partidas
 */
class Libro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'libro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero', 'anyo', 'tipo'], 'required'],
            [['numero', 'cerrado'], 'integer'],
            [['anyo'], 'safe'],
            [['tipo'], 'string', 'max' => 50],
            [['numero', 'anyo', 'tipo'], 'unique', 'targetAttribute' => ['numero', 'anyo', 'tipo'], 'message' => 'The combination of Numero, Anyo and Tipo has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'numero' => 'Numero',
            'anyo' => 'Anyo',
            'tipo' => 'Tipo',
            'cerrado' => 'Cerrado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidas()
    {
        return $this->hasMany(Partida::className(), ['cod_libro' => 'codigo']);
    }
}
