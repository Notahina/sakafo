<?php 
    class EtudiantModel extends CI_Model{
        Public function __construct() { 
            parent::__construct();
            $this->load->database(); 
        } 
        public function InsertEtudiant($data){
            $nom=$data['nom'];
            $pwd= $data['pwd'];
            $date=$data['datenaissance'];
            $sql="INSERT INTO Etudiants VALUES(null,'".$nom."',sha1('".$pwd."'),'".$date."')";
            echo $sql;
            $this->db->query($sql);
            
            //return $insert?true:false;
        }
        public function LoginEtu($login ,$pwd){
            $pwd="sha1('".$pwd."')";
            $sql="select * from etudiants where nom='".$login."' and pwd=".$pwd;
            //echo $sql;
            $data = $this->db->query($sql)->row_array();
            $idetu=$data['idetu'];
            return $idetu;
        }
    }
?>