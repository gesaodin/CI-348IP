<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Seguridad MamonSoft C.A
 * 
 *
 * @package mamonsoft.modules.seguridad
 * @subpackage iniciar
 * @author Carlos Peña
 * @copyright	Derechos Reservados (c) 2014 - 2015, MamonSoft C.A.
 * @link		http://www.mamonsoft.com.ve
 * @since Version 1.0
 *
 */



class Iniciar extends CI_Model {

  var $token = null;

  function __construct() {
    parent::__construct();

    $this -> load -> model('usuario/Usuario', 'Usuario');
  }

  function validarCuenta($arg = null) {
    $this -> Usuario -> sobreNombre = $arg['usuario'];
    $this -> Usuario -> clave = $arg['clave'];
 
    if ($this -> Usuario -> validar() == TRUE) {
      $this -> _entrar($this -> Usuario);
      return TRUE;
    } else {
      $this -> _salir();
      return FALSE;
    }
  }

  private function _entrar($usuario) {
    
   $this->session->set_userdata(array(
        'usuario' => $usuario->login,
        'nombre' => $usuario->nombre .  ' ' . $usuario->apellido,
        'id' => $usuario->id,
        'correo' => $usuario->correo,
        'estatus' => $usuario->estatus,
        'perfil' => $usuario->perfil,
        'roles' => $usuario->listaRoles,
        'ultimaConexion' => '', //$usuario->ultimaConexion()
      )
    );
   /**
    $this->load->model('comun/Dbipsfa');
    $arr = array(
      'cedu' => $usuario->cedula,
      'obse' => 'Inicio de Sesión',
      'fech' => 'now()',
      'app' => 'Panel',
      'tipo' => 0
      );

    $this->Dbipsfa->insertarArreglo('bss.traza', $arr);**/
  }

  private function _salir() {
    redirect('panel/Login/salir');
  }

  function msj(){
    echo 'mensaje';
  }

}
