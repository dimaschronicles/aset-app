<?php

namespace App\Controllers;

use TCPDF;
use App\Models\AsetModel;
use App\Controllers\BaseController;
use App\Models\AsetKeluarModel;
use App\Models\AsetMasukModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Report extends BaseController
{
    public function __construct()
    {
        $this->aset = new AsetModel();
        $this->asetMasuk = new AsetMasukModel();
        $this->asetKeluar = new AsetKeluarModel();
    }

    public function index()
    {
        $tgl_dari = $this->request->getGet('tanggal_dari');
        $tgl_sampai = $this->request->getGet('tanggal_sampai');
        $jenis = $this->request->getGet('jenis');

        if (empty($tgl_dari) || empty($tgl_sampai)) {
            $aset = '';
        } else {
            if ($jenis == 'Aset Masuk') {
                $aset = $this->asetMasuk->getAsetMasukByDate($tgl_dari, $tgl_sampai);
                $tgl_dari = $tgl_dari;
                $tgl_sampai = $tgl_sampai;
            } elseif ($jenis == 'Aset Keluar') {
                $aset = $this->asetKeluar->getAsetKeluarByDate($tgl_dari, $tgl_sampai);
                $tgl_dari = $tgl_dari;
                $tgl_sampai = $tgl_sampai;
            }
        }

        $data = [
            'title' => 'Laporan Data Aset',
            'barang' => $this->aset->getAllAset(),
            'aset' => $aset,
            'jenis' => $jenis,
            // 'gedung' => $this->aset->getGedung(),
            // 'ruangan' => $this->aset->getRuangan(),
            // 'gedung_selected' => '',
            // 'ruangan_selected' => '',
        ];

        return view('laporan/index', $data);
    }

    public function asetPdf()
    {
        $data = [
            'aset' => $this->aset->getAllAset(),
        ];

        $html = view('laporan/asetpdf', $data);

        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Pengelola PT. Satria Dirgantara');
        $pdf->SetTitle('Data Aset');
        $pdf->SetSubject('Skripsi');
        $pdf->SetKeywords('Laporan, PDF, Skripsi');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // ---------------------------------------------------------

        // add a page
        $pdf->AddPage();

        // print a block of text using Write()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('data-aset-' . date('Ymd') . '.pdf', 'I');
    }

    public function asetQr()
    {
        $data = [
            'aset' => $this->aset->getAllAset(),
        ];

        $html = view('laporan/asetqr', $data);

        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Pengelola PT. Satria Dirgantara');
        $pdf->SetTitle('Data Aset');
        $pdf->SetSubject('Skripsi');
        $pdf->SetKeywords('Laporan, PDF, Skripsi');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // ---------------------------------------------------------

        // add a page
        $pdf->AddPage();

        // print a block of text using Write()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('qr-aset-' . date('Ymd') . '.pdf', 'I');
    }

    public function printPdf()
    {
        $tgl_dari = $this->request->getGet('tanggal_dari');
        $tgl_sampai = $this->request->getGet('tanggal_sampai');
        $jenis = $this->request->getGet('jenis');

        if (empty($tgl_dari) || empty($tgl_sampai)) {
            $aset = '';
        } else {
            if ($jenis == 'Aset Masuk') {
                $aset = $this->asetMasuk->getAsetMasukByDate($tgl_dari, $tgl_sampai);
                $tgl_dari = $tgl_dari;
                $tgl_sampai = $tgl_sampai;
                $nama_file = 'aset-masuk-' . date('Ymd');
            } elseif ($jenis == 'Aset Keluar') {
                $aset = $this->asetKeluar->getAsetKeluarByDate($tgl_dari, $tgl_sampai);
                $tgl_dari = $tgl_dari;
                $tgl_sampai = $tgl_sampai;
                $nama_file = 'aset-keluar-' . date('Ymd');
            }
        }

        $data = [
            'title' => 'Laporan Data Aset',
            'barang' => $this->aset->getAllAset(),
            'aset' => $aset,
            'jenis' => $jenis,
        ];

        $html = view('laporan/pdf', $data);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Data Pemasukan');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/img/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetFont('times', 12);

        // add a page
        $pdf->AddPage();

        // set some text to print

        $pdf->writeHTML($html);

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output($nama_file . '.pdf', 'I');
    }

    public function asetExcel()
    {
        $dataBarang =  $this->aset->getAllAset();

        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Kode Aset')
            ->setCellValue('C1', 'Nama Aset')
            ->setCellValue('D1', 'Kategori')
            ->setCellValue('E1', 'Satuan')
            ->setCellValue('F1', 'Kondisi')
            ->setCellValue('G1', 'Gedung')
            ->setCellValue('H1', 'Ruangan')
            ->setCellValue('I1', 'Jumlah')
            ->setCellValue('J1', 'Nilai Aset')
            ->setCellValue('K1', 'Total Aset')
            ->setCellValue('L1', 'Supplier')
            ->setCellValue('M1', 'Keterangan')
            ->setCellValue('N1', 'Penginput');

        $column = 2;
        $i = 1;
        // tulis data mobil ke cell
        foreach ($dataBarang as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $i++)
                ->setCellValue('B' . $column, $data['kode_aset'])
                ->setCellValue('C' . $column, $data['nama_barang'])
                ->setCellValue('D' . $column, $data['nama_kategori'])
                ->setCellValue('E' . $column, $data['satuan'])
                ->setCellValue('F' . $column, $data['kondisi'])
                ->setCellValue('G' . $column, $data['nama_gedung'])
                ->setCellValue('H' . $column, $data['nama_ruangan'])
                ->setCellValue('I' . $column, $data['jumlah'])
                ->setCellValue('J' . $column, $data['nilai_aset'])
                ->setCellValue('K' . $column, $data['total_aset'])
                ->setCellValue('L' . $column, $data['nama'])
                ->setCellValue('M' . $column, $data['keterangan'])
                ->setCellValue('N' . $column, $data['user_penginput']);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'data-aset-' . date('Ymd');

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function downloadAllPdf()
    {
        $aset = $this->aset->getAllAset();

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PT. Satria Dirgantara');
        $pdf->SetTitle('Laporan Aset');
        $pdf->SetSubject('PDF');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $html = '<!DOCTYPE html>
        <html lang="en">
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <head>
            <meta charset="UTF-8">
            <title>Laporan Aset</title>
            <style>
                h1 {
                    text-align: center;
                    font-family: sans-serif;
                }
            </style>
        </head>

        <body>
            <h1>PT. SATRIA DIRGANTARA</h1>
            <hr>
            <h3>Data Aset</h3>
            <div style="overflow-x:auto;">
            <table border="1" align="center" cellpadding="10" cellspacing="0">
                <tr>
                    <th><b>No</b></th>
                    <th><b>Nama Aset</b></th>
                    <th><b>Satuan</b></th>
                    <th><b>Gedung</b></th>
                    <th><b>Ruangan</b></th>
                    <th><b>Jumlah</b></th>
                    <th><b>Nilai Aset</b></th>
                    <th><b>Total Aset</b></th>
                </tr>
        ';

        $i = 1;
        foreach ($aset as $a) {
            $html .= '
                <tr>
                    <td>' . $i++ . '</td>
                    <td>' . $a['nama_barang'] . '</td>
                    <td>' . $a['satuan'] . '</td>
                    <td>' . $a['nama_gedung'] . '</td>
                    <td>' . $a['nama_ruangan'] . '</td>
                    <td>' . $a['jumlah'] . '</td>
                    <td>' . $a['nilai_aset'] . '</td>
                    <td>' . $a['total_aset'] . '</td>
                </tr>
            ';
        }

        $html .= '
                </table>
                </div>
        </body>
        </html>
        ';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->lastPage();

        $this->response->setContentType('application/pdf');

        $pdf->Output('data_aset.pdf', 'I');
    }
}
