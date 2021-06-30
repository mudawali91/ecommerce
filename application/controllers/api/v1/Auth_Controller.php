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
                $is_already_logged_in = $this->is_already_logged_in($rst_login);

                if ( $is_already_logged_in === true )
                {   
                    $status = 409;
                    $result = array(
                                    'status'    => false,
                                    'message'   => 'User already logged in or access token has been refreshed'
                                    );
                }
                else
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
                                        'message'   => 'Invalid token generated'
                                        );
                    }
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

    public function refresh_token_get()
    {
        $refresh_token = $this->input->get('refresh_token');

        $validation_error = array();

        if ( empty($refresh_token) )
        {
            $validation_error['refresh_token'] = 'Refresh token is empty';
        }

        if ( count($validation_error) == 0 )
        {
            $refresh_token_decrypt = encryptor('decrypt', $refresh_token);
            
            $refresh_token_arr = array();

            if ( !empty($refresh_token_decrypt) )
            {
                $refresh_token_arr = explode('%+-*/', $refresh_token_decrypt);
            }
            
            if ( is_array($refresh_token_arr) && count($refresh_token_arr) > 0 )    
            {
                $user_id = ( isset($refresh_token_arr[0]) && !empty($refresh_token_arr[0]) ) ? $refresh_token_arr[0] : null;
                
                $data_user = $this->User_Model->read_first($user_id);

                $refresh_token_start_int = ( isset($refresh_token_arr[1]) && !empty($refresh_token_arr[1]) ) ? $refresh_token_arr[1] : null;
                $refresh_token_expired_int = ( isset($refresh_token_arr[2]) && !empty($refresh_token_arr[2]) ) ? $refresh_token_arr[2] : null;

                $curr_datetime = new DateTimeImmutable();
                $curr_datetime_int = $curr_datetime->getTimestamp();

                // to check if the refresh token 
                if ( !empty($data_user) && $curr_datetime_int > $refresh_token_start_int && $curr_datetime_int < $refresh_token_expired_int )
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
                                        'message'   => 'New token generated successfully',
                                        'data'      => $data
                                        );
                    }
                    else
                    {
                        $status = 401;
                        $result = array(
                                        'status'    => false,
                                        'message'   => 'Invalid token generated'
                                        );
                    }
                }
                else
                {
                    $status = 401;
                    $result = array(
                                    'status'    => false,
                                    'message'   => 'Refresh token already expired, please login to continue.'
                                    );
                }
            }
            else
            {
                $status = 401;
                $result = array(
                                'status'    => false,
                                'message'   => 'Invalid refresh token'
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

    private function is_already_logged_in($id)
    {
        $access_log = $this->AccessLogs_Model->read_current_log($id);

        if ( is_object($access_log) && !empty($access_log) )
        {
            return true;
        }
        else
        {
            return false;
        }
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
            $access_token_expired = $curr_datetime->add( new DateInterval('PT5M') ); // access token expired within 5 minutes
            $access_token_expired_int = $access_token_expired->getTimestamp();

            $refresh_token_start = $curr_datetime;
            $refresh_token_start_int = $refresh_token_start->getTimestamp();
            $refresh_token_expired = $curr_datetime->add( new DateInterval('P3M') ); // refresh token expired within 3 months
            $refresh_token_expired_int = $refresh_token_expired->getTimestamp();

            $refresh_token = encryptor('encrypt', $id . '%+-*/' . $refresh_token_start_int . '%+-*/' . $refresh_token_expired_int );

            $payload = array(
                            'user'          => $data_user, 
                            'refresh_token' => $refresh_token, 
                            'iss'           => site_url(),
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
