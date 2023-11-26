<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang | BuahKu</title>
    <link rel="icon" href="<?php echo base_url('assets/images/logo.png');?>" type="images/icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="<?php echo base_url('assets/css/index.css');?>" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <nav class="navbar navbar-expand-lg bg-pink fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand m-auto" href="#"><img class="border-3" src="<?php echo base_url('assets/images/logo_2.png');?>" width="100" height="100"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-bold" aria-current="page" href="<?php echo base_url('/');?>" title="Beranda" id="link-navbar">BERANDA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="<?php echo base_url('Toko');?>" title="Toko" id="link-navbar">TOKO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="<?php echo base_url('Budidaya');?>" title="Budidaya" id="link-navbar">BUDIDAYA</a>
                </li>
                </ul>
                <span class="navbar-text text-black">
                <?php
                if (empty(session()->get('usernameuser'))) {
                    echo '<button id="tablink" button class="btn btn-pink" title="MASUK"><a class="text-decoration-none"
                    href="'.base_url('Login').'">
                    Masuk</a>
                </button>
                <button id="tablink" button class="btn btn-pink" title="DAFTAR"><a class="text-decoration-none"
                    href="'.base_url('Regist').'">
                    Daftar</a>
                </button>';
                } else {
                    echo    '<div class="dropdown">
                                <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">';
                    if(empty(session()->get('foto'))){
                        echo    '<img src="'.base_url('assets/images/profile/user.png').'"
                                    alt="'.session()->get('nama').'" width="32" height="32" class="rounded-circle me-2">
                                <strong>'.session()->get('nama').'</strong>';
                    }else{
                        echo    '<img src="'.base_url('assets/images/profile/pengguna/'). session()->get('foto') . '"
                                    alt="'.session()->get('nama').'" width="32" height="32" class="rounded-circle me-2">
                                <strong>'.session()->get('nama').'</strong>';
                    }
                    echo        '</a>
                                <ul class="dropdown-menu text-small shadow">
                                    <li><a class="dropdown-item" href="'.base_url('Profil').'" title="Akun Saya">Profil</a></li>
                                    <li><a class="dropdown-item" href="'.base_url('Keranjang').'" title="Keranjang Saya">Keranjang</a></li>
                                    <li><a class="dropdown-item" href="'.base_url('Pesanan').'" title="Pesanan Saya">Pesanan</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="'.base_url('/Out').'" title="Keluar">Keluar</a></li>
                                </ul>
                            </div>';
                }
                ?>
                </span>
            </div>
        </div>
    </nav>
</head>

