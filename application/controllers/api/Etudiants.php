<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Etudiants extends REST_Controller {
/**
    * Get All Data from this method.
    *
    * @return Response
    */
    public function __construct() {
        parent::__construct();
            $this->load->database();
            $this->load->model('EtudiantModel');
            $this->load->model('Token');
    }
    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
        /**
        * Get All Data from this method.
        *
        * @return Response
        */
        public function login_post(){
            $input=$this->post();
            $login=$input['login'];
            $pwd=$input['pwd'];
            if(!empty($login) && !empty($pwd)){
                try{
                    $idetu= $this->EtudiantModel->LoginEtu($login,$pwd);
                    $data=$this->Token->CreateVerifyToken($idetu);
                    $this->response([
                        'status' => 200,
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                }catch(Exception $e){
                    $this->response([
                        'status' => 500,
                        'data' => 'erreur Connexion'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                
            }else{
                $this->response([
                    "status" =>400,
                    "message"=>"Provide login and password."
                    ],REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        /**
        * Get All Data from this method.
        *
        * @return Response
        */
        public function register_post()
        {
            $data = $this->post();
            try{
                $this->EtudiantModel->InsertEtudiant($data);
                
                $this->response([
                    'status' => 200,
                    'message' => 'Etudiants cree'
                ], REST_Controller::HTTP_OK);
            }catch(Exception $e){
                $this->response([
                    'Verifier votre '.$e->getMessage()
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
        }
       /**
    * Get All Data from this method.
    *
    * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        var_dump($input);
        $token=$this->getBearerToken();
        if(empty($token)){
            $this->response([
                "status" =>FALSE,
                "message"=>"Veilliez vous connectez."
                ],REST_Controller::HTTP_BAD_REQUEST);
        }
        $idetu=$this->Token->getIdEtu($token);
        $result=$this->db->update('Etudiants', $input, array('idetu'=>$idetu));
        if($result){
            $this->response([
                'status'=>true,
                'message'=>'Updated successfully.'
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status'=>false,
                'message'=>'Erreur d\'insertion.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }

}
?>