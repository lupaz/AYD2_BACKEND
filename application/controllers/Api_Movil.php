<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Movil extends CI_Controller {

	function __construct() {
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		parent::__construct();
	}

	public function get_catedraticos()
	{
		$this->load->model('catedratico_model');
		$docentes = $this->catedratico_model->getCatedraticos();
		echo  json_encode($docentes);
	}

	public function add_estudiante()
	{
		$this->load->model('catedratico_model');
		
		//$_POST = json_decode (file_get_contents ('php://input'), true);
		
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$contrasena = $_POST['contrasena'];
		$cui = $_POST['cui'];
		$carnet = $_POST['carnet'];
		$carrera =  $_POST['carrera'];

		//echo  json_encode($_POST['nombre'].'=>'.$_POST['contrasena']);

        $result = $this->catedratico_model-> addUsuario($nombre, $apellido, $carnet,$cui,$contrasena,$carrera);

        if ($result == FALSE ) {
            echo  json_encode(array('status' => 'failed'));
        } else {
            echo  json_encode(array('status' => 'success'));
        }
	}

	public function login_user(){
		$this->load->model('catedratico_model');
		
		$carnet = $_POST['carnet'];
		$contrasena = $_POST['contrasena'];

		$result = $this->catedratico_model->login($carnet,$contrasena);

		$json = (array)$result;

		if(!empty($json)){
			echo  json_encode($result);
		}else{
			echo  json_encode(array('status' => 'failed'));
		}
	}

	public function get_cursos(){
		$this->load->model('catedratico_model');
		$id_personal = $_POST['id_personal'];
		$result = $this->catedratico_model->getcursos($id_personal);
		//if(!empty($result)){
			echo  json_encode($result);
		//}else{
			//echo  json_encode(array('status' => 'success'));
		//}
	}

}
