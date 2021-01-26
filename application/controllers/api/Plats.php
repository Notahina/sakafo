<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Plats extends REST_Controller {
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
        public function index_post()
        {

        }
        /**
        * Get All Data from this method.
        *
        * @return Response
        */
        public function index_get($id=0)
        {
            date_default_timezone_set('Africa/Nairobi');
            $dt = new DateTime();
            $date=$dt->format('Y-m-d');
            if(!empty($id)){
                $data = $this->db->get_where("PlatMenuJour", [
                    'idPlat'=>$id,
                    'date' => $date
                    ])->result();
            }else{
                $data = $this->db->get_where("PlatMenuJour", [
                    'date' => $date
                    ])->result();
            }
            
            $this->response([
                'status' => true,
                'data' => $data], REST_Controller::HTTP_OK);
        }
        
}
?>