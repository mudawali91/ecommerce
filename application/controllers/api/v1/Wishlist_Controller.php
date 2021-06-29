<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Wishlist_Controller extends RestController 
{
	function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Wishlist_Model');
        $this->load->model('WishlistItem_Model');
    }

	public function index()
	{
	}

    public function wishlist_post()
    {
        $data_token = AUTHORIZATION::verify_token();

        if ( isset($data_token['status']) && $data_token['status'] == 200 )
        {
            $user_id = 0;

            if ( array_key_exists('data', $data_token['result']) )
            {
                $data_user = $data_token['result']['data']->user;
                $user_id = $data_user->id;
            }

            if ( $user_id > 0 )
            {
                $request_json = $this->input->raw_input_stream; // file_get_contents('php://input');
                
                if ( !empty($request_json) )
                {
                    $request_arr = json_decode($request_json, true);

                    if ( is_array($request_arr) )
                    {
                        // single wishlist per request
                        $request_arr_temp = array();

                        if ( array_key_exists('title', $request_arr) && array_key_exists('items', $request_arr) )
                        {
                            // push to array to run with multiple wishlist per request
                            $request_arr_temp[] = $request_arr; 
                            $request_arr = ( count($request_arr_temp) > 0 ? $request_arr_temp : $request_arr );
                        }

                        $wishlist_max = 10;
                        $wishlist_total = count($request_arr);

                        // multiple wishlist per request
                        if ( $wishlist_total <= $wishlist_max )
                        {
                            $validation_error = array();

                            for ( $v = 0; $v < $wishlist_total; $v++ )
                            {
                                if ( !isset($request_arr[$v]['title']) || empty($request_arr[$v]['title']) )
                                {
                                    $validation_error[$v]['title'] = 'Title is empty';
                                }

                                $product_arr = isset($request_arr[$v]['items']) ? $request_arr[$v]['items'] : array();

                                if ( count($product_arr) == 0 )
                                {
                                    $validation_error[$v]['items'] = 'Item is empty. Select at least one item';
                                }
                                else
                                {
                                    foreach ( $product_arr as $key_p => $val_p )
                                    {
                                        if ( !isset($val_p['product_id']) || empty($val_p['product_id']) )
                                        {
                                            $validation_error[$v]['items'][$key_p] = 'Selected item not found';
                                        }
                                    } 
                                }
                            }

                            if ( count($validation_error) > 0 )
                            {
                                $status = 400;
                                $result = array(
                                                'status'    => false,
                                                'message'   => (object)$validation_error
                                                );
                            }
                            else
                            {
                                $data_wishlist = array();

                                foreach ( $request_arr as $key_r => $val_r )
                                {
                                    $data_create = array(
                                                        'user_id'       => $user_id,
                                                        'title'         => $val_r['title'],
                                                        'created_at'    => getDateTime(),
                                                        'created_by'    => $user_id,
                                                        'updated_at'    => getDateTime(),
                                                        'updated_by'    => $user_id
                                                        );

                                    $wishlist_id = $this->Wishlist_Model->create_data($data_create);

                                    if ( $wishlist_id > 0 )
                                    {
                                        // insert wishlist item

                                        $data_create_item = array();

                                        foreach ( $val_r['items'] as $key_p => $val_p )
                                        {
                                            $product_id = $val_p['product_id'];
                                            $color = ( isset($val_p['color']) ? $val_p['color'] : null);
                                            $size = ( isset($val_p['size']) ? $val_p['size'] : null);
                                            $remark = ( isset($val_p['remark']) ? $val_p['remark'] : null);

                                            $data_create_item[] = array(
                                                                        'wishlist_id'       => $wishlist_id,
                                                                        'product_id'        => $product_id,
                                                                        'color'             => $color,
                                                                        'size'              => $size,
                                                                        'remark'            => $remark,
                                                                        'created_at'        => getDateTime(),
                                                                        'created_by'        => $user_id,
                                                                        'updated_at'        => getDateTime(),
                                                                        'updated_by'        => $user_id
                                                                        );
                                        }

                                        $total_create_item = 0;

                                        if ( count($data_create_item) > 0 )
                                        {
                                            $total_create_item = $this->WishlistItem_Model->create_data_multiple($data_create_item);
                                        }

                                        // to set id as 1st element
                                        $data_wishlist['success'][$key_r][] = array_merge( 
                                                                                            array('id' => $wishlist_id), 
                                                                                            $data_create, 
                                                                                            array('total_item' => $total_create_item) 
                                                                                        );
                                    }
                                    else
                                    {
                                        $data_wishlist['fail'][$key_r][] = $data_create;
                                    }
                                }

                                if ( isset($data_wishlist['success']) && count($data_wishlist['success']) > 0 )
                                {
                                    $status = 200;
                                    $result = array(
                                                    'status'    => true,
                                                    'message'   => 'Wishlist saved successfully',
                                                    'data'      => $data_wishlist
                                                    );
                                }
                                else
                                {
                                    $status = 502;
                                    $result = array(
                                                    'status'    => false,
                                                    'message'   => 'Wishlist save failed',
                                                    'data'      => $data_wishlist
                                                    );
                                }


                            }
                        }
                        else
                        {
                            $status = 400;
                            $result = array(
                                            'status'    => false,
                                            'message'   => 'Limit to '.$wishlist_max.' wishlists per request'
                                            );
                        }
                    }
                    else
                    {
                        $status = 400;
                        $result = array(
                                        'status'    => false,
                                        'message'   => 'Invalid request'
                                        );
                    }
                }
                else
                {
                    $status = 400;
                    $result = array(
                                    'status'    => false,
                                    'message'   => 'Invalid request'
                                    );
                }
            }
            else
            {
                $status = 403;
                $result = array(
                                'status'    => false,
                                'message'   => 'Unauthorized access!'
                                );
            }

            return $this->response($result, $status);
        }
        else
        {
            return $this->response($data_token['result'], $data_token['status']);   
        }
    }

	public function wishlist_get()
    {
        // Users from a data store e.g. database

        $data_token = AUTHORIZATION::verify_token();

        if ( isset($data_token['status']) && $data_token['status'] == 200 )
        {
            $data_user = null;

            if ( array_key_exists('data', $data_token['result']) )
            {
                $data_user = $data_token['result']['data']->user;
            }

            if ( !empty($data_user) )
            {
                $user_id = $data_user->id;
                $user_type = $data_user->type;

                $id = $this->uri->segment(4);
                $page = $this->input->get('page');
                $limit = $this->input->get('limit');
                $offset = ((int)$page * (int)$limit) - (int)$limit;

                $validation_error = array();

                if ( isset($page) )
                {
                    // if page used, its value must integer and greater than zero
                    if ( is_numeric($page) == false || (int)$page <= 0 )
                    {
                        $validation_error['page'] = 'Page value must be an integer and minimum is 1';
                    }
                }

                if ( isset($limit) )
                {
                    // if limit used, its value must integer and greater than zero
                    if ( is_numeric($limit) == false || (int)$limit <= 0 )
                    {
                        $validation_error['limit'] = 'Limit value must be an integer and minimum is 1';
                    }
                }

                if ( isset($limit) || isset($page) )
                {
                     // if page used, limit should be used also
                    if ( (int)$page > 0 && (int)$limit <= 0 )
                    {
                        $validation_error['limit'] = 'Limit is required, value must be an integer and minimum is 1';   
                    }
                }

                if ( count($validation_error) > 0 )
                {
                    $status = 400;
                    $result = array(
                                    'status'    => false,
                                    'message'   => (object)$validation_error
                                    );
                }
                else
                {
                    $filter_wishlist = array();

                    if ( !in_array( $user_type, array(1,2) ) )
                    {
                        // not superadmin & admin user
                        $filter_wishlist['user_id'] = $user_id;
                    }

                    if ( !empty($id) )
                    {
                        $filter_wishlist['id'] = $id;
                    }
                        
                    $wishlist = $this->Wishlist_Model->read_all($filter_wishlist, $limit, $offset);

                    if ( !empty($wishlist) )
                    {
                        if ( is_array($wishlist) )
                        {
                            foreach ( $wishlist as $key => $val )
                            {
                                $filter_wishlist_item = array('a.wishlist_id' => $val->id);
                                $wishlist_item = $this->WishlistItem_Model->read_all($filter_wishlist_item); 
                                $wishlist[$key]->items = $wishlist_item;
                            }
                        }
                        else if ( is_object($wishlist) )
                        {
                            $filter_wishlist_item = array('a.wishlist_id' => $wishlist->id);
                            $wishlist_item = $this->WishlistItem_Model->read_all($filter_wishlist_item);
                            $wishlist->items = $wishlist_item;
                        }

                        $data_wishlist = $wishlist;

                        $status = 200;
                        $result = array(
                                        'status'    => true,
                                        'message'   => 'Success',
                                        'data'      => $data_wishlist
                                        );
                    }
                    else
                    {
                        $status = 404;
                        $result = array(
                                        'status'    => false,
                                        'message'   => 'Data not found!'
                                        );
                    }
                }

            }
            else
            {
                $status = 403;
                $result = array(
                                'status'    => false,
                                'message'   => 'Unauthorized access!'
                                );
            }

            return $this->response($result, $status);
        }
        else
        {
            $this->response($data_token['result'], $data_token['status']);   
        }
    }

    public function wishlist_delete()
    {
        // Users from a data store e.g. database

        $data_token = AUTHORIZATION::verify_token();

        if ( isset($data_token['status']) && $data_token['status'] == 200 )
        {
            $data_user = null;

            if ( array_key_exists('data', $data_token['result']) )
            {
                $data_user = $data_token['result']['data']->user;
            }

            if ( !empty($data_user) )
            {
                $user_id = $data_user->id;
                $user_type = $data_user->type;

                $id = $this->uri->segment(4);

                $wishlist = $this->Wishlist_Model->read_first($id);

                if ( is_object($wishlist) && !empty($wishlist) )
                {
                    // verify data is belong to the current login user 
                    if ( $user_id == $wishlist->user_id )
                    {
                        if ( empty($wishlist->deleted_at) )
                        {
                            $total_delete = $this->Wishlist_Model->delete_data($id, $user_id);

                            if ( $total_delete > 0 )
                            {
                                $filter_wishlist_item = array('wishlist_id' => $id);
                                $total_delete_item = $this->WishlistItem_Model->delete_data_multiple($filter_wishlist_item, $user_id);

                                $status = 200;
                                $result = array(
                                                'status'    => true,
                                                'message'   => 'Wishlist deleted successfully',
                                                'data'      => array(
                                                                    'total_delete'      => $total_delete,
                                                                    'total_delete_item' => $total_delete_item
                                                                    )
                                                );
                            }
                            else
                            {
                                $status = 502;
                                $result = array(
                                                'status'    => false,
                                                'message'   => 'Wishlist delete failed'
                                                );
                            }
                        }
                        else
                        {
                            $status = 200;
                            $result = array(
                                            'status'    => true,
                                            'message'   => 'Data has been deleted'
                                            );
                        }
                    }
                    else
                    {
                        $status = 403;
                        $result = array(
                                        'status'    => false,
                                        'message'   => 'Unauthorized access!'
                                        );
                    }
                }
                else
                {
                    $status = 404;
                    $result = array(
                                    'status'    => false,
                                    'message'   => 'Data not found!'
                                    );
                }

                $filter_wishlist = array();

                if ( !in_array( $user_type, array(1,2) ) )
                {
                    // not superadmin & admin user
                    $filter_wishlist['user_id'] = $user_id;
                }

                if ( !empty($id) )
                {
                    $filter_wishlist['id'] = $id;
                }
            }
            else
            {
                $status = 403;
                $result = array(
                                'status'    => false,
                                'message'   => 'Unauthorized access!'
                                );
            }

            return $this->response($result, $status);
        }
        else
        {
            $this->response($data_token['result'], $data_token['status']);   
        }
    }
}
