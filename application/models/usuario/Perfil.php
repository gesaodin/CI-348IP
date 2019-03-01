<?php

/**
 * Seguridad MamonSoft C.A
 * 
 *
 * @package mamonsoft.modules.seguridad
 * @subpackage perfil
 * @author Carlos Peña
 * @copyright	Derechos Reservados (c) 2014 - 2015, MamonSoft C.A.
 * @link		http://www.mamonsoft.com.ve
 * @since Version 1.0
 *
 */

class Perfil extends CI_Model{
	
	var $identificador;
	
	var $nombre;
	
	var $descripcion;

	var $Privilegios = array();

	var $Dependientes = array();
	
	
	
	function __construct() {
		parent::__construct();
		$this->load->model("comun/DBSpace");
		
	
	}
	
	function listar(){		
		$s = 'SELECT oid, nomb FROM space.menu';
		$obj = $this->DBSpace->consultar($s);
		return $obj->rs;
	}

	function listarSubMenu($id){
		$s = 'SELECT oid, url, obse FROM space.menu_accion WHERE idmenu=' . $id;
		$obj = $this->DBSpace->consultar($s);
		return $obj->rs;
	}

	/**
	*	Listar Perfiles con privilegios
	* 
	*	
	*/
	function listarPerfilPrivilegios($url, $id = 0){
		$s = 'SELECT p.oid,p.nomb,prv.oid AS oidp,prv.id, prv.nomb AS bnom, COALESCE(upp.visi,0) AS visi
				FROM space.privilegio prv
				JOIN space.menu_accion ma ON prv.para=ma.url
				JOIN space.perfil_privilegio pp ON pp.oidpr=prv.oid
				JOIN space.perfil p ON p.oid=pp.oidp
				LEFT JOIN space.usuario_perfil up on p.oid=up.oidp
				LEFT JOIN space.usuario u ON u.id=up.oidu
				LEFT JOIN space.usuario_perfil_privilegio upp ON 
				upp.oidu = u.id AND
				upp.oidp = p.oid AND
				upp.oidpr = prv.oid
				WHERE ma.url=\'' . $url . '\' AND u.id=' . $id;

		
		//echo $s;
		$obj = $this->DBSpace->consultar($s);

		$lst = array();
		$lstp = array();
		if($obj->cant == 0 ){
			$s = 'SELECT p.oid,p.nomb,prv.oid AS oidp,prv.id, prv.nomb AS bnom, prv.visi
				FROM space.privilegio prv
				JOIN space.menu_accion ma ON prv.para=ma.url
				JOIN space.perfil_privilegio pp ON pp.oidpr=prv.oid
				JOIN space.perfil p ON p.oid=pp.oidp
				WHERE ma.url=\'' . $url . '\'';
			$obj = $this->DBSpace->consultar($s);
			if($obj->cant == 0 )return $lst;
		}
		
		$perfil =  $obj->rs[0]->nomb;
		foreach ($obj->rs as $clv => $v) {
			if($perfil != $v->nomb){
				$lst[$perfil] = $lstp;
				$perfil = $v->nomb;
				$lstp = null;
			}
			$lstp[] =  array(
				'oidp' => $v->oid,
				'cod'=> $v->oidp,
				'nomb' => $v->bnom,
				'visi' => $v->visi
			);
		}
		$lst[$perfil] = $lstp;
		
		return $lst;
	}

