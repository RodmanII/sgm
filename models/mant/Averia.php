<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "averia".
 *
 * @property integer $codigo
 * @property string $fecha
 * @property string $hora
 * @property string $descripcion
 * @property string $gravedad
 * @property integer $num_vehiculo
 *
 * @property Vehiculo $numVehiculo
 */
class Averia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'averia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'hora', 'descripcion', 'gravedad', 'num_vehiculo'], 'required'],
            [['fecha', 'hora'], 'safe'],
            [['num_vehiculo'], 'integer'],
            [['descripcion'], 'string', 'max' => 300],
            [['gravedad'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'descripcion' => 'Descripcion',
            'gravedad' => 'Gravedad',
            'num_vehiculo' => 'Num Vehiculo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumVehiculo()
    {
        return $this->hasOne(Vehiculo::className(), ['numero' => 'num_vehiculo']);
    }
}
