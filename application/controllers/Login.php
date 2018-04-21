<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

	function __construct(){
		parent::__construct();

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

			$usuario = $this->Modelo->query("SELECT * FROM usuarios WHERE correo = ?", $email);
			if (count($usuario) == 0) {
				$this->Modelo->agregar_reg("usuarios", array(
					"nombre" => $name,
					"correo" => $email,
					"password" => sha1($pass)
				));

				$id_usuario = $this->db->insert_id();
				$this->crear_sesion($id_usuario);
				$resultado["resultado"] = true;
			}
		}

		echo json_encode($resultado);
	}

	public function entrar(){
		$resultado["resultado"] = false;
	  if($this->input->post("email") && $this->input->post("contrasena")){
			$email = $this->input->post("email");
			$pass = sha1($this->input->post("contrasena"));

			$res = $this->Modelo->query("SELECT * FROM usuarios WHERE correo = '$email' AND password = '$pass'");
			if (count($res) > 0) {
				$resultado["resultado"] = true;
				$this->crear_sesion($res[0]->id_usuario);
			}
		}

		echo json_encode($resultado);
	}

	public function crear_sesion($id){
		$userdata = $this->Modelo->query("SELECT * FROM usuarios WHERE id_usuario = ?", $id);

	  $session_data = array(
			// "id" => $userdata[0]->id,
			"nombre" => $userdata[0]->nombre,
			"correo" => $userdata[0]->correo
		);
		$this->session->set_userdata($session_data);

		echo var_dump($this->session->userdata());
	}

	public function salir(){
	  $this->session->set_userdata(array());
	}

	public function getSessionVariable(){
	  return json_encode($this->session->userdata());
	}
}

?>
