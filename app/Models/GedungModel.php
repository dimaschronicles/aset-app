<?php

namespace App\Models;

use CodeIgniter\Model;

class GedungModel extends Model
{
    protected $table = 'gedung';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode', 'nama', 'lokasi'];
}
