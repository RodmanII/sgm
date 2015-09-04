<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "hospital".
 *
 * @property integer $codigo
 * @property string $nombre
 * @property string $ubicacion
 * @property integer $cod_municipio
 *
 * @property Municipio $codMunicipio
 * @property Nacimiento[] $nacimientos
 */
class Hospital extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hospital';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'ubicacion', 'cod_municipio'], 'required'],
            [['cod_municipio'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['ubicacion'], 'string', 'max' => 50],
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
            'ubicacion' => 'Ubicacion',
            'cod_municipio' => 'Cod Municipio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['codigo' => 'cod_municipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNacimientos()
    {
        return $this->hasMany(Nacimiento::className(), ['cod_hospital' => 'codigo']);
    }
}
