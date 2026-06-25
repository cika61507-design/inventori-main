
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- DataTales Example -->
	<?php echo $this->session->flashdata('message_edit') ?>
	<?php echo $this->session->flashdata('message_success') ?>
	<?php echo $this->session->flashdata('message') ?>
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			Stok Barang Telah Mencapai Batas Minimum
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered"  width="100%" cellspacing="0">
					<thead>
<tr>
    <th>No</th>
    <th>ID Barang</th>
    <th>Nama Barang</th>
    <th>Jenis Barang</th>
    <th>Total Masuk</th>
    <th>Tgl Masuk Terakhir</th>
    <th>Total Keluar</th>
    <th>Tgl Keluar Terakhir</th>
    <th>Sisa Stok</th>
    <th>Satuan</th>
</tr>
</thead>
<tbody>
<?php 
$no = 1;



?>

<?php if (!empty($barang)) : ?>


<?php foreach ($barang as $row) : ?>


<tr>
    <td><?= $no++; ?></td>
    <td><?= $row->id_barang ?></td>
    <td><?= $row->nama_barang ?></td>
    <td><?= $row->jenis_barang ?></td>

    <td><?= $row->total_masuk ?></td>
    <td>
<?= !empty($row->tgl_masuk_terakhir)
    ? date('d-m-Y', strtotime($row->tgl_masuk_terakhir))
    : '-' ?>
</td>

    <td><?= $row->total_keluar ?></td>
    <td>
<?= !empty($row->tgl_keluar_terakhir)
    ? date('d-m-Y', strtotime($row->tgl_keluar_terakhir))
    : '-' ?>
</td>

    <td><?= $row->sisa_stok ?></td>
    <td><?= $row->satuan_barang ?></td>
</tr>
<?php endforeach; ?>

<?php else : ?>
<tr>
    <td colspan="10" align="center">Tidak Ada Data</td>
</tr>

<?php endif; ?>
</tbody>
				</table>
			</div>
            <button class="btn btn-warning"></button> Stok Minimum <br>
            <button class="btn btn-danger"></button> Stok Kosong <br>
            <a href="<?= base_url('laporan/export_stok_pdf') ?>" class="btn btn-primary">
    Export PDF 
</a>
		</div>
	</div>
</div>

