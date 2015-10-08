<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "informante".
 *
 * @property integer $codigo
 * @property string $nombre
 * @property string $tipo_documento
 * @property string $numero_documento
 * @property string $genero
 * @property integer $cod_persona
 *
 * @property Persona $codPersona
 * @property Partida[] $partidas
 */
class Informante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'informante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'tipo_documento', 'numero_documento', 'genero'], 'required'],
            [['cod_persona'], 'integer'],
            [['nombre', 'tipo_documento', 'numero_documento', 'genero'], 'string', 'max' => 50],
            [['nombre'], 'unique'],
            [['numero_documento'], 'unique'],
            [['cod_persona'], 'unique']
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
            'tipo_documento' => 'Tipo Documento',
            'numero_documento' => 'Numero Documento',
            'genero' => 'Genero',
            'cod_persona' => 'Cod Persona',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodPersona()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_persona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidas()
    {
        return $this->hasMany(Partida::className(), ['cod_informante' => 'codigo']);
    }
}
