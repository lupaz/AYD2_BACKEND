<?php

class Catedratico_model extends CI_Model{

    public function getCatedraticos(){
        $query= $this->db->get('catedratico');
        return $query->result();
    }

    public function addUsuario($nombre,$apellido,$carnet, $cui, $contrasena,$carrera){
        $insert_user_stored_proc = "CALL insertar_estudiante(?, ?, ?, ?, ?, ?, ?, ?)";
        $data = array('carnet' => $carnet, 'cui' => $cui, 'nombre' => $nombre, 'apellido' => $apellido,'foto'=> '/una/ruta','fecha_nac'=>'1995-12-02','carrera'=>$carrera,
                    'contrasena'=>$contrasena);

        try {
            $this->db->trans_start(FALSE);
            $query = $this->db->query($insert_user_stored_proc, $data);
            $this->db->trans_complete();            
            $db_error = $this->db->error();
            return TRUE;
        }catch (Exception $e){
            return FALSE;
        }            
    }

    public function login($carnet , $contrasena){
        $login_user_proc = "CALL login_user(?,?)";
        $data = array('carnet'=> $carnet , 'pass' => $contrasena);
        $query = $this->db->query($login_user_proc,$data);
        return $query->result();
    }

    public function getCursos($id_personal){
        $login_user_proc = "CALL get_cursos(?)";
        $data = array('id_personal'=> $id_personal);
        $query = $this->db->query($login_user_proc,$data);
        return $query->result();
    }

    public function getCalificacion($id_personal){
        $login_user_proc = "CALL calificacion_total(?)";
        $data = array('id_personal'=> $id_personal);
        $query = $this->db->query($login_user_proc,$data);
        return $query->result();
    }

    public function calificacion($carnet,$id_personal){
        $login_user_proc = "CALL calificacion(?,?)";
        $data = array('carnet'=>$carnet,'id_personal'=> $id_personal);
        $query = $this->db->query($login_user_proc,$data);
        return $query->result();
    }

    public function updateCalificacion($carnet, $id_personal, $dominio,$puntualidad,$responsabilidad,$respesto,$didactica,$comentario){
        $update_cal_proc = "CALL update_calificacion(?, ?, ?, ?, ?, ?, ?, ?)";
        $data = array('carnet' => $carnet, 'id_personal' => $id_personal, 'dominio' => $dominio, 'puntualidad' => $puntualidad,'responsabilidad'=> $responsabilidad,
                        'respeto'=>$respesto, 'didactica'=>$didactica, 'comentario'=>$comentario);
        $query = $this->db->query($update_cal_proc, $data);
        return TRUE; 
    }

    public function setCalificacion($carnet, $id_personal, $dominio,$puntualidad,$responsabilidad,$respesto,$didactica,$comentario){
        $update_cal_proc = "CALL set_calificacion(?, ?, ?, ?, ?, ?, ?, ?)";
        $data = array('carnet' => $carnet, 'id_personal' => $id_personal, 'dominio' => $dominio, 'puntualidad' => $puntualidad,'responsabilidad'=> $responsabilidad,
                        'respeto'=>$respesto, 'didactica'=>$didactica, 'comentario'=>$comentario);
        $query = $this->db->query($update_cal_proc, $data);
        return TRUE; 
    }

    public function getComentarios($id_personal){
        $comentarios_proc = "CALL get_comentarios(?)";
        $data = array('id_personal'=> $id_personal);
        $query = $this->db->query($comentarios_proc,$data);
        return $query->result();
    }

}