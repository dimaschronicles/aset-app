<?php

namespace App\Models;

use CodeIgniter\Model;

class RuangModel extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode', 'nama'];
}
