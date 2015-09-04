<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "causa_defuncion".
 *
 * @property integer $codigo
 * @property string $nombre
 *
 * @property Defuncion[] $defuncions
 */
class CausaDefuncion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'causa_defuncion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
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
    public function getDefuncions()
    {
        return $this->hasMany(Defuncion::className(), ['cod_causa' => 'codigo']);
    }
}
