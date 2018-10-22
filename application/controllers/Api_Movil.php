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

	public function calificacion_personal(){
		$this->load->model('catedratico_model');
		$carnet = $_POST['carnet'];
		$id_personal = $_POST['id_personal'];
		$result = $this->catedratico_model->calificacion($carnet,$id_personal);
		if(!empty($result)){
			echo  json_encode($result);
		}else{
			echo  json_encode(array('status' => 'success'));
		}
	}

	public function update_calificacion()
	{
		$this->load->model('catedratico_model');
		
		//$_POST = json_decode (file_get_contents ('php://input'), true);
		$carnet = $_POST['carnet'];
		$id_personal = $_POST['id_personal'];
		$dominio = $_POST['dominio'];
		$puntualidad = $_POST['puntualidad'];
		$responsabilidad = $_POST['responsabilidad'];
		$respesto =  $_POST['respeto'];
		$didactica = $_POST['didactica'];
		$comentario = $_POST['comentario'];
		//echo  json_encode($_POST['nombre'].'=>'.$_POST['contrasena']);
        $result = $this->catedratico_model-> updateCalificacion($carnet, $id_personal, $dominio,$puntualidad,$responsabilidad,$respesto,$didactica,$comentario);
        if ($result == FALSE ) {
            echo  json_encode(array('status' => 'failed'));
        } else {
            echo  json_encode(array('status' => 'success'));
        }
	}

	public function set_calificacion()
	{
		$this->load->model('catedratico_model');
		//$_POST = json_decode (file_get_contents ('php://input'), true);
		$carnet = $_POST['carnet'];
		$id_personal = $_POST['id_personal'];
		$dominio = $_POST['dominio'];
		$puntualidad = $_POST['puntualidad'];
		$responsabilidad = $_POST['responsabilidad'];
		$respesto =  $_POST['respeto'];
		$didactica = $_POST['didactica'];
		$comentario = $_POST['comentario'];
		//echo  json_encode($_POST['nombre'].'=>'.$_POST['contrasena']);
        $result = $this->catedratico_model-> setCalificacion($carnet, $id_personal, $dominio,$puntualidad,$responsabilidad,$respesto,$didactica,$comentario);
        if ($result == FALSE ){
            echo  json_encode(array('status' => 'failed'));
        }else{
            echo  json_encode(array('status' => 'success'));
        }
	}

	public function get_comentarios(){
		$this->load->model('catedratico_model');
		$id_personal = $_POST['id_personal'];
		$result = $this->catedratico_model->getComentarios($id_personal);
		echo  json_encode($result);
	}

	public function search_docente(){
		$this->load->model('catedratico_model');
		$nombre = $_POST['nombre'];
		$result = $this->catedratico_model->searchDocente($nombre);
		//if(!empty($result)){
			echo  json_encode($result);
		//}else{
		//	echo  json_encode(array('status' => 'success'));
		//}
	}

	public function search_curso(){
		$this->load->model('catedratico_model');
		$codigo = $_POST['codigo'];
		$result = $this->catedratico_model->searchCurso($codigo);
		//if(!empty($result)){
			echo  json_encode($result);
		//}else{
			//echo  json_encode(array('status' => 'success'));
		//}
	}

	//==================================================================================

	public function get_calificacion(){
		
		if (isset($_POST["id_personal"]) && !empty($_POST["id_personal"])) {
			$this->load->model('catedratico_model');	
			$id_personal = $_POST['id_personal'];
			$result = $this->catedratico_model->getCalificacion($id_personal);
			echo  json_encode($result);
		}else{
			$entrada = file_get_contents('php://input');
			$entrada = json_decode($entrada);
			$id_personal = $entrada->id_personal;			
			if( !empty($id_personal)){
				$this->load->model('catedratico_model');
				$result = $this->catedratico_model->getCalificacion($id_personal);
				echo  json_encode($result);
			}else{
				echo json_encode(array('status' => 'failed','description'=>'parametros incorrectos en la peticion','code'=>'301'));
			}
		}
	}

	public function get_calificaciones(){
		$this->load->model('catedratico_model');	
		$result = $this->catedratico_model->getCalificaciones();
		$General = array();
		foreach($result as $res){
			$tmp= array();
			$tmp2= array();
			$tmp3 = array();
			$i=0;
			foreach($res as $key=>$valor){
				if($i<6){
					$tmp[$key] = $valor;
				}elseif($i<9){
					if($i == 7){
						$tmp2['nombre'] = $valor;
					}elseif($i == 8){
						$tmp2['apellido'] = $valor;
					}else{
						$tmp2[$key] = $valor;
					}
				}else{
					$tmp3[$key] = $valor;
				}
				$i=$i+1;
			}
			$tmp['estudiante'] =$tmp2;
			$tmp['docente'] = $tmp3;
			array_push($General,$tmp);
		}
		echo  json_encode($General);
	}



}
