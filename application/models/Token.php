<?php 
    class Token extends CI_Model{
        Public function __construct() { 
            parent::__construct();
            $this->load->database(); 
        } 
        public function Createtoken($idetu,$date){
           
            date_default_timezone_set('Africa/Nairobi');
            $dt = new DateTime();
            $token="sha1('E".$idetu."/".$date."')";
            $hours=1;
            $dtexpiration=$dt->add(new DateInterval("PT1H"));
            $date=$dtexpiration->format('Y-m-d H:i:s');
            
            $val=array(
                "idtoken"=> $token,
                "idetu" => $idetu,
                "dateexpiration"  => $date
            );
            //var_dump($val);
            $insert="INSERT INTO Token VALUES(".$val["idtoken"].",".$idetu.",'".$date."')";
            //echo $insert;
            $this->db->query($insert);
        }
        public function VerifyToken($idetu,$date){
            
            $sql="Select * from Token where idetu=".$idetu." and dateexpiration > '".$date."'";
            //echo $sql;
            $data = $this->db->query($sql)->row_array();
            return $data;
        }
        public function getIdEtu($token){
            $sql ="select *from token where idtoken='".$token."'";
            $data = $this->db->query($sql)->row_array();
            return $data["idetu"];
        }
        public function CreateVerifyToken($idetu){
            date_default_timezone_set('Africa/Nairobi');
            $dt = new DateTime();
            $date=$dt->format('Y-m-d H:i:s');
            $data=$this->VerifyToken($idetu,$date);
            if($data!=null){
                return $data["idtoken"];
            }else{
                $this->Createtoken($idetu,$date);
                $data=$this->VerifyToken($idetu,$date);
                return $data["idtoken"];
            }
        }
    }

?>