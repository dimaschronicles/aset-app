<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nik', 'username', 'name', 'email', 'telephone', 'gender', 'address', 'image', 'role', 'created_at', 'password'];

    public function getLogin($username)
    {
        return $this->db->table($this->table)->getWhere(['username' => $username])->getRowArray();
    }

    public function getCountAdmin()
    {
        $builder = $this->builder($this->table);
        $this->builder->where('role', 2);
        return $this->builder->countAllResults();
    }

    public function getCountUser()
    {
        $builder = $this->builder($this->table);
        $this->builder->where('role', 3);
        return $this->builder->countAllResults();
    }
}
