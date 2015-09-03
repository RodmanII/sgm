<?php

namespace app\models\mant;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuario".
 *
 * @property string $Nombre
 * @property string $Constrasenya
 * @property string $Salt
 * @property integer $Activo
 * @property integer $IdEmpleado
 *
 * @property Empleado $idEmpleado
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
            [['Nombre', 'Constrasenya', 'Salt', 'IdEmpleado'], 'required'],
            [['Activo', 'IdEmpleado'], 'integer'],
            [['Nombre'], 'string', 'max' => 50],
            [['Constrasenya'], 'string', 'max' => 128],
            [['Salt'], 'string', 'max' => 11],
            [['IdEmpleado'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Nombre' => 'Nombre',
            'Constrasenya' => 'Constrasenya',
            'Salt' => 'Salt',
            'Activo' => 'Activo',
            'IdEmpleado' => 'Id Empleado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['Id' => 'IdEmpleado']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['Nombre' => $username]);
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

   /**
    * @inheritdoc
    */
   public function getId()
   {
       return $this->getPrimaryKey();
   }

   /**
    * @inheritdoc
    */
   public function getAuthKey()
   {
       return $this->auth_key;
   }

   /**
    * @inheritdoc
    */
   public function validateAuthKey($authKey)
   {
       return $this->getAuthKey() === $authKey;
   }

   /**
    * Validates password
    *
    * @param  string  $password password to validate
    * @return boolean if password provided is valid for current user
    */
   public function validatePassword($password)
   {
       return $this->password === sha1($password);
   }

   /**
    * Generates password hash from password and sets it to the model
    *
    * @param string $password
    */
   public function setPassword($password)
   {
       $this->password_hash = Security::generatePasswordHash($password);
   }

   /**
    * Generates "remember me" authentication key
    */
   public function generateAuthKey()
   {
       $this->auth_key = Security::generateRandomKey();
   }

   /**
    * Generates new password reset token
    */
   public function generatePasswordResetToken()
   {
       $this->password_reset_token = Security::generateRandomKey() . '_' . time();
   }

   /**
    * Removes password reset token
    */
   public function removePasswordResetToken()
   {
       $this->password_reset_token = null;
   }

}
