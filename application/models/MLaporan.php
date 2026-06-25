<?php 
/**
 *
 */
class MLaporan extends CI_Model
{
   function graph()
   {
    $data = $this->db->query("SELECT tanggal,MONTH(tanggal) AS bulan, SUM(jumlah_masuk) AS jumlah_masuk FROM tbl_transaksi_masuk GROUP BY bulan");
    return $data->result();
   }
   function graph_keluar()
   {
    $data = $this->db->query("SELECT tanggal,MONTH(tanggal) AS bulan, SUM(jumlah_keluar) AS jumlah_keluar FROM tbl_transaksi_keluar where status=1 GROUP BY bulan");
    return $data->result();
   }

   function show_barang()
{
   $barang = $this->db->query("
   SELECT a.*, b.nama_barang,b.satuan_barang 
   FROM tbl_transaksi_masuk a 
   LEFT JOIN vbarang b ON a.id_barang = b.pk_barang_id
   ORDER BY tanggal ASC
   ");

   return $barang->result();
}

   
   function show_barang_keluar()
{
   $barang = $this->db->query("
   SELECT a.*, b.nama_barang,b.satuan_barang 
   FROM tbl_transaksi_keluar a 
   LEFT JOIN vbarang b ON a.id_barang = b.pk_barang_id 
   WHERE status =1
   ORDER BY tanggal ASC
   ");

   return $barang->result();
}

   
   function data_barang($dari, $sampai)
   {  
      if($dari == '' && $sampai == ''){
         $barang = $this->db->query("SELECT a.*, b.nama_barang,b.satuan_barang FROM tbl_transaksi_masuk a left join vbarang b on a.id_barang = b.pk_barang_id");
      }else
      {

         $barang = $this->db->query("SELECT a.*, b.nama_barang,b.satuan_barang FROM tbl_transaksi_masuk a left join vbarang b on a.id_barang = b.pk_barang_id
         WHERE tanggal >= '$dari' AND tanggal <= '$sampai' ");
      }
      return $barang->result();

   }
   
   function data_barang_keluar($dari, $sampai)
   {  
      if($dari == '' && $sampai == ''){
         $barang = $this->db->query("SELECT a.*, b.nama_barang,b.satuan_barang FROM tbl_transaksi_keluar a left join vbarang b on a.id_barang = b.pk_barang_id
          WHERE STATUS=1");
      }else
      {

         $barang = $this->db->query("SELECT a.*, b.nama_barang,b.satuan_barang FROM tbl_transaksi_keluar a left join vbarang b on a.id_barang = b.pk_barang_id
         WHERE tanggal >= '$dari' AND tanggal <= '$sampai' and status=1 ");
      }
      return $barang->result();

   }
   function laporan_stok()
{
    $query = $this->db->query("
       SELECT
    b.pk_barang_id,
    b.id_barang,
    b.nama_barang,
    b.jenis_barang,

    COALESCE(m.total_masuk,0) AS total_masuk,
    COALESCE(k.total_keluar,0) AS total_keluar,

    (COALESCE(m.total_masuk,0) -
    COALESCE(k.total_keluar,0)) AS sisa_stok,

    b.satuan_barang,

    m.tgl_masuk_terakhir,
    k.tgl_keluar_terakhir
    ,
GREATEST(
    IFNULL(m.tgl_masuk_terakhir,'0000-00-00'),
    IFNULL(k.tgl_keluar_terakhir,'0000-00-00')
) AS urut_terakhir
        FROM vbarang b

        LEFT JOIN (
            SELECT
                id_barang,
                SUM(jumlah_masuk) AS total_masuk,
                 MAX(CONCAT(tanggal,' ',jam_transaksi)) AS tgl_masuk_terakhir
            FROM tbl_transaksi_masuk
            GROUP BY id_barang
        ) m ON b.pk_barang_id = m.id_barang

        LEFT JOIN (
            SELECT
                id_barang,
                SUM(jumlah_keluar) AS total_keluar,
                 MAX(CONCAT(tanggal,' ',jam_transaksi)) AS tgl_keluar_terakhir
            FROM tbl_transaksi_keluar
            WHERE status = 1
            GROUP BY id_barang
        ) k ON b.pk_barang_id = k.id_barang

WHERE m.id_barang IS NOT NULL
   OR k.id_barang IS NOT NULL

ORDER BY urut_terakhir DESC
    ");

    return $query->result();
}

}
