<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "regimen_patrimonial".
 *
 * @property integer $codigo
 * @property string $nombre
 * @property string $descripcion
 *
 * @property Matrimonio[] $matrimonios
 */
class RegimenPatrimonial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regimen_patrimonial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 300],
            [['nombre'], 'unique']
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
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatrimonios()
    {
        return $this->hasMany(Matrimonio::className(), ['cod_reg_patrimonial' => 'codigo']);
    }
}
