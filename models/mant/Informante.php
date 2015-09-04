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
 *
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
            [['nombre', 'tipo_documento', 'numero_documento'], 'required'],
            [['nombre'], 'string', 'max' => 50],
            [['tipo_documento', 'numero_documento'], 'string', 'max' => 20],
            [['nombre'], 'unique'],
            [['numero_documento'], 'unique']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidas()
    {
        return $this->hasMany(Partida::className(), ['cod_informante' => 'codigo']);
    }
}
