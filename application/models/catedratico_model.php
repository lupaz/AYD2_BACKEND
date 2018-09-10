<?php

class catedratico_model extends CI_Model{

    public function getCatedraticos(){
        $query= $this->db->get('Docente');
        return $query->result();
    }

}