<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$CI = &get_instance();

function generateAuthToken($userId) {
    global $CI;
    $tokenId = base64_encode(uniqid());
    $serverName = $_SERVER['HTTP_HOST'];
    /*
     * Create the token as an array
     */
    $token_data = [
        // Issued at: time when the token was generated
        'jti' => $tokenId, // Json Token Id: an unique identifier for the token
        'iss' => $serverName, // Issuer
        'data' => [                  // Data related to the signer user
            'userId' => $userId // userid from the users table
        ]
    ];
    $jwt_token_secret_key = $CI->config->item('jwt_key');
    $authkey = \Firebase\JWT\JWT::encode(
                    $token_data, //Data to be encoded in the JWT
                    base64_decode($jwt_token_secret_key), // The signing key
                    'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
    );

    return $authkey;
}

function generate_password_hash($password) {
    $options = [
        'cost' => 11,
        'salt' => mcrypt_create_iv(50, MCRYPT_DEV_URANDOM),
    ];
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

function ParseToken($array) {
    $CI = &get_instance();
    $jwt_token_secret_key = $CI->config->item('jwt_key');
    $CI->load->model('api/user_model');
    if (array_key_exists('accesstoken', $array) && strlen($array['accesstoken']) > 0) {
        $request_token = $array['accesstoken'];
        $secretKey = base64_decode($jwt_token_secret_key);
        $token_decoded = Firebase\JWT\JWT::decode($request_token, $secretKey, array('HS512'));
        if (property_exists($token_decoded, 'data')) {
            if (property_exists($token_decoded->data, 'userId')) {
                $token_info = $CI->user_model->getUserData($token_decoded->data->userId);
                if (count($token_info) > 0) {
                    return $token_decoded->data->userId;
                } else {
                    return false;
                }
            }
        }
    } else {
        return false;
    }
    return false;
}

function send_mail($data) {
    global $CI;
    $to = $data['to'];
    $sub = $data['subject'];
    $email_msg = $data['message'];
    $CI->load->library('email');
    $CI->config->load('email', TRUE);
    $CI->email->from('admin@conseel.com');
    $CI->email->to($to);
    $CI->email->subject($sub);
    $CI->email->set_mailtype('html');
    $CI->email->message($email_msg);
    return $CI->email->send();
}

function generate_random_password($length = 6) {
    $alphabets = range('A', 'Z');
    $numbers = range('0', '9');
    $additional_characters = array('_', '.');
    $final_array = array_merge($alphabets, $numbers, $additional_characters);

    $password = '';

    while ($length--) {
        $key = array_rand($final_array);
        $password .= $final_array[$key];
    }

    return $password;
}

function lang_url($uri = '', $protocol = NULL) {
    $CI = &get_instance();
    return base_url((isset($CI->multi_lang) && $CI->multi_lang ? ($CI->default_language . '/') : '') . $uri, $protocol);
}
if (!function_exists('delete')) {

    function delete($tbl = '', $whr = null) {
        $CI = &get_instance();
        return $CI->db->delete($tbl, $whr);
    }

}

if (!function_exists('change_status')) {

    function change_status($tbl = '', $set = null, $whr = null) {
        $CI = &get_instance();
        $CI->db->update($tbl, $set, $whr);
        //echo $CI->db->last_query();
        return 1;
    }
}
function set_flash_msg($msg = '', $type = 'success') {
    $CI = &get_instance();
    $CI->session->set_userdata(array('flsh_msg' => $msg, 'flsh_msg_type' => $type));
}

function unset_flash_msg() {
    $CI = &get_instance();
    $CI->session->unset_userdata(array('flsh_msg', 'flsh_msg_type'));
}
