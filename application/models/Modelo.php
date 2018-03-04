<?php
  class Modelo extends CI_Model{
    public function __construct(){

      $this->load->database();
    }

    public function query($cadena, $parametros = []){
      $query = $this->db->query($cadena, $parametros);
      return $query->result();
    }

    public function query_no_result($cadena){
      $query = $this->db->query($cadena);
    }

    public function agregar_reg($tabla, $datos){
      $this->db->insert($tabla,$datos);
    }

    public function editar_reg($tabla, $datos, $campo, $valor_campo){
      $this->db->where($campo,$valor_campo);
      $this->db->update($tabla,$datos);
    }
  }
?>
