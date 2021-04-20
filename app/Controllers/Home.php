<?php

namespace App\Controllers;
use App\Models\DetenidoModel;

class Home extends Auth
{	
	protected $Detenido;
	public function __construct()
	{
		$this->Detenido = new DetenidoModel();
	}
	public function index()
	{
		return view('welcome_message');
	}

	public function hello(){
		$data = [
			'titulo' => 'juan daniel garcia lopez'
		];
		$request = \Config\Services::request();
		$saludo = $request->getPost('saludo');
		echo $saludo;
		return view('home/hello',$data);
	}

	public function sumar(){
		$request = \Config\Services::request();
		$n1 = $request->getGet('n1');
		$n2 = $request->getGet('n2');
		$response = ['success' => false];

		if(is_numeric($n1) && is_numeric($n2)){
			$suma = intval($n1) + intval($n2);
			$response['result'] = $suma;
			$response['success'] = true;
		}
		else{
			$response['error_message'] = "Los valores no son números reales";
		}

		echo json_encode($response,JSON_UNESCAPED_UNICODE );
	}

	public function getDetenido(){
		$response['success'] = false;

		$no_remision = $this->request->getPost('no_remision');
		$data = $this->Detenido->getRemision($no_remision);
		if(!$data){ //no hay resultados
			$response['msg_error'] = "no existen resultados con los parámetros incluídos";
		}
		else{ //todo sale bien
			$response['success'] = true;
			$response['data'] = $data;
		}

		return $this->respond($response);
	}

	// public function getDetenido(){
	// 	$token = $this->request->getHeader('Authorization')->getValue(); // se lee el token de la cabecera
	// 	$response = ['success' => false];	//inicializamos el response general
	// 	$ServerStatus = 401;	//se inicializa el status del servidor

	// 	if($this->validateToken($token)){
	// 		$no_remision = $this->request->getPost('no_remision');
	// 		$data = $this->Detenido->getRemision($no_remision);
	// 		if(!$data){ //no hay resultados
	// 			$response['msg_error'] = "no existen resultados con los parámetros incluídos";
	// 		}
	// 		else{ //todo sale bien
	// 			$response['success'] = true;
	// 			$response['data'] = $data;
	// 			$ServerStatus = 200;
	// 		}
	// 	}
	// 	else{ //el token es inválido
	// 		$response['msg_error'] = 'Token inválido mi chavo';
	// 	}

	// 	return $this->respond($response,$ServerStatus);
	// }
}
