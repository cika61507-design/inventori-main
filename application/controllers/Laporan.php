<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/fpdf181/fpdf.php'
;/**
* 
*/
class Laporan extends CI_Controller
{
    function __construct(){
		  parent::__construct();

      if(!isset($this->session->userdata['username'])) {
        $this->session->set_flashdata('Pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><small> Anda Belum Login! (Silahkan Login untuk mengakses halaman yang akan dituju!)</small> <button type="button" class="close" data-dismiss="alert" aria-label="Close" <span aria-hidden="true">&times;</span> </button> </div>');
        redirect('auth');
      }


      $this->load->library('pdf');
      $this->load->model('MLaporan');
      $this->load->model('MTransaksi');

    } 
    
    function barang_masuk()
    {

        $data['graph'] = $this->MLaporan->graph();
        $data['caribarang'] = $this->MLaporan->show_barang();
        
        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/barangmasuk', $data);
        $this->load->view('templates/footer/tabel');
    }

    function barang_keluar()
    {

        $data['graph'] = $this->MLaporan->graph_keluar();
        $data['caribarang'] = $this->MLaporan->show_barang_keluar();
        
        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/barangkeluar', $data);
        $this->load->view('templates/footer/tabel');
    }

    function stok_barang()
    {
        
        $data['barang'] = $this->MLaporan->laporan_stok();

		$this->load->view('templates/head/dashboard');
		$this->load->view('templates/sidebar');
		$this->load->view('templates/topbar');
		$this->load->view('master/laporan/stokbarang', $data);
        $this->load->view('templates/footer/tabel');
    }

    function laporan_masuk()
    {
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');

        $data['caribarang'] = $this->MLaporan->data_barang($dari,$sampai);

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/barangmasuk', $data);
        $this->load->view('templates/footer/tabel');
    }

    function laporan_keluar()
    {
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');

        $data['caribarang'] = $this->MLaporan->data_barang_keluar($dari,$sampai);

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/barangkeluar', $data);
        $this->load->view('templates/footer/tabel');
    }

    function export_pdf_masuk($dari = null, $sampai = null)
    {    
        $pdf = new FPDF('l','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'DATA BARANG MASUK',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'Tanggal',1,0);
        $pdf->Cell(85,6,'Nama Barang',1,0);
        $pdf->Cell(27,6,'Jumlah Masuk',1,0);
        $pdf->Cell(25,6,'Satuan',1,1);
        $pdf->SetFont('Arial','',10);


        $dtbarang = $this->MLaporan->data_barang($dari,$sampai);

        foreach ($dtbarang as $row){
            $pdf->Cell(20,6,$row->tanggal,1,0);
            $pdf->Cell(85,6,$row->nama_barang,1,0);
            $pdf->Cell(27,6,$row->jumlah_masuk,1,0);
            $pdf->Cell(25,6,$row->satuan_barang,1,1); 
        }
        $pdf->Output();

    }

    function export_pdf_keluar($dari = null, $sampai = null)
    {    
        $pdf = new FPDF('l','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'DATA BARANG KELUAR',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'Tanggal',1,0);
        $pdf->Cell(85,6,'Nama Barang',1,0);
        $pdf->Cell(27,6,'Jumlah Keluar',1,0);
        $pdf->Cell(25,6,'Satuan',1,1);
        $pdf->SetFont('Arial','',10);


        $dtbarang = $this->MLaporan->data_barang_keluar($dari,$sampai);

        foreach ($dtbarang as $row){
            $pdf->Cell(20,6,$row->tanggal,1,0);
            $pdf->Cell(85,6,$row->nama_barang,1,0);
            $pdf->Cell(27,6,$row->jumlah_keluar,1,0);
            $pdf->Cell(25,6,$row->satuan_barang,1,1); 
        }
        $pdf->Output();

    }
function export_stok_pdf()
{
    $this->load->library('fpdf');

    $pdf = new FPDF('L','mm','A4');
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,'LAPORAN STOK BARANG',0,1,'C');

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(10,8,'No',1);
    $pdf->Cell(30,8,'ID Barang',1);
    $pdf->Cell(50,8,'Nama Barang',1);
    $pdf->Cell(40,8,'Jenis Barang',1);
    $pdf->Cell(25,8,'Masuk',1);
    $pdf->Cell(25,8,'Keluar',1);
    $pdf->Cell(25,8,'Stok',1);
    $pdf->Cell(30,8,'Satuan',1);
    $pdf->Cell(40,8,'Tanggal',1);
    $pdf->Ln();

    // 🔥 INI YANG WAJIB
    $data = $this->MLaporan->laporan_stok();

    $no = 1;
    foreach ($data as $row) {

    $masuk = $row->total_masuk;
    $keluar = $row->total_keluar;
    $stok = $row->sisa_stok;

        $pdf->SetFont('Arial','',10);
        $pdf->Cell(10,8,$no++,1);
        $pdf->Cell(30,8,$row->id_barang,1);
        $pdf->Cell(50,8,$row->nama_barang,1);
        $pdf->Cell(40,8,$row->jenis_barang,1);
        $pdf->Cell(25,8,$masuk,1);
        $pdf->Cell(25,8,$keluar,1);
        $pdf->Cell(25,8,$stok,1);
        $pdf->Cell(30,8,$row->satuan_barang,1);
        $pdf->Cell(40,8,date('d-m-Y', strtotime($row->urut_terakhir)),1);
        $pdf->Ln();
    }

    $pdf->Output();
}
}
