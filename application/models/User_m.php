<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User_m extends CI_Model {

    public function get($user_id)
    {
        $this->db->from('user');
        if($user_id != null){
            $this->db->where('user_id', $user_id);
        }
        $query = $this->db->get();
        return $query;
    }
        
    public function total_jml_user()
    {
        $query = $this->db->get('user');
        if ($query->num_rows()>0)
        {
            return $query->num_rows();
        }
        else
        {
            return 0;
        }
    } 

    public function insert($data){
      $this->db->insert('user',$data);
    }

    public function ambil_data($user_id)
    {
        $this->db->where('username', $user_id);
        return $this->db->get('user')->row();
    }

    public function ambil_data_id($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->get('user')->row();
    }


    public function tampil_data()
    {
        return $this->db->get('user');
    }


    public function add($post)
    {
        $params['name']     = $post['fullname'];
        $params['username'] = $post['username'];
        $params['password'] = sha1($post['password']);
        $params['address']  = $post['address'] != "" ? $post['address'] : null;
        $params['level']    = $post['level'];
        
        $this->db->insert('user', $params);
    }

    public function edit_data($where,$table){
        return $this->db->get_where($table, $where);
    }

    public function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    } 

    public function hapus_data($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
        }
function data_barang()
{
    $query = $this->db->query("
        SELECT 
            DATE(t.tanggal) as tanggal,
            b.id_barang,
            b.nama_barang,
            j.jenis_barang,
            s.satuan_barang,

            t.masuk as masuk,
            t.keluar as keluar

        FROM (

            SELECT 
                tanggal,
                jam_transaksi,
                id_barang,
                jumlah_masuk as masuk,
                0 as keluar,
                'm' as tipe
            FROM tbl_transaksi_masuk
            WHERE DATE(tanggal) >= '2026-06-2'

            UNION ALL

            SELECT 
                tanggal,
                jam_transaksi,
                id_barang,
                0 as masuk,
                jumlah_keluar as keluar,
                'k' as tipe
            FROM tbl_transaksi_keluar
            WHERE DATE(tanggal) >= '2026-06-2'

        ) t

        LEFT JOIN tbl_barang b 
        ON t.id_barang = b.pk_barang_id

        LEFT JOIN tbl_jenisbarang j
ON b.fk_jenisbarang_id = j.pk_jenisbarang_id

LEFT JOIN tbl_satuan s
ON b.fk_satuan_id = s.pk_satuan_id

      ORDER BY t.tanggal ASC, t.jam_transaksi ASC
    ");

    $data = $query->result();

    $stok_barang = [];

foreach ($data as $row) {

    if (!isset($stok_barang[$row->id_barang])) {

        $stok_barang[$row->id_barang] = $row->masuk - $row->keluar;

    } else {

        $stok_barang[$row->id_barang] += $row->masuk - $row->keluar;
    }

    $row->stok = $stok_barang[$row->id_barang];
}

    return $data;
}

    function totalbarang()
    {   
       $query = $this->db->query('SELECT * FROM tbl_barang');
    return $query->num_rows();
    }
    function barangmasuk()
    {   
        $query = $this->db->query('SELECT * FROM tbl_transaksi_masuk');
        return $query->num_rows();
    }
    function barangkeluar()
    {   
        $query = $this->db->query('SELECT * FROM tbl_transaksi_keluar where status=1');
        return $query->num_rows();
    }

    function user()
    {
        
        $query = $this->db->query("SELECT * FROM user where blokir = 'N' ");
        return $query->num_rows();
    }
}