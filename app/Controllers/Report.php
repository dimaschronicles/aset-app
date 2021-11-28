<?php

namespace App\Controllers;

use TCPDF;
use App\Models\AsetModel;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Report extends BaseController
{
    protected $asetModel;

    public function __construct()
    {
        $this->asetModel = new AsetModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Aset',
            'barang' => $this->asetModel->findAll(),
        ];

        return view('laporan/index', $data);
    }

    public function exportExcel()
    {
        $dataBarang =  $this->asetModel->findAll();

        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nomor')
            ->setCellValue('C1', 'Sub Nomor')
            ->setCellValue('D1', 'Satuan')
            ->setCellValue('E1', 'Kode Barang')
            ->setCellValue('F1', 'No Aset')
            ->setCellValue('G1', 'Tercatat')
            ->setCellValue('H1', 'Kode Lokasi')
            ->setCellValue('I1', 'Kode Perkap')
            ->setCellValue('J1', 'Kondisi Aset')
            ->setCellValue('K1', 'Uraian Aset')
            ->setCellValue('L1', 'Uraian Perkap')
            ->setCellValue('M1', 'Kode Ruang')
            ->setCellValue('N1', 'Uraian Ruang')
            ->setCellValue('O1', 'Catatan')
            ->setCellValue('P1', 'Kondisi')
            ->setCellValue('Q1', 'Nominal Aset')
            ->setCellValue('R1', 'Foto Aset')
            ->setCellValue('S1', 'Tanggal Pengadaan')
            ->setCellValue('T1', 'Sumber Pengadaan')
            ->setCellValue('U1', 'QR Code')
            ->setCellValue('V1', 'User Penginput');

        $column = 2;
        $i = 1;
        // tulis data mobil ke cell
        foreach ($dataBarang as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $i++)
                ->setCellValue('B' . $column, $data['nomor'])
                ->setCellValue('C' . $column, $data['sub_nomor'])
                ->setCellValue('D' . $column, $data['satuan'])
                ->setCellValue('E' . $column, $data['kode_barang'])
                ->setCellValue('F' . $column, $data['no_aset'])
                ->setCellValue('G' . $column, $data['tercatat'])
                ->setCellValue('H' . $column, $data['kode_lokasi'])
                ->setCellValue('I' . $column, $data['kode_perkap'])
                ->setCellValue('J' . $column, $data['kondisi_aset'])
                ->setCellValue('K' . $column, $data['uraian_aset'])
                ->setCellValue('L' . $column, $data['uraian_perkap'])
                ->setCellValue('M' . $column, $data['kode_ruang'])
                ->setCellValue('N' . $column, $data['uraian_ruang'])
                ->setCellValue('O' . $column, $data['catatan'])
                ->setCellValue('P' . $column, $data['kondisi'])
                ->setCellValue('Q' . $column, $data['nominal_aset'])
                ->setCellValue('R' . $column, $data['foto'])
                ->setCellValue('S' . $column, $data['tanggal_pengadaan'])
                ->setCellValue('T' . $column, $data['sumber_pengadaan'])
                ->setCellValue('U' . $column, $data['qr_code'])
                ->setCellValue('V' . $column, $data['user_penginput']);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Data Barang';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function downloadAllPdf()
    {
        $barang = $this->asetModel->findAll();

        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

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
            <h3>Daftar Aset</h3>
            <div style="overflow-x:auto;">
            <table border="1" align="center" cellpadding="10" cellspacing="0">
                <tr>
                    <th style="width:7%;"><b>No</b></th>
                    <th><b>Kode Aset</b></th>
                    <th><b>Kode Lokasi</b></th>
                    <th><b>Kode Ruang</b></th>
                    <th><b>Kondisi Aset</b></th>
                    <th><b>Sumber</b></th>
                    <th><b>Tahun</b></th>
                    <th><b>QR Code</b></th>
                </tr>
        ';

        $i = 1;
        foreach ($barang as $b) {
            $image = '/img/aset/qr/' . $b['qr_code'];
            $html .= '
                <tr>
                    <td style="width:7%;">' . $i++ . '</td>
                    <td>' . $b['kode_barang'] . '</td>
                    <td>' . $b['kode_lokasi'] . '</td>
                    <td>' . $b['kode_ruang'] . '</td>
                    <td>' . $b['kondisi_aset'] . '</td>
                    <td>' . $b['sumber_pengadaan'] . '</td>
                    <td>' . $b['tanggal_pengadaan'] . '</td>
                    <td><img src="' . $image . '"  alt="qr_code" width="50" height="50" /></td>
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
