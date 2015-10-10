<?php

namespace app\models\mant;

use Yii;

/**
 * This is the model class for table "matrimonio_persona".
 *
 * @property integer $codigo
 * @property integer $cod_persona
 * @property integer $cod_matrimonio
 *
 * @property Matrimonio $codMatrimonio
 * @property Persona $codPersona
 */
class MatrimonioPersona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $cod_conhom;
    public $cod_conmuj;
    public static function tableName()
    {
        return 'matrimonio_persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_persona', 'cod_matrimonio'], 'required'],
            [['cod_persona', 'cod_matrimonio'], 'integer'],
            [['cod_persona', 'cod_matrimonio'], 'unique', 'targetAttribute' => ['cod_persona', 'cod_matrimonio'], 'message' => 'The combination of Cod Persona and Cod Matrimonio has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'cod_persona' => 'Contrayente',
            'cod_matrimonio' => 'Cod Matrimonio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodMatrimonio()
    {
        return $this->hasOne(Matrimonio::className(), ['codigo' => 'cod_matrimonio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodPersona()
    {
        return $this->hasOne(Persona::className(), ['codigo' => 'cod_persona']);
    }
}
