<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Kernel
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class KPerceptron extends CI_Model{

	var $Neurona = array();

	var $NeuronaArtificial = array();
  
  	/**
	* Iniciando la clase, Cargando Elementos Pace
	*
	* @access public
	* @return void
	*/
	public function __construct(){
		parent::__construct();
	}


	function Aprender($patron, $conocimiento){
		$this->Neurona[$patron] = $conocimiento;
	}
	function AprenderArtificial($patron, $ced, $conocimiento){
		$this->NeuronaArtificial[$patron] = $conocimiento;
	}


	function Recordar($pensamiento){
		$Recuerdo = array();
		if (isset($Neurona[$pensamiento])){
			$Recuerdo = $Neurona[$pensamiento];
			return $Recuerdo;
		}
	}

	function SalvarRecuerdos(){
		
	}

}
