<?php

namespace App\Models;

use Exception;
use CodeIgniter\Model;

class OtentikasiModel extends Model
{
    protected $table = 'otentikasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];

    function getUsername($username)
    {
        $db = \Config\Database::connect();
        $builder = $this->table('otentikasi');
        $data = $builder->where('username', $username)->first();
        if (!$data) {
            throw new Exception("Authentication not found!");
        }
        return $data;
    }
}
