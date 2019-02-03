<?php

class Model_dashboard extends CI_Model{
    public function allData(){
        $data = $this->db->query('SELECT *,CONCAT(
            (SELECT COALESCE(COUNT(rating), 0) FROM review WHERE label="positif" AND nama_wisata=r.nama_wisata), 
            " , ",
            (SELECT COALESCE(COUNT(rating), 0) FROM review WHERE label="negatif" AND nama_wisata=r.nama_wisata)
        ) AS data FROM review AS r GROUP BY nama_wisata')->result();
        return $data;
    }
    public function allDataRating(){
        $data = $this->db->query('SELECT *, CONCAT(
            (SELECT COALESCE(COUNT(rating), 0) FROM review WHERE label="positif"),
            " , ",
            (SELECT COALESCE(COUNT(rating), 0) FROM review WHERE label="negatif")
        ) AS data FROM review')->row();
        return $data;
    }
    public function getData($nama_wisata){
        $data = $this->db->from('review')->where('nama_wisata', $nama_wisata)->where('label !=','Netral')->get()->result();
        return $data;
    }
    public function getDataChart($nama_wisata){
        $data = $this->db->query('SELECT *,CONCAT(
            (SELECT COALESCE(COUNT(rating), 0) FROM review WHERE label="positif" AND nama_wisata=r.nama_wisata), 
            ",",
            (SELECT COALESCE(COUNT(rating), 0) FROM review WHERE label="negatif" AND nama_wisata=r.nama_wisata)
        ) AS data FROM review AS r WHERE nama_wisata="'.$nama_wisata.'" GROUP BY nama_wisata')->row();
        return $data;
    }
}

?>