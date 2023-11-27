<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Keranjang_model;
use App\Models\Pengguna_model;
use App\Models\Pesanan_model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Keranjang extends BaseController
{
    public function index()
    {
        $username = session()->get('usernameuser');
        $modelkeranjang = new Keranjang_model;
        $data['keranjang'] = $modelkeranjang->getKeranjangUsername($username);

        return view('keranjang', $data);
    }

    public function add($id, $nama_produk, $harga)
    {
        $username = session()->get('usernameuser');

        $modelkeranjang = new Keranjang_model;

        $data = $modelkeranjang->getKeranjangUsernameId($username, $id);

        if (empty($data)) {
            $modelkeranjang = new Keranjang_model;
            $modelkeranjang->addKeranjang($id, $nama_produk, $harga, $username);
        }             
        
        return redirect()->to('Keranjang');
    }

    public function delete($id)
    {
        $modelkeranjang = new Keranjang_model;

        $modelkeranjang->deleteProdukKeranjang($id);

        return redirect()->back();
    }

    public function edit()
    {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $harga = $request->getPost('harga');
        $qty = $request->getPost('jumlah');
        $subtotal = intval($qty) * intval($harga);

        $modelkeranjang = new Keranjang_model;

        $modelkeranjang->editJumlah($id, $qty, $subtotal);

        return redirect()->back();
    }

    public function pesan()
    {
        $request = \Config\Services::request();

        $pembayaran = $request->getPost('pembayaran');
        $total = $request->getPost('total2');
        $username = session()->get('usernameuser');
        $foto = $this->request->getFile('foto');

        $modelpengguna = new Pengguna_model;

        $data = $modelpengguna->getPenggunaUsername($username);

        foreach ($data as $row) :
            $pemesan = $row->username;
            $nama_pemesan = $row->nama;
            $alamat = $row->alamat;
            $emailnya = $row->email;
        endforeach;
        $tanggal = date("d/m/Y H:i:s");
        $tanggal2 = date("dmYH:i:s");
        $nopes = $tanggal2.$pemesan;

        if ($foto->isValid() && !$foto->hasMoved())
        {
            $newfoto = $foto->getRandomName();
            $foto->move(ROOTPATH.'public/assets/images/pesanan/', $newfoto);

            $modelkeranjang = new Keranjang_model;
            $data = $modelkeranjang->getKeranjangUsername($username);
            for ($i = 0; $i < count($data); $i++) {
                $nama_produk = $data[$i]['nama_produk'];
                $qty = $data[$i]['qty'];
                $modelpesanan = new Pesanan_model;
                $modelpesanan->addPesanan($nopes, $tanggal, $pemesan, $alamat, $nama_produk, $qty, $pembayaran, $total, $newfoto);
            }

            $modelkeranjang = new Keranjang_model;

            $modelkeranjang->deleteAllKeranjangUser($username);

            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = 'smtp.googlemail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'kelompok11login@gmail.com';
                $mail->Password   = 'pnok wrjg tprc blzp';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;
                $mail->setFrom('admin@buahku.com', 'Admin BuahKu');
                $mail->addAddress($emailnya, $nama_pemesan);
                $mail->addReplyTo('admin@buahku.com', 'Admin BuahKu');
                $mail->isHTML(true);
                $mail->Subject = 'Pesanan Berhasil Dibuat';
                $mail->Body    = 'Hi '.$nama_pemesan.'! <br> Pesananmu Berhasil Dibuat! <br> Dengan rincian : <br>Tanggal : '.$tanggal.'<br>Nomor Pesanan : '.$nopes.'<br>Anda bisa cek lengkap pesanan Anda <a href="'.base_url('Pesanan').'">di sini.</a><br>Terima kasih';
                $mail->send();
            } catch (Exception $e) {
            }

            return redirect()->to('Pesanan');
        }
        else
        {
            $session->setFlashdata('gagaltransaksi', 'Gagal Pesan, '.$file->getErrorString());
            return redirect()->back();
        }   
    }
}