<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\mant\Usuario;
use app\models\mant\Persona;

class LoginForm extends Model
{
    public $usuario;
    public $password;
    public $rememberMe = false;

    private $_user = false;

    public function rules()
    {
        return [
            // username and password are both required
            [['usuario', 'password'], 'required', 'message'=>'{attribute} es obligatorio'],
            ['usuario', 'match', 'pattern'=>'/^[a-zA-Z-_\d]+$/', 'message'=>'Solo se permiten caracteres alfanúmericos'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'password'=> 'Contraseña',
            'rememberMe'=> 'Mantener sesión activa'
        ];
    }

    public function login()
    {
      if($this->validate()){
        $dbUsuario = Usuario::find()->where('nombre = :user', [':user'=>$this->usuario])->one();
        if(count($dbUsuario)<=0){
          $this->addError('usuario', 'El usuario ingresado no existe');
          return false;
        }else{
          //->innerJoinWith('codPersona',false)
          $dbPersona = Persona::find()->where('nombre_usuario = :user',[':user'=>$this->usuario])
          ->andWhere('estado = :estado',[':estado'=>'Activo'])->one();
          if(count($dbPersona)<=0){
            //Esto me quiere decir que el usuario existe, pero o no esta asociado a ningun empleado o su estado es diferente de activo
            $this->addError('usuario', 'El usuario ingresado no está asociado con ninguna persona o se encuentra inactivo');
            return false;
          }else{
            if(hash('sha512',$this->password.$dbUsuario->salt) === $dbUsuario->contrasenya){
              $nombrePersona = $dbUsuario->persona->nombre.' '.$dbUsuario->persona->apellido;
              Yii::$app->session->setFlash('success', '¡Bienvenid@! '.$nombrePersona);
              return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            }else{
              $this->addError('password','La contraseña ingresada es errónea');
              return false;
            }
          }
        }
      }else {
        return false;
      }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuario::findByUsername($this->usuario);
        }

        return $this->_user;
    }
}
