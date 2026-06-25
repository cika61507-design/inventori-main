<body id="page-top">

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?= base_url('/') ?>">Inventori Gudang</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        ☰
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i> Beranda
                </a>
            </li>

            <?php 
            $level = $this->session->userdata('level');
            if($level == 'admin') :
            ?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    Data Master
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?=base_url('Barang-view')?>">Data Barang</a>
                    <a class="dropdown-item" href="<?=base_url('Jenis-barang-view')?>">Jenis Barang</a>
                    <a class="dropdown-item" href="<?=base_url('Satuan-view')?>">Satuan</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    Data barang
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?=base_url('Transaksi-masuk-view')?>">Barang Masuk</a>
                    <a class="dropdown-item" href="<?=base_url('Transaksi-keluar-view')?>">Barang Keluar</a>
                </div>
            </li>

            <?php endif; ?>

            <?php if($level == 'gudang') : ?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
        Data Barang
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="<?=base_url('Transaksi-masuk-view')?>">Barang Masuk</a>
        <a class="dropdown-item" href="<?=base_url('Transaksi-keluar-view')?>">Barang Keluar</a>
    </div>
</li>

<?php else : ?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
        Laporan
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="<?=base_url('Laporan-stok-barang')?>">Stok Barang</a>
        <a class="dropdown-item" href="<?=base_url('Laporan-barang-masuk')?>">Barang Masuk</a>
        <a class="dropdown-item" href="<?=base_url('Laporan-barang-keluar')?>">Barang Keluar</a>
    </div>
</li>

<?php endif; ?>

            <?php if($level == 'admin') : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    Pengaturan
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?=base_url('User')?>">Manajemen User</a>
                </div>
            </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>auth/logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>

        </ul>
    </div>
</nav>

<!-- Wrapper -->
<div id="wrapper">