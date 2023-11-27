<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin_model;

class AdminSign extends BaseController
{

    public function index()
    {
        return view('admin_login');
    }

    public function in()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $username = $request->getPost('username');
        $password = $request->getPost('password');

        $modeladmin = new Admin_model;

        $data = $modeladmin->getAdminUsernamePassword($username, $password);

        if ($data) {

            foreach ($data as $row) :
            endforeach;

            $session->set([
                'username' => (empty($row->username) ? '' : $row->username),
                'nama' => (empty($row->nama) ? '' : $row->nama),
                'foto' => (empty($row->foto) ? '' : $row->foto)
            ]);

            return redirect()->to('Admin/Beranda');
        } else {
            $session->setFlashdata('error', 'Username Atau Password Salah!');
            return redirect()->back();
        }
    }

    public function out()
    {   
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to('/Admin');
    }

    public function regist()
    {
        return view('admin_regist');
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
            $modeladmin = new Admin_model;

            $data = $modeladmin->getAdminUsername($username);

            if ($data) {

                $session->setFlashdata('usernameada', 'Username Sudah Tersedia!');
                $session->setFlashdata('username', $username);
                $session->setFlashdata('nama', $nama);
                $session->setFlashdata('alamat', $alamat);
                $session->setFlashdata('telepon', $telepon);
                $session->setFlashdata('email', $email);

                return redirect()->back();

            } else {
                
                $modeladmin = new Admin_model;
                $modeladmin->addAdmin($username, $nama, $alamat, $telepon, $email, $password);

                return redirect()->to('/Admin');
            }
        }
    }
}

