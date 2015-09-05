<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "modalidad_divorcio".
 *
 * @property integer $codigo
 * @property string $nombre
 *
 * @property Divorcio[] $divorcios
 */
class ModalidadDivorcio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modalidad_divorcio';
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
    public function getDivorcios()
    {
        return $this->hasMany(Divorcio::className(), ['cod_mod_divorcio' => 'codigo']);
    }
}
