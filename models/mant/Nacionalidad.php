<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "nacionalidad".
 *
 * @property integer $codigo
 * @property string $nombre
 * @property string $pais
 *
 * @property Persona[] $personas
 * @property PersonaHistorico[] $personaHistoricos
 */
class Nacionalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nacionalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'pais'], 'required'],
            [['nombre', 'pais'], 'string', 'max' => 50],
            [['nombre'], 'unique'],
            [['pais'], 'unique']
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
            'pais' => 'Pais',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['cod_nacionalidad' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonaHistoricos()
    {
        return $this->hasMany(PersonaHistorico::className(), ['cod_nacionalidad' => 'codigo']);
    }
}
