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
 * @property string $firma
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
            ['firma', 'required', 'on' => 'create'],
            [['cod_persona'], 'integer'],
            [['nombre', 'tipo_documento', 'numero_documento', 'genero'], 'string', 'max' => 50],
            [['firma'], 'string', 'max' => 150],
            [['nombre'], 'unique'],
            [['firma'], 'unique'],
            [['firma'], 'safe'],
            [['firma'], 'file', 'extensions'=>'jpg, png'],
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
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'tipo_documento' => 'Tipo de Documento',
            'numero_documento' => 'Número de Documento',
            'genero' => 'Género',
            'cod_persona' => 'Persona',
            'firma' => 'Firma',
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