	function listarMenu($id = 0){
		$s = 'SELECT 
				ua.oid,ua.nomb,ua.obse,mnu.nomb as menu,ua.url,mnu.clase,ua.clase_, prv.id,prv.cod,prv.func,
				prv.nomb AS prvnomb, prv.clase AS clase_prv, COALESCE(upp.visi,0) AS visi
			FROM space.usuario u
			JOIN space.usuario_menu um ON u.id=um.oidu
			JOIN space.menu_accion ua ON um.oidm=ua.oid 
			LEFT JOIN (
				SELECT 
					u.id AS uid, p.oid AS pid, pr.oid AS proid, p.obse,
					pr.cod,pr.id,pr.func,pr.nomb,pr.clase, pr.para,pr.visi 
				FROM space.usuario u
				JOIN space.usuario_perfil up on u.id=up.oidu
				JOIN space.perfil p on p.oid = up.oidp
				JOIN space.perfil_privilegio pp ON p.oid=pp.oidp
				JOIN space.privilegio pr ON pp.oidpr=pr.oid
				WHERE u.id='  . $id . ') AS prv
			ON ua.url=prv.para 
			JOIN space.menu mnu ON ua.idmenu=mnu.oid
			LEFT JOIN space.usuario_perfil_privilegio upp ON 
				upp.oidu = prv.uid AND
				upp.oidp = prv.pid AND
				upp.oidpr = prv.proid
			WHERE u.id='  . $id . ' AND ua.esid = 1
			ORDER BY mnu.oid, ua.orde';

		$obj = $this->DBSpace->consultar($s);
		//echo $s;

	    $lst = array();
	    $lstpriv = array();

	    if($obj->code == 0 ){
	      $nombre = $obj->rs[0]->menu;
	      $observacion = $obj->rs[0]->url;
	   
	      foreach ($obj->rs as $clv => $val) {	  
	      	if ($observacion != $val->url ){
	      		$lst[$nombre][$observacion]['priv_'] = $lstpriv;
	      		$nombre = $val->menu;
	      		$observacion = $val->url;
	      		$lstpriv = null;
	      	}	
	      	$lst[$val->menu][$val->url] = array(
	      		'oid' => $val->oid,
	          	'desc' => $val->obse, 
	          	'menu' => $val->menu,
	          	'url' => $val->url,
	          	'clase' => $val->clase,
	          	'clase_' => $val->clase_,
	          	'priv_' => array()
        	); 
	      	if ($val->id != ""){
	      		$lstpriv[$val->id] = array(
	      			'tipo' => $val->cod,
	      			'cod' => $val->id,
	      			'nomb' => $val->prvnomb,
	      			'clas' => $val->clase_prv,
	      			'func' => $val->func,
	      			'visi' => $val->visi
	      		);
	      	}
	      }
	      $lst[$nombre][$observacion]['priv_'] = $lstpriv;
	    }
	    return json_encode($lst);

	}	
	
	function listaPrivilegios() {
		$s = 'select pr.cod,pr.id,pr.func,pr.nomb,pr.clase from space.usuario u
		join space.usuario_perfil up on u.id=up.oidu
		join space.perfil p on p.oid = up.oidp
		join space.perfil_privilegio pp ON p.oid=pp.oidp
		join space.privilegio pr ON pp.oidpr=pr.oid';
		$obj = $this->DBSpace->consultar($s);
		$lst = array();
		if($obj->code == 0 ){
			$nombre = $obj->rs[0]->menu;

			foreach ($obj->rs as $clv => $val) {

				if($nombre != $val->menu){
					$lst[$nombre] = $pr;
					$nombre = $val->menu;

					$pr = null;
				}
				$pr[] = array(
					'desc' => $val->obse, 
					'menu' => $val->menu,
					'url' => $val->url,
					'clase' => $val->clase,
					'clase_' => $val->clase_	 
					);


			}
			$lst[$nombre] = $pr;
		}


	}
	

	function InsertPerfil($uid, $idp){
		$s = 'INSERT INTO space.usuario_perfil (oidu,oidp) VALUES (' . $uid . ',' . $idp . ');';
		$obj = $this->DBSpace->consultar($s);
		
		return $obj->cant;
	}

	function InsertMenu($uid, $idm){
		$s = 'INSERT INTO space.usuario_menu (oidu,oidm) VALUES (' . $uid . ',' . $idm . ');';
		$obj = $this->DBSpace->consultar($s);
		
		return $obj->cant;
	}

	function DeleteMenu($uid, $idm){
		$s = 'DELETE FROM space.usuario_menu WHERE oidu=' . $uid . ' AND oidm=' . $idm . ');';
		$obj = $this->DBSpace->consultar($s);
		return $obj->rs;
	}


	


	function UpsertPrivilegio($uid, $idp, $idpr, $visi){
		$upsert = 'WITH UPSERT AS (
			UPDATE space.usuario_perfil_privilegio 
			SET visi=' . $visi . ' WHERE oidu = ' . $uid . ' AND oidp = ' . $idp . ' AND oidpr= ' . $idpr . '
			RETURNING *
		)
		INSERT INTO 
			space.usuario_perfil_privilegio 
			(oidu,oidp,oidpr, visi) 
		select ' . $uid . ',' . $idp . ',' . $idpr . ',' . $visi . ' WHERE NOT EXISTS (SELECT * FROM upsert)';

		//echo $upsert;

		$obj = $this->DBSpace->consultar($upsert);
		//print_r($obj);
		return $obj->cant;
	}



	function __destruct(){
		unset($this->db);
	}
	
}
