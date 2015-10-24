<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "tipo_doc_identidad".
 *
 * @property integer $codigo
 * @property string $nombre
 */
class TipoDocIdentidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_doc_identidad';
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
}
