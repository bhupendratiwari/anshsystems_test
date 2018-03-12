<?php

defined('BASEPATH') OR exit('No direct script access allowed');


// src: application/middlewares/AuthMiddleware.php
// Extends nothing, it's upto you what you want to extend. Completely generic.
class AuthMiddleware {

    // Get injected controller and ci references
    protected $controller;
    protected $ci;

    // All middlewares will pass controller and ci class objects as references to constructor
    // It's upto you, that what you do with them
    // Obviously it's not required :)

    public function __construct($controller, $ci) {
        $this->controller = $controller;
        $this->ci = $ci;
    }

    // This function is required, and is entry point to this class
    public function run() {
        try {
            $headers = apache_request_headers();
            $token_userId = ParseToken($headers);
            if ($token_userId > 0) {
                $this->controller->token_user_id = $token_userId;
            } else {
                throw new Exception('Unauthorized access');
            }
        } catch (Exception $e) {

            $response['data'] = array();
            $response['code'] = 401;
            $response['message'] = $e->getMessage();
            $response['status'] = false;
            $this->controller->response($response, $response['code']);
        }
    }

}
