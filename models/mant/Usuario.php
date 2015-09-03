<?php

namespace app\models\mant;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuario".
 *
 * @property string $nombre
 * @property string $contrasenya
 * @property string $salt
 * @property integer $cod_rol
 *
 * @property Empleado $empleado
 * @property Rol $codRol
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'contrasenya', 'salt', 'cod_rol'], 'required'],
            [['cod_rol'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['contrasenya'], 'string', 'max' => 128],
            [['salt'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'contrasenya' => 'Contraseña',
            'salt' => 'Salt',
            'cod_rol' => 'Rol',
        ];
    }

    public static function findByUsername($username)
    {
        return static::findOne(['nombre' => $username]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }

    public static function findByPasswordResetToken($token)
    {
       $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
       $parts = explode('_', $token);
       $timestamp = (int) end($parts);
       if ($timestamp + $expire < time()) {
           // token expired
           return null;
       }

       return static::findOne([
           'password_reset_token' => $token
       ]);
   }

   public function getId()
   {
       return $this->getPrimaryKey();
   }

   public function getAuthKey()
   {
       return $this->auth_key;
   }

   public function validateAuthKey($authKey)
   {
       return $this->getAuthKey() === $authKey;
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['nombre_usuario' => 'nombre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodRol()
    {
        return $this->hasOne(Rol::className(), ['codigo' => 'cod_rol']);
    }
}
