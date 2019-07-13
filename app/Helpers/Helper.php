<?php 
namespace App\Helpers;

use Exception;
use Throwable;
use Storage;


/**
 *  Custom Helper 
 */
class Helper
{
	
	  /**
     * 
     * Sends success reponse
     * 
     * @param type $data
     * @return type \Illuminate\Http\JsonResponse
     */
    public static function send_success_response($data) {
        $response_array = [
            "program" => config('app.name'),
            "version" => config('api.version'),
            "release" => config('api.release'),
            "datetime" => date('Y-m-d h:i:s A'),
            "timestamp" => time(),
            "status" => "success",
            "code" => "200",
            "message" => "OK",
            "data" => $data
        ];

        return response()->json($response_array, 200);
    }
     /**
     * Sends failure response
     * 
     * @param type $data
     * @param type $message
     * @param type $status
     * @param type $status_code
     * @return type \Illuminate\Http\JsonResponse
     */
    public static function send_fail_response($data, $message, $status = 'fail', $status_code = 500) {
        $response_array = [
            "program" => config('app.name'),
            "version" => config('api.version'),
            "release" => config('api.release'),
            "datetime" => date('Y-m-d h:i:s A'),
            "timestamp" => time(),
            "status" => $status,
            "code" => "$status_code",
            "message" => $message,
            "data" => $data
        ];

        return response()->json($response_array, $status_code);
    }
      /**
     * Sends  input error response
     * 
     * @param type $validation_error_message
     * @return type \Illuminate\Http\JsonResponse
     */
    public static function send_input_error_response($validation_error_message) {
        $status = 'fail';
        $message = 'Bad Request';
        $data = ['error' =>
            [
                'user_message' => $validation_error_message,
                'internal_message' => 'Required inputs need to be filled and it must be valid.',
                'code' => '1002'
            ]
        ];

        return self::send_fail_response($data, $message, $status, 400);
    }
}