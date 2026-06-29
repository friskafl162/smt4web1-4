<?php

namespace app\Controllers\Api;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        // === TAMBAHKAN 3 BARIS INI ===
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: *');
        // =============================
        
        // Ambil data input
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $model = new UserModel();

        // Cari user berdasarkan username atau email
        $user = $model->where('username', $username)
                      ->orWhere('useremail', $username)
                      ->first();

        if ($user) {
            // Verifikasi password
            if (
                $password === $user['userpassword'] ||
                password_verify($password, $user['userpassword'])
            ) {
                return $this->respond([
                    'status'   => 200,
                    'error'    => null,
                    'messages' => 'Login Berhasil',
                    'data'     => [
                        'id'       => $user['id'],
                        'username' => $user['username'],
                        'token'    => base64_encode(
                            'TOKEN-SECRET-' . $user['username']
                        ),
                    ],
                ], 200);
            }
        }

        // Jika login gagal
        return $this->failUnauthorized(
            'Username atau Password yang Anda masukkan salah.'
        );
    }
}