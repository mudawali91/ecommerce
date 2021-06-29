<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

use Firebase\JWT\JWT;

class Auth_Controller extends RestController 
{
	function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('User_Model');
        $this->load->model('AccessLogs_Model');
    }

	public function login_post()
    {
        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));
        $type = array(1,2,3); // access to specific user

        $validation_error = array();

        if ( empty($username) )
        {
            $validation_error['username'] = 'Username is empty';
        }

        if ( empty($password) )
        {
            $validation_error['password'] = 'Password is empty';
        }

        if ( count($validation_error) == 0 )
        {
            $rst_login = 0;

            $data_user = $this->User_Model->read_login($username, $password, $type);
            
            if ( !empty($data_user) )
            {
                $rst_login = $data_user->id;
            }
            else
            {
                $rst_login = 0;
            }

            // check user login success before generate access token 
            if ( $rst_login > 0 ) 
            {
                $access_token = $this->generate_token($data_user);

                if ( !empty($access_token) )
                {
                    $data = array(
                                'user'          => $data_user,
                                'access token'  => $access_token
                                );

                    $status = 200;
                    $result = array(
                                    'status'    => true,
                                    'message'   => 'User logged in successfully',
                                    'data'      => $data
                                    );
                }
                else
                {
                    $status = 401;
                    $result = array(
                                    'status'    => false,
                                    'message'   => 'Invalid token generated',
                                    'access token' => $access_token
                                    );
                }
            }
            else
            {
                $status = 401;
                $result = array(
                                'status'    => false,
                                'message'   => 'Invalid Username or Password'
                                );
            }
        }
        else
        {
            $status = 400;
            $result = array(
                            'status'    => false,
                            'message'   => (object)$validation_error
                            );
        }

        return $this->response($result, $status);
    }

    private function generate_token($data)
    {
        $access_token = null;

        if ( !empty($data) )
        {
            $id = $data->id;
            $type = $data->type;
            $email = $data->email;

            $data_user = array(
                                'id'        => $id,
                                'type'      => $type,
                                'email'     => $email
                                );

            $curr_datetime = new DateTimeImmutable();
            $access_token_start = $curr_datetime;
            $access_token_start_int = $access_token_start->getTimestamp();
            $access_token_expired = $curr_datetime->add( new DateInterval('PT60M') ); // access token expired within 5 minutes
            $access_token_expired_int = $access_token_expired->getTimestamp();

            $refresh_token = encryptor('encrypt', $id . ';' . $access_token_start_int . ';' . $access_token_expired_int );
            $refresh_token_start = $curr_datetime;
            $refresh_token_expired = $curr_datetime->add( new DateInterval('P3M') ); // refresh token expired 3 months

            $payload = array(
                            'user'          => $data_user, 
                            'refresh_token' => $refresh_token, 
                            'iss'           => site_url(),
                            'aud'           => site_url(),
                            'iat'           => $access_token_start_int,
                            'exp'           => $access_token_expired_int,
                            );

            // create a access token from the user data and send it as response
            $access_token = AUTHORIZATION::generate_token($payload);

            // create logs to save access token and its expiry time
            if ( !empty($access_token) )
            {
                $data_create_log = array(
                                            'user_id'               => $id,
                                            'access_token'          => $access_token,
                                            'access_token_start'    => $access_token_start->format('Y-m-d H:i:s'),
                                            'access_token_expired'  => $access_token_expired->format('Y-m-d H:i:s'),
                                            'refresh_token'         => $refresh_token,
                                            'refresh_token_start'   => $refresh_token_start->format('Y-m-d H:i:s'),
                                            'refresh_token_expired' => $refresh_token_expired->format('Y-m-d H:i:s'),
                                            'created_at'            => getDateTime(),
                                            'created_by'            => $id,
                                            'updated_at'            => getDateTime(),
                                            'updated_by'            => $id
                                            );

                $rst_create_log = $this->AccessLogs_Model->create_data($data_create_log);
            }
            else
            {
                $access_token = null;
            }
        }
        else
        {
            $access_token = null;
        }

        return $access_token;
    }
}