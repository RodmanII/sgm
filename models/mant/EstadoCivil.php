<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "estado_civil".
 *
 * @property integer $codigo
 * @property string $nombre
 *
 * @property Persona[] $personas
 * @property PersonaHistorico[] $personaHistoricos
 */
class EstadoCivil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estado_civil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['cod_estado_civil' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonaHistoricos()
    {
        return $this->hasMany(PersonaHistorico::className(), ['cod_estado_civil' => 'codigo']);
    }
}
