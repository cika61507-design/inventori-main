<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Transaksi extends CI_Controller
{
    function __construct(){
		  parent::__construct();

      if(!isset($this->session->userdata['username'])) {
        $this->session->set_flashdata('Pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><small> Anda Belum Login! (Silahkan Login untuk mengakses halaman yang akan dituju!)</small> <button type="button" class="close" data-dismiss="alert" aria-label="Close" <span aria-hidden="true">&times;</span> </button> </div>');
        redirect('auth');
      }
      if(
    $this->session->userdata('level') != 'admin' &&
    $this->session->userdata('level') != 'gudang'
){
    redirect('dashboard');
}

      $this->load->model('MTransaksi');

    } 
    
  function view_masuk(){

    $data['tr_masuk'] = $this->MTransaksi->transaksi_masuk();
    

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_masuk/transaksi_masuk', $data);
    $this->load->view('templates/footer/tabel');
  }
  public function export_transaksi_masuk_pdf()
{
    $this->load->library('pdf');

    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'LAPORAN TRANSAKSI MASUK', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 8, 'No', 1);
    $pdf->Cell(40, 8, 'Tanggal', 1);
    $pdf->Cell(40, 8, 'No Barang', 1);
    $pdf->Cell(70, 8, 'Nama Barang', 1);
    $pdf->Cell(40, 8, 'Jumlah Masuk', 1);
    $pdf->Ln();

    $data = $this->MTransaksi->transaksi_masuk();

    $no = 1;
    foreach ($data as $row) {

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 8, $no++, 1);
        $pdf->Cell(40, 8, date('d-m-Y', strtotime($row->tanggal)), 1);
        $pdf->Cell(40, 8, $row->nomorbarang, 1);
        $pdf->Cell(70, 8, $row->nama_barang, 1);
        $pdf->Cell(40, 8, $row->jumlah_masuk, 1);
        $pdf->Ln();
    }

    $pdf->Output();
}


  function delete($id)
  {
    $where = array ('pk_transaksi_masuk_id' => $id);
    $hasil = $this->MTransaksi->hapus_data($where, 'tbl_transaksi_masuk');
    
    $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible" role="alert">
    Data Berhasil Dihapus
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>');
    
    redirect('Transaksi-masuk-view');
      
  }


  function add_view()
  {
    
    $data['barang'] = $this->MTransaksi->get_master_toobject("vbarang","pk_barang_id","kocak","nama_barang","Select","","");
        
    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_masuk/vaddtransaksimasuk', $data);
    $this->load->view('templates/footer/tabel');
  }

  function save_data()
  { //data diri

    // print_r($barangno);
    $tanggal  = $this->input->post('tanggal');
    $idbarang  = $this->input->post('id_barang');
    $jumlahmasuk  = $this->input->post('jumlah_masuk');

    $data = array(
        'tanggal' => $tanggal,
        'jam_transaksi' => date('H:i:s'),
        'id_barang' => $idbarang,
        'jumlah_masuk' => $jumlahmasuk
    );

    $this->MTransaksi->input_data($data, 'tbl_transaksi_masuk');
    $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Data Berhasil Ditambahkan
        </div>');
    redirect('Transaksi-masuk-view');

  }


  // KELUARR CROTTT

  
  function view_keluar(){

    $data['tr_keluar'] = $this->MTransaksi->transaksi_keluar();
    

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_keluar/transaksi_keluar', $data);
    $this->load->view('templates/footer/tabel');
  }
  public function export_transaksi_keluar_pdf()
{
    $this->load->library('pdf');

    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'LAPORAN TRANSAKSI KELUAR', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 8, 'No', 1);
    $pdf->Cell(40, 8, 'Tanggal', 1);
    $pdf->Cell(40, 8, 'No Barang', 1);
    $pdf->Cell(70, 8, 'Nama Barang', 1);
    $pdf->Cell(40, 8, 'Jumlah Keluar', 1);
    $pdf->Ln();

    $data = $this->MTransaksi->transaksi_keluar();

    $no = 1;
    foreach ($data as $row) {

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 8, $no++, 1);
        $pdf->Cell(40, 8, date('d-m-Y', strtotime($row->tanggal)), 1);
        $pdf->Cell(40, 8, $row->nomorbarang, 1);
        $pdf->Cell(70, 8, $row->nama_barang, 1);
        $pdf->Cell(40, 8, $row->jumlah_keluar, 1);
        $pdf->Ln();
    }

    $pdf->Output();
}

  function add_keluar()
  {
    
    $data['barang'] = $this->MTransaksi->get_master_toobject("vbarang","pk_barang_id","kocak","nama_barang","Select","","");
        
    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_keluar/vaddtransaksikeluar', $data);
    $this->load->view('templates/footer/tabel');
  }

  function save_keluar()
  {

    $tanggal  = $this->input->post('tanggal');
    $idbarang  = $this->input->post('id_barang');
    $jumlahkeluar  = $this->input->post('jumlah_keluar');

    $data = array(
        'tanggal' => $tanggal,
        'jam_transaksi' => date('H:i:s'),
        'id_barang' => $idbarang,
        'jumlah_keluar' => $jumlahkeluar
    );

    $this->MTransaksi->input_data($data, 'tbl_transaksi_keluar');
    $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Data Berhasil Ditambahkan
        </div>');
    redirect('Transaksi-keluar-view');

  }

  function accept($id)
  {
    
    //proses
    $this->MTransaksi->accept_data($id);

    //output
    $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Data Disetujui
        </div>');
    redirect('Transaksi-keluar-view');
  }

  function reject($id)
  {
    
    //proses
    $this->MTransaksi->reject_data($id);

    //output
    $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Data Tidak Disetujui
        </div>');
    redirect('Transaksi-keluar-view');
  }

}