<body>
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-caption">
                    <h2>KERANJANG</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->
    <section class="pb-2">
        <table class="table table-striped m-auto w-75 text-center">
            <thead>
                <tr>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                function formatRupiah($angka)
                {
                    $rupiah = "Rp" . number_format($angka, 0, ',', '.');
                    return $rupiah;
                }

                for ($i = 0; $i < count($keranjang); $i++) {
                    echo    '<tr>
                                    <td>'.$keranjang[$i]['nama_produk'].'</td>
                                    <td>'.$keranjang[$i]['qty'].'</td>
                                    <td>' . formatRupiah($keranjang[$i]['harga']) . '</td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn edit" data-id="' . $keranjang[$i]['_id'] . '"><button class="btn btn-sm border-black" title="Edit"><img src="'.base_url('assets/images/alat/edit.png').'" width="15"
                                        height="15"></button></a>
                                        <a href="Keranjang/Delete/' . $keranjang[$i]['_id'] . '" class="btn" onclick="return confirm(\'Apakah Anda Yakin Menghapus ' . $keranjang[$i]['nama_produk'] . ' Dari Keranjang?\');"><button class="btn btn-sm border-black" title="Delete"><img src="'.base_url('assets/images/alat/delete.png').'" width="15"
                                        height="15"></button></a>
                                    </td>
                                    <td>' . formatRupiah($keranjang[$i]['subtotal']) . '</td>
                                </tr>';
                }

                if (empty($keranjang)) {
                    echo '<tr><td colspan="5" class="text-center">Tidak Ada Produk Di Keranjang</td></tr>';
                }

                $totalNilai = 0;

                // Menghitung total nilai
                foreach ($keranjang as $item) {
                    $totalNilai += $item['subtotal'];
                }
                echo    '<tr>
                                <th class="text-center" scope="row" colspan="4">Total</th>
                                <td>' . formatRupiah($totalNilai) . '</td>
                            </tr>';
                ?>
            </tbody>
        </table>
    </section>
    <?php
    if (!empty(session()->getFlashdata('gagaltransaksi'))) {
        echo '<div class="container m-auto"><div class="alert mt-1 mb-1 text-danger p-0 text-center" role="alert">' . session()->getFlashdata('gagaltransaksi') . '</div></div>';
    }
    ?>
    <section class="text-center mt-3">
        <a href="javascript:void(0);" id="pesan"><button class="btn border-black w-75 mb-3" title="Pesan"><img src="<?php echo base_url('assets/images/alat/checklist.png');?>" width="20" height="20"> Pesan</button></a>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="modalEditKeranjang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Jumlah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditKeranjang" action="<?= base_url('Keranjang/Edit');?>" method="POST">
                        <div class="mb-3">
                            <label for="produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="produk" name="produk" disabled>
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="harga" name="harga">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Barang</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" form="formEditKeranjang">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPesan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Pesanan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPesan" enctype="multipart/form-data" action="<?= base_url('Keranjang/Pesan');?>" method="POST">
                        <div class="mb-3">
                            <label for="total" class="form-label">Total Pembayaran</label>
                            <input type="text" class="form-control" id="total" name="total" value="<?php echo formatRupiah($totalNilai) ?>" disabled>
                            <input type="hidden" class="form-control" id="total2" name="total2" value="<?php echo $totalNilai ?>">
                        </div>
                        <div class="mb-3">
                            <label for="pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" aria-label="Default select example" id="pembayaran" name="pembayaran">
                                <option selected>Pilih Metode Pembayaran</option>
                                <option value="Dana">Dana (087654321098 a.n. BuahKu)</option>
                                <option value="Ovo">Ovo (087654321098 a.n. BuahKu)</option>
                                <option value="Gopay">Gopay (087654321098 a.n. BuahKu)</option>
                                <option value="Transfer">Transfer (BNI : 04030201 a.n. BuahKu)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Unggah Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="foto" name="foto" placeholder="Unggah Bukti Pembayaran" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" form="formPesan">Pesan</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('assets/js/keranjang.js');?>"></script>
</body>

<!--Footer-->
<footer class="text-black pt-5 pb-4 bg-pink">
  <div class="container text-center text-md-start">
    <div class="row text-center text-md-start">
      <div class="col-md-6 col-lg-3 col-xl-3 mx-auto mt-3">
        <h1 class="mb-4" style="font-weight: 700">BuahKu</h1>
        <p style="font-weight: 500; text-align: justify;">Nikmati kemudahan berbelanja buah-buahan segar dari kenyamanan rumah Anda, dengan pengiriman yang cepat dan aman. Kami bangga menjadi destinasi pilihan Anda untuk memenuhi semua kebutuhan buah-buahan Anda </p>
      </div>

      <div class="col-md-6 col-lg-3 col-xl-3 mx-auto mt-3">
        <h1 class="mb-4" style="font-weight: 700;">Kontak</h1>
        <p style="font-weight: 500;">
          <i class="bi bi-geo-alt mr-3"></i> Kota Bogor, Jawa Barat
        </p>
        <p style="font-weight: 500;">
          <i class="bi bi-envelope mr-3"></i> BuahKu@gmail.com
        </p>
        <p style="font-weight: 500;">
          <i class="bi bi-telephone"></i> +62 81234567891
        </p>
      </div>
    </div>
    <hr class="mb-4">
    <div class="row align-items-center" style="font-weight: 500;">
      <div class="text-center">
        <p> Hak Cipta @2023 Semua hak dilindungi undang-undang oleh:
          <a href="#" style="text-decoration: none;">
            <strong class="text-black" style="font-weight: 500;">BuahKu</strong>
          </a>
        </p>
      </div>
    </div>
  </div>

</footer>
<!--Footer end-->

</html>