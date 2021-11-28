<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nomor', 'sub_nomor', 'satuan', 'kode_barang', 'no_aset', 'tercatat', 'kode_lokasi', 'kode_perkap', 'kondisi_aset', 'uraian_aset', 'uraian_perkap', 'kode_ruang', 'uraian_ruang', 'kondisi', 'catatan', 'nominal_aset', 'foto', 'tanggal_pengadaan', 'sumber_pengadaan', 'qr_code', 'user_penginput', 'created_at', 'deleted_at'];

    protected $useTimestamps = true;
    // protected $dateFormat           = 'datetime';
    // protected $createdField         = 'created_at';
    // protected $updatedField         = 'updated_at';
    // protected $deletedField         = 'deleted_at';
}
