<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\UserModel;
use App\Models\RuangModel;
use Endroid\QrCode\QrCode;
use App\Models\BarangModel;
use App\Models\GedungModel;
use App\Models\KategoriModel;
use App\Controllers\BaseController;
use App\Models\SupplierModel;
use Endroid\QrCode\Writer\PngWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Aset extends BaseController
{
    public function __construct()
    {
        $this->user = new UserModel();
        $this->aset = new AsetModel();
        $this->barang = new BarangModel();
        $this->kategori = new KategoriModel();
        $this->supplier = new SupplierModel();
        $this->gedung = new GedungModel();
        $this->ruangan = new RuangModel();

        helper('form');
    }

    public function index()
    {
        $filter_aset = $this->request->getVar('filter_kondisi');

        if ($filter_aset == null) {
            $hasil = $this->aset->getAllAset();
        } elseif ($filter_aset == 'Baik') {
            $hasil = $this->aset->getAllAset($filter_aset);
        } elseif ($filter_aset == 'Kurang') {
            $hasil = $this->aset->getAllAset($filter_aset);
        } elseif ($filter_aset == 'Rusak') {
            $hasil = $this->aset->getAllAset($filter_aset);
        }

        $data = [
            'title' => 'Data Aset',
            'aset' => $hasil,
            'filter_kondisi' => $filter_aset,
        ];

        return view('aset/index', $data);
    }

    public function create()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $kode = $this->db->table('aset')->selectMax('id_aset')->get()->getResultArray();
        $kodeAset = $kode[0]['id_aset'];
        $urutan = intval($kodeAset);
        $urutan++;
        $huruf = "KDA";
        $kode_aset = $huruf . sprintf("%04s", $urutan);

        $data = [
            'title' => 'Tambah Data Aset',
            'validation' => \Config\Services::validation(),
            'user' => session()->get('nama'),
            'kategori' => $this->kategori->findAll(),
            'barang' => $this->barang->findAll(),
            'supplier' => $this->supplier->findAll(),
            'gedung' => $this->aset->getGedung(),
            'ruangan' => $this->aset->getRuangan(),
            'gedung_selected' => '',
            'ruangan_selected' => '',
            'kode_aset' => $kode_aset,
        ];

        return view('aset/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'kode_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Aset harus diisi!',
                ]
            ],
            'nama_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Aset harus diisi!',
                ]
            ],
            'kategori' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kategori harus diisi!',
                ]
            ],
            'jumlah' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Jumlah harus diisi!',
                    'numeric' => 'Jumlah harus angka!',
                ]
            ],
            'satuan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Satuan harus diisi!',
                ]
            ],
            'kondisi' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kondisi harus diisi!',
                ]
            ],
            'nilai_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nilai Aset harus diisi!',
                ]
            ],
            'gedung' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Gedung harus diisi!',
                ]
            ],
            'ruangan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Ruangan harus diisi!',
                ]
            ],
            'sumber' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Sumber Pengadaan harus diisi!',
                ]
            ],
            'keterangan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Keterangan harus diisi!',
                ]
            ],
            // 'tanggal_masuk' => [
            //     'rules' => 'trim|required',
            //     'errors' => [
            //         'required' => 'Tanggal Masuk harus diisi!',
            //     ]
            // ],
            'image' => [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->to('/aset/add')->withInput();
        }

        $fileFoto = $this->request->getFile('image');
        if ($fileFoto->getError() == 4) {
            $namaFoto = 'default.jpg';
        } else {
            $namaFoto = $fileFoto->getRandomName();

            $image = \Config\Services::image()
                ->withFile($fileFoto)
                ->resize(400, 200, true, 'height')
                ->save(FCPATH . '/img/aset/' . $namaFoto);
        }

        $kode = $this->request->getVar('kode_aset');

        $writer = new PngWriter();
        $qrCode = QrCode::create($kode)->setSize(300);
        $result = $writer->write($qrCode);
        header('Content-Type: ' . $result->getMimeType());
        $result->saveToFile(FCPATH . '/img/aset/qr/' . $qrCode->getData() . '.png');

        $nilai = $this->request->getVar('nilai_aset');
        $resultNilai = preg_replace("/[^0-9]/", "", $nilai);
        $jumlah = $this->request->getVar('jumlah');
        $total = intval($resultNilai) * $jumlah;

        $this->aset->save([
            'kode_aset' => $kode,
            'id_barang' => $this->request->getVar('nama_aset'),
            'id_kategori' => $this->request->getVar('kategori'),
            'jumlah' => $jumlah,
            'satuan' => $this->request->getVar('satuan'),
            'kondisi' => $this->request->getVar('kondisi'),
            'id_gedung' => $this->request->getVar('gedung'),
            'id_ruangan' => $this->request->getVar('ruangan'),
            'nilai_aset' => $resultNilai,
            'total_aset' => strval($total),
            'keterangan' => $this->request->getVar('keterangan'),
            // 'tanggal_masuk' => $this->request->getVar('tanggal_masuk'),
            'id_supplier' => $this->request->getVar('sumber'),
            'qr_code' => $qrCode->getData() . '.png',
            'foto' => $namaFoto,
            'status' => 'Aktif',
            'user_penginput' => $this->request->getVar('user_penginput'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil ditambahkan!</div>');

        return redirect()->to('/aset');
    }

    public function edit($kode_barang)
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Ubah Data Aset',
            'validation' => \Config\Services::validation(),
            'user' => session()->get('nama'),
            'aset' => $this->aset->getAset($kode_barang),
            'kategori' => $this->kategori->findAll(),
            'barang' => $this->barang->findAll(),
            'supplier' => $this->supplier->findAll(),
            'gedung' => $this->aset->getGedung(),
            'ruangan' => $this->aset->getRuangan(),
            'gedung_selected' => '',
            'ruangan_selected' => '',
        ];

        return view('aset/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'kode_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Aset harus diisi!',
                ]
            ],
            'nama_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nama Aset harus diisi!',
                ]
            ],
            'kategori' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kategori harus diisi!',
                ]
            ],
            'jumlah' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Jumlah harus diisi!',
                    'numeric' => 'Jumlah harus angka!',
                ]
            ],
            'satuan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Satuan harus diisi!',
                ]
            ],
            'kondisi' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kondisi harus diisi!',
                ]
            ],
            'nilai_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nilai Aset harus diisi!',
                ]
            ],
            'gedung' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Gedung harus diisi!',
                ]
            ],
            'ruangan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Ruangan harus diisi!',
                ]
            ],
            'sumber' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Sumber Pengadaan harus diisi!',
                ]
            ],
            'keterangan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Keterangan harus diisi!',
                ]
            ],
            // 'tanggal_masuk' => [
            //     'rules' => 'trim|required',
            //     'errors' => [
            //         'required' => 'Tanggal Masuk harus diisi!',
            //     ]
            // ],
            'image' => [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->to('/aset/edit/' . $this->request->getVar('kode_aset'))->withInput();
        }

        $fileFoto = $this->request->getFile('image');
        if ($fileFoto->getError() == 4) {
            $namaFoto = $this->request->getVar('old_image');
        } else {
            $namaFoto = $fileFoto->getRandomName();

            $image = \Config\Services::image()
                ->withFile($fileFoto)
                ->resize(400, 200, true, 'height')
                ->save(FCPATH . '/img/aset/' . $namaFoto);

            if ($image != 'default.jpg') {
                unlink('img/aset/' . $this->request->getVar('old_image'));
            } else if ($namaFoto != 'default.jpg') {
                unlink('img/aset/' . $this->request->getVar('old_image'));
            }
        }

        $kode = $this->request->getVar('kode_aset');

        $writer = new PngWriter();
        $qrCode = QrCode::create($kode)->setSize(300);
        $result = $writer->write($qrCode);
        header('Content-Type: ' . $result->getMimeType());
        $result->saveToFile(FCPATH . '/img/aset/qr/' . $qrCode->getData() . '.png');

        $nilai = $this->request->getVar('nilai_aset');
        $resultNilai = preg_replace("/[^0-9]/", "", $nilai);
        $jumlah = $this->request->getVar('jumlah');
        $total = intval($resultNilai) * $jumlah;

        $this->aset->save([
            'id_aset' => $id,
            'kode_aset' => $kode,
            'id_barang' => $this->request->getVar('nama_aset'),
            'id_kategori' => $this->request->getVar('kategori'),
            'jumlah' => $jumlah,
            'satuan' => $this->request->getVar('satuan'),
            'kondisi' => $this->request->getVar('kondisi'),
            'id_gedung' => $this->request->getVar('gedung'),
            'id_ruangan' => $this->request->getVar('ruangan'),
            'nilai_aset' => $resultNilai,
            'total_aset' => strval($total),
            'keterangan' => $this->request->getVar('keterangan'),
            // 'tanggal_masuk' => $this->request->getVar('tanggal_masuk'),
            'id_supplier' => $this->request->getVar('sumber'),
            'qr_code' => $qrCode->getData() . '.png',
            'foto' => $namaFoto,
            'status' => 'Aktif',
            'user_penginput' => $this->request->getVar('user_penginput'),
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil diubah!</div>');

        return redirect()->to('/aset');
    }

    public function delete($id)
    {
        $this->aset->save([
            'id_aset' => $id,
            'status' => 'Non Aktif'
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil dihapus!</div>');
        return redirect()->to('/aset');
    }

    public function detail($kode_aset)
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Detail Data Aset',
            'validation' => \Config\Services::validation(),
            'aset' => $this->aset->getAset($kode_aset),
        ];

        return view('aset/detail', $data);
    }

    public function trash()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Data Aset Dihapus',
            'aset' => $this->aset->getAllAsetNon(),
        ];

        return view('aset/trash', $data);
    }

    public function restore($id)
    {
        $this->aset->save([
            'id_aset' => $id,
            'status' => 'Aktif'
        ]);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil direstore!</div>');
        return redirect()->to('/aset');
    }

    public function destroy($kode)
    {
        $barang = $this->db->table('aset')->where('kode_aset', $kode)->get()->getRowArray();

        if ($barang['foto'] != 'default.jpg') {
            unlink('img/aset/' . $barang['foto']);
        }

        if ($barang['qr_code'] == true || $barang['qr_code'] == null) {
            unlink('img/aset/qr/' . $barang['qr_code']);
        }

        $builder = $this->db->table('aset');
        $builder->delete(['kode_aset' => $kode]);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil dihapus permanen!</div>');
        return redirect()->to('/aset/trash');
    }

    public function excel()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Import Excel',
        ];

        return view('aset/excel', $data);
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');
        $ext = $file->getClientExtension();

        if ($ext == 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }

        $spreadsheet = $render->load($file);

        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $x => $excel) {
            if ($x == 0) {
                continue;
            }

            $data = [
                'nomor' => $excel['1'],
                'sub_nomor' => $excel['2'],
                'satuan' => $excel['3'],
                'kode_barang' => $excel['4'],
                'no_aset' => $excel['5'],
                'tercatat' => $excel['6'],
                'kode_lokasi' => $excel['7'],
                'kode_perkap' => $excel['8'],
                'kondisi_aset' => $excel['9'],
                'uraian_aset' => $excel['10'],
                'uraian_perkap' => $excel['11'],
                'kode_ruang' => $excel['12'],
                'uraian_ruang' => $excel['13'],
                'catatan' => $excel['14'],
                'kondisi' => $excel['15'],
                'nominal_aset' => $excel['16'],
                'foto' => $excel['17'],
                'tanggal_pengadaan' => $excel['18'],
                'sumber_pengadaan' => $excel['19'],
                'qr_code' => $excel['20'],
            ];
            $this->db->table('barang')->insert($data);
        }

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil diimport!</div>');

        return redirect()->to('/aset');
    }

    public function templateexcel()
    {
        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nomor')
            ->setCellValue('B1', 'Sub Nomor')
            ->setCellValue('C1', 'Satuan')
            ->setCellValue('D1', 'Kode Barang')
            ->setCellValue('E1', 'No Aset')
            ->setCellValue('F1', 'Tercatat')
            ->setCellValue('G1', 'Kode Lokasi')
            ->setCellValue('H1', 'Kode Perkap')
            ->setCellValue('I1', 'Kondisi Aset')
            ->setCellValue('J1', 'Uraian Aset')
            ->setCellValue('K1', 'Uraian Perkap')
            ->setCellValue('L1', 'Kode Ruang')
            ->setCellValue('M1', 'Uraian Ruang')
            ->setCellValue('N1', 'Catatan')
            ->setCellValue('O1', 'Kondisi')
            ->setCellValue('P1', 'Nominal Aset')
            ->setCellValue('Q1', 'Foto Aset')
            ->setCellValue('R1', 'Tanggal Pengadaan')
            ->setCellValue('S1', 'Sumber Pengadaan');

        // tulis dalam format .xlsx
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Template Data Barang/aset';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
