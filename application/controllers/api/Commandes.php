<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Commandes extends REST_Controller {
    /**
    * Get All Data from this method.
    *
    * @return Response
    */
    public function __construct() {
        parent::__construct();
            $this->load->database();
        }
        /**
        * Get All Data from this method.
        *
        * @return Response
        */
        public function index_get($idetu = 0)
        {
            if(!empty($idetu)){
                $data = $this->db->get_where("TotalPlatEtu", ['idetudiant' => $idetu])->result();
                $this->response($data, REST_Controller::HTTP_OK);
            }
        }
        
        /**
        * Get All Data from this method.
        *
        * @return Response
        */
        public function index_post()
        {
            $input = $this->input->post();
            $this->db->insert('commande',$input);
            $this->response(['Created successfully.'], REST_Controller::HTTP_OK);   
        }
        /**
        * Get All Data from this method.
        *
        * @return Response
        */
        public function index_put($id)
        {
            $input = $this->put();
            //var_dump($input);
            $this->db->update('commande', $input, array('idcommande'=>$id));
            $this->response(['Updated successfully.'], REST_Controller::HTTP_OK);
        }
}