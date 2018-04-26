<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Libros extends REST_Controller {
    public function __construct($config = 'rest') {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      $method = $_SERVER['REQUEST_METHOD'];
      if($method == "OPTIONS") {
        die();
      }
      parent::__construct();

      $this->load->database();
      $this->load->helper('url');
	    $this->load->model("Modelo");
    }

		public function libros_get(){
		  $arr = $this->Modelo->query("SELECT * FROM libros");
			$this->response($arr);
		}

		public function libro_categoria($categoria){
			// $categorias = $this->input->get("materia");

			$arr = $this->Modelo->query("SELECT libros.* FROM categorias JOIN libros_has_categorias ON (libros_has_categorias.categoria_id = categorias.id_categoria) JOIN libros ON (libros_has_categorias.libro_id = libros.id_libro) WHERE categorias.nombre = ?", $categoria);
			return $arr;
		}

		public function libro_get(){
		  $id_libro = $this->input->get("id_libro");

			$res = $this->Modelo->query("SELECT * FROM libros WHERE id_libro = ?", $id_libro);
			if (count($res) > 0) {
				$this->response($res[0]);
			} else {
				$this->response("No se ha encontrado libro.");
			}
		}

		public function categorias_get(){
			$arr_categorias = [];
			$categorias = $this->Modelo->query("SELECT * FROM categorias");

			if (count($categorias) > 0) {
			  foreach ($categorias as $categoria) {
					$arr_categorias[$categoria->nombre] = $this->libro_categoria($categoria->nombre);
			  }
			}

			$this->response($arr_categorias);
		}
}
