<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;

class AuthFilter implements FilterInterface
{
	use ResponseTrait;

	public function before(RequestInterface $request, $arguments = null)
	{	
		//este filtro valida por Bearer Token
		// $key        = Services::getSecretKey();
		// $authHeader = $request->getServer('HTTP_AUTHORIZATION');
		// $arr        = explode(' ', $authHeader);
		// $token      = $arr[1];

		//validación por header
		$key = Services::getSecretKey();
		$token = $request->getServer('HTTP_AUTHORIZATION');

		try
		{
			JWT::decode($token, $key, ['HS256']);
		}
		catch (\Exception $e)
		{
			//  return Services::response()
			//  	->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
			 return Services::response()
			 	->setJSON([
					 		'success' => false,
					 		'msg_error' => 'Error de autenticación',
						  ]);
		}
	}

	//--------------------------------------------------------------------

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Do something here
	}
}