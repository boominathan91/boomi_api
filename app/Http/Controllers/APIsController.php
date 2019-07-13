<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Helper;

class APIsController extends Controller
{
      /**
     * List of available APIs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
      public function index(Request $request) {
      	$routes = [
      		[
      			'path' => '/',
      			'method' => 'GET',
      			'description' => 'List of available APIs'
      		],
      		[
      			'path' => '/register',
      			'method' => 'POST',
      			'description' => 'Registration API'
      		],
      		[
      			'path' => '/logout',
      			'method' => 'POST',
      			'description' => 'Logout API'
      		],
      	];

      	$data = ['routes' => $routes];

      	return Helper::send_success_response($data);
      }

     /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
     public function login(Request $request) {
     	try {

     		$validator = Validator::make($request->all(),
     			[
     				'email' => 'required|email',
     				'password' => 'required|min:6|max:16',                                
     			]
     		);

     		if (!$validator->fails()) {
     			$credentials = [
     				'email' => $request->email,
     				'password' => $request->password
     			];

     			if (auth()->attempt($credentials)) {
     				$user = auth()->user();     				

     				if ($user) {

                            //clear all previous tokens
     					$tokens = $user->tokens()->delete();

                            //create new one
     					$token = $user->createToken('UserToken')->accessToken;

     					$data = [
     						'message' => 'Logged in successfully.',
     						'access_token' => $token,
     					];

     					return Helper::send_success_response($data);

     				} else {
     					$status = 'fail';
     					$message = 'Unauthorized';
     					$data = ['error' => [
     						'user_message' => 'Your account is yet be activated or may be blocked. Please contact admin for support.',
     						'internal_message' => 'Account is yet be activated or may be blocked.',
     						'code' => '1005'
     					]
     				];

     				return Helper::send_fail_response($data, $message, $status, 401);
     			}
     		} else {

     			$status = 'fail';
     			$message = 'Unauthorized';
     			$data = ['error' => [
     				'user_message' => 'These credentials do not match our records.',
     				'internal_message' => 'Email or Password is wrong.',
     				'code' => '1003'
     			]
     		];

     		return Helper::send_fail_response($data, $message, $status, 401);
     	}
     } else {
     	return Helper::send_input_error_response($validator->messages()->first());
     }
 } catch (Exception | Throwable $ex) {
 	return Helper::send_exception_response('Error: ' . $ex->getMessage() . ' Line Number: ' . $ex->getLine());
 }
}


}
