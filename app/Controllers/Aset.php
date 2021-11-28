<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\UserModel;
use Endroid\QrCode\QrCode;
use App\Controllers\BaseController;
use Endroid\QrCode\Writer\PngWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Aset extends BaseController
{
    protected $userModel;
    protected $asetModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->asetModel = new AsetModel();

        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Aset',
            'barang' => $this->asetModel->findAll(),
        ];

        return view('aset/index', $data);
    }

    public function create()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Tambah Data Aset',
            'validation' => \Config\Services::validation(),
            // 'user' => $this->userModel->where('nik', session()->get('nik'))->first(),
        ];

        return view('aset/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nomor' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Nomor Barang harus diisi!',
                    'numeric' => 'Nomor Barang harus berupa angka!'
                ]
            ],
            'sub_nomor' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Sub Nomor Barang harus diisi!',
                    'numeric' => 'Sub Nomor Barang harus berupa angka!'
                ]
            ],
            'satuan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Satuan Barang harus diisi!',
                ]
            ],
            'kode_barang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Barang harus diisi!',
                ]
            ],
            'no_aset' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Nomor Aset harus diisi!',
                    'numeric' => 'Nomor Aset harus berupa angka!'
                ]
            ],
            'tercatat' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tercatat harus diisi!',
                ]
            ],
            'kode_lokasi' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Lokasi harus diisi!',
                ]
            ],
            'kode_perkap' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Perkap harus diisi!',
                ]
            ],
            'kondisi_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kondisi Aset harus diisi!',
                ]
            ],
            'uraian_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Uraian Aset harus diisi!',
                ]
            ],
            'uraian_perkap' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Uraian Perkap harus diisi!',
                ]
            ],
            'kode_ruang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Ruang harus diisi!',
                ]
            ],
            'uraian_ruang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Uraian Ruang harus diisi!',
                ]
            ],
            'nominal_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nominal Aset harus diisi!',
                    'numeric' => 'Nominal Aset harus berupa angka!'
                ]
            ],
            'kondisi' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kondisi Barang harus diisi!',
                ]
            ],
            'catatan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Catatan harus diisi!',
                ]
            ],
            'nominal_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nominal harus diisi!',
                ]
            ],
            'sumber_pengadaan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Sumber Pengadaan harus diisi!',
                ]
            ],
            'tanggal_pengadaan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tanggal Pengadaan harus diisi!',
                ]
            ],
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

        $kode = $this->request->getVar('kode_barang');

        $writer = new PngWriter();
        $qrCode = QrCode::create($kode)->setSize(300);
        $result = $writer->write($qrCode);
        header('Content-Type: ' . $result->getMimeType());
        $result->saveToFile(FCPATH . '/img/aset/qr/' . $qrCode->getData() . '.png');

        $this->asetModel->save([
            'nomor' => $this->request->getVar('nomor'),
            'sub_nomor' => $this->request->getVar('sub_nomor'),
            'satuan' => $this->request->getVar('satuan'),
            'kode_barang' => $kode,
            'no_aset' => $this->request->getVar('no_aset'),
            'tercatat' => $this->request->getVar('tercatat'),
            'kode_lokasi' => $this->request->getVar('kode_lokasi'),
            'kode_perkap' => $this->request->getVar('kode_perkap'),
            'kondisi_aset' => $this->request->getVar('kondisi_aset'),
            'uraian_aset' => $this->request->getVar('uraian_aset'),
            'uraian_perkap' => $this->request->getVar('uraian_perkap'),
            'kode_ruang' => $this->request->getVar('kode_ruang'),
            'uraian_ruang' => $this->request->getVar('uraian_ruang'),
            'nominal_aset' => $this->request->getVar('nominal_aset'),
            'kondisi' => $this->request->getVar('kondisi'),
            'catatan' => $this->request->getVar('catatan'),
            'sumber_pengadaan' => $this->request->getVar('sumber_pengadaan'),
            'tanggal_pengadaan' => $this->request->getVar('tanggal_pengadaan'),
            'user_penginput' => session()->get('name'),
            'qr_code' => $qrCode->getData() . '.png',
            'foto' => $namaFoto,
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
            'barang' => $this->asetModel->where('kode_barang', $kode_barang)->first(),
            'user' => $this->userModel->where('name', session()->get('name'))->first(),
        ];

        return view('aset/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nomor' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Nomor Barang harus diisi!',
                    'numeric' => 'Nomor Barang harus berupa angka!'
                ]
            ],
            'sub_nomor' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Sub Nomor Barang harus diisi!',
                    'numeric' => 'Sub Nomor Barang harus berupa angka!'
                ]
            ],
            'satuan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Satuan Barang harus diisi!',
                ]
            ],
            'kode_barang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Barang harus diisi!',
                ]
            ],
            'no_aset' => [
                'rules' => 'trim|required|numeric',
                'errors' => [
                    'required' => 'Nomor Aset harus diisi!',
                    'numeric' => 'Nomor Aset harus berupa angka!'
                ]
            ],
            'tercatat' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tercatat harus diisi!',
                ]
            ],
            'kode_lokasi' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Lokasi harus diisi!',
                ]
            ],
            'kode_perkap' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Perkap harus diisi!',
                ]
            ],
            'kondisi_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kondisi Barang harus diisi!',
                ]
            ],
            'uraian_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Uraian Aset harus diisi!',
                ]
            ],
            'uraian_perkap' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Uraian Perkap harus diisi!',
                ]
            ],
            'kode_ruang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kode Ruang harus diisi!',
                ]
            ],
            'uraian_ruang' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Uraian Ruang harus diisi!',
                ]
            ],
            'nominal_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nominal Aset harus diisi!',
                    'numeric' => 'Nominal Aset harus berupa angka!'
                ]
            ],
            'kondisi' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Kondisi Barang harus diisi!',
                ]
            ],
            'catatan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Catatan harus diisi!',
                ]
            ],
            'nominal_aset' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Nominal harus diisi!',
                ]
            ],
            'sumber_pengadaan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Sumber Pengadaan harus diisi!',
                ]
            ],
            'tanggal_pengadaan' => [
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Tanggal Pengadaan harus diisi!',
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->to('/aset/edit/' . $this->request->getVar('kode_barang'))->withInput();
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

        $kode = $this->request->getVar('kode_barang');

        $writer = new PngWriter();
        $qrCode = QrCode::create($kode)->setSize(300);
        $result = $writer->write($qrCode);
        header('Content-Type: ' . $result->getMimeType());
        $result->saveToFile(FCPATH . '/img/aset/qr/' . $qrCode->getData() . '.png');

        $this->asetModel->save([
            'id' => $id,
            'nomor' => $this->request->getVar('nomor'),
            'sub_nomor' => $this->request->getVar('sub_nomor'),
            'satuan' => $this->request->getVar('satuan'),
            'kode_barang' => $kode,
            'no_aset' => $this->request->getVar('no_aset'),
            'tercatat' => $this->request->getVar('tercatat'),
            'kode_lokasi' => $this->request->getVar('kode_lokasi'),
            'kode_perkap' => $this->request->getVar('kode_perkap'),
            'kondisi_aset' => $this->request->getVar('kondisi_aset'),
            'uraian_aset' => $this->request->getVar('uraian_aset'),
            'uraian_perkap' => $this->request->getVar('uraian_perkap'),
            'kode_ruang' => $this->request->getVar('kode_ruang'),
            'uraian_ruang' => $this->request->getVar('uraian_ruang'),
            'nominal_aset' => $this->request->getVar('nominal_aset'),
            'kondisi' => $this->request->getVar('kondisi'),
            'catatan' => $this->request->getVar('catatan'),
            'sumber_pengadaan' => $this->request->getVar('sumber_pengadaan'),
            'tanggal_pengadaan' => $this->request->getVar('tanggal_pengadaan'),
            'user_penginput' => session()->get('name'),
            'qr_code' => $qrCode->getData() . '.png',
            'foto' => $namaFoto,
        ]);

        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil diubah!</div>');

        return redirect()->to('/aset');
    }

    public function delete($id)
    {
        $this->asetModel->delete($id);
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil dihapus!</div>');
        return redirect()->to('/aset');
    }

    public function trash()
    {
        if (session('role') == 3) {
            return redirect()->to('home');
        }

        $data = [
            'title' => 'Sampah Aset',
            'barang' => $this->asetModel->onlyDeleted()->findAll(),
        ];

        return view('aset/trash', $data);
    }

    public function restore($kode)
    {
        $builder = $this->db->table('barang');
        $builder->set('deleted_at', null, true)->where(['id' => $kode])->update();
        session()->setFlashdata('message', '<div class="alert alert-success">Data <strong>aset</strong> berhasil direstore!</div>');
        return redirect()->to('/aset');
    }

    public function destroy($kode)
    {
        $barang = $this->db->table('barang')->get()->getRowArray();

        if ($barang['foto'] != 'default.jpg') {
            unlink('img/aset/' . $barang['foto']);
        }

        if ($barang['qr_code'] || $barang['qr_code'] == null) {
            unlink('img/aset/qr/' . $barang['qr_code']);
        }

        $builder = $this->db->table('barang');
        $builder->delete(['kode_barang' => $kode]);
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
