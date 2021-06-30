<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Firebase\JWT\JWT;

class AUTHORIZATION
{
    public static function validate_token($token)
    {
        $CI =& get_instance();
        JWT::$leeway = 60;
        return JWT::decode($token, $CI->config->item('jwt_secret_key'), array('HS256'));
    }

    public static function generate_token($data)
    {
        $CI =& get_instance();
        return JWT::encode($data, $CI->config->item('jwt_secret_key'));
    }

    public static function get_token()
    {
        $headers = null;
        
        if ( isset($_SERVER['Authorization']) ) 
        {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if ( isset($_SERVER['HTTP_AUTHORIZATION']) ) 
        { 
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } 
        else if ( function_exists('apache_request_headers') ) 
        {
            $request_headers = apache_request_headers();
            $request_headers = array_combine(array_map('ucwords', array_keys($request_headers)), array_values($request_headers));

            if ( isset($request_headers['Authorization']) ) 
            {
                $headers = trim($request_headers['Authorization']);
            }
        }

        $token = null;

        if ( !empty($headers) ) 
        {
            if ( strpos($headers, 'Bearer') !== false )
            {
                if ( preg_match('/Bearer\s(\S+)/', $headers, $matches) ) 
                {
                    $token = $matches[1];
                }
            }
            else
            {
                $token = $headers;
            }
        }

        return $token;
    }

    public static function verify_token()
    {
        $token = self::get_token();

        $status = 401;
        $result = array(
                        'status'    => false,
                        'message'   => 'Unauthorized access!'
                        );

        try 
        {
            if ( !empty($token) )
            {
                // validate the token
                // successfull validation will return the decoded user data else will returns false
                $data = self::validate_token($token);

                if ( $data === false ) 
                {
                    $status = 401;
                    $result = array(
                                    'status'    => false,
                                    'message'   => 'Unauthorized access!'
                                    );
                }
                else 
                {
                    $status = 200;
                    $result = array(
                                    'status'    => true,
                                    'message'   => 'Token match!',
                                    'data'      => $data
                                    );
                }
            }
            else
            {
                $status = 400;
                $result = array(
                                'status'    => false,
                                'message'   => 'Invalid token!'
                                );
            }
        } 
        catch (Exception $e) 
        {
            if ( $e->getMessage() == 'Expired token' ) 
            {
                list($header, $payload, $signature) = explode(".", $token);
                $data = json_decode(base64_decode($payload));
                $refresh_token = $data->refresh_token;

                $status = 408;
                $result = array(
                                'status'        => false,
                                'message'       => 'Token expired!',
                                'refresh_token' => $refresh_token,
                                );
            } 
            else 
            {
                $status = 401;
                $result = array(
                                'status'    => false,
                                'message'   => 'Unauthorized access!'
                                );
            }
        }

        return array('result' => $result, 'status' => $status);
    }

}