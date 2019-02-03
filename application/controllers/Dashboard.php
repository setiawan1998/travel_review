<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('model_dashboard');
    }

	public function index()
	{
		$data['data'] = $this->model_dashboard->allData();
		$data['rating'] = $this->model_dashboard->allDataRating();
		$this->load->view('dashboard', $data);
	}
	public function getData(){
		$nama_wisata = $this->input->post('nama_wisata');
		$data = $this->model_dashboard->getData($nama_wisata);
			echo "<thead>";
			echo "<tr>";
			echo "<th>Nama</th>";
			echo "<th>Komentar</th>";
			echo "<th>Label</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($data as $item) {
				echo "<tr>";
				echo "<td>".$item->user."</td>";
				echo "<td>".$item->isi."</td>";
				echo "<td>".$item->label."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
	}
	public function getDataChart(){
		$nama_wisata = $this->input->post('nama_wisata');
		$data = $this->model_dashboard->getDataChart($nama_wisata);
		echo json_encode($data);
	}
	public function all(){
		$data = $this->model_dashboard->allData();
		echo "<thead>";
		echo "<tr>";
		echo "<th>Nama Wisata</th>";
		echo "<th>Rating(Positif/Negatif)</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach($data as $row){
			echo "<tr>";
			echo "<td>".$row->nama_wisata."</td>";
			echo "<td align='right'><b>".$row->data."</b></td>";
			echo "<tr>";
		}
		echo "</tbody>";
	}
	public function allChart(){
		$rating = $this->model_dashboard->allDataRating();
		echo json_encode($rating);
	}
}
