<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "lugar".
 *
 * @property integer $codigo
 * @property string $nombre
 * @property string $latitud
 * @property string $longitud
 *
 * @property RutaLugar[] $rutaLugars
 */
class Lugar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lugar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'latitud', 'longitud'], 'required'],
            [['latitud', 'longitud'], 'number'],
            [['nombre'], 'string', 'max' => 50],
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
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutaLugars()
    {
        return $this->hasMany(RutaLugar::className(), ['cod_lugar' => 'codigo']);
    }
}
