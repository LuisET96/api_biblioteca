<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	parent::__construct();

	function __construct(argument){
		$this->load->database();
		$this->load->model("Modelo");

		$this->load->library("session");

		$this->load->helper('url');
	}

	public function registro(){
		$resultado["resultado"] = false;
		if($this->input->post("nombre") && $this->input->post("email") && $this->input->post("contrasena")){
		  $name = $this->input->post("nombre");
			$email = $this->input->post("email");
			$pass = $this->input->post("contrasena");

			$this->Modelo->agregar_reg("usuarios", array(
				"nombre" => $name,
				"correo" => $email,
				"password" => sha1($pass)
			));

			$id_usuario = $this->db->insert_id();
			$this->crear_sesion($id_usuario);
			$resultado["resultado"] = true;
		}

		echo json_encode($resultado);
	}

	public function entrar(){
	  if($this->input->post("email") && $this->input->post("contrasena")){
			$email = $this->input->post("email");
			$pass = $this->input->post("contrasena");

			$res = $this->Modelo->query("SELECT * FROM usuarios WHERE correo = ? AND password = ?", $email, $password);
			if (count($res) > 0) {
				$this->crear_sesion($res[0]->id_usuario);
			}
		}
	}

	public function crear_sesion($id){
		$userdata = $this->Modelo->query("SELECT * FROM usuarios WHERE id_usuario = ?", $id);

	  $session_data = array(
			"nombre" => $userdata[0]->nombre,
			"correo" => $userdata[0]->correo
		);
		$this->session->set_userdata($session_data);
	}
}

?>
