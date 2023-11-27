<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Pengguna_model;

class Sign extends BaseController
{

    public function index()
    {
        // echo view('login');
        return view('login');
    }

    public function in()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $username = $request->getPost('username');
        $password = $request->getPost('password');

        $modelpengguna = new Pengguna_model;

        $data = $modelpengguna->getPenggunaUsernamePassword($username, $password);

        if ($data) {

            foreach ($data as $row) :
            endforeach;

            $session->set([
                'usernameuser' => (empty($row->username) ? '' : $row->username),
                'nama' => (empty($row->nama) ? '' : $row->nama),
                'foto' => (empty($row->foto) ? '' : $row->foto)
            ]);

            return redirect()->to('/');
        } else {
            $session->setFlashdata('error', 'Username Atau Password Salah!');
            return redirect()->back();
        }
    }

    public function out()
    {   
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function regist()
    {
        return view('regist');
        // echo view('regist');
    }

    public function up()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $username = $request->getPost('username');
        $nama = $request->getPost('nama');
        $email = $request->getPost('email');
        $telepon = $request->getPost('telepon');
        $alamat = $request->getPost('alamat');
        $password = $request->getPost('password');
        $confirm_password = $request->getPost('confirm_password');

        if($password != $confirm_password){
            $session->setFlashdata('bedapass', 'Password Yang Anda Masukkan Berbeda!');
            $session->setFlashdata('username', $username);
            $session->setFlashdata('nama', $nama);
            $session->setFlashdata('alamat', $alamat);
            $session->setFlashdata('telepon', $telepon);
            $session->setFlashdata('email', $email);
            return redirect()->back();
        }
        else {
            $modelpengguna = new Pengguna_model;

            $data = $modelpengguna->getPenggunaUsername($username);

            if ($data) {

                $session->setFlashdata('usernameada', 'Username Sudah Tersedia!');
                $session->setFlashdata('username', $username);
                $session->setFlashdata('nama', $nama);
                $session->setFlashdata('alamat', $alamat);
                $session->setFlashdata('telepon', $telepon);
                $session->setFlashdata('email', $email);

                return redirect()->back();

            } else {
                
                $modelpengguna = new Pengguna_model;
                $modelpengguna->addPengguna($username, $nama, $alamat, $telepon, $email, $password);

                return redirect()->to('Login');
            }
        }
    }
}

