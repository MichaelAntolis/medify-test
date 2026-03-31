<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasterItemsExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    private int $rowNumber = 0;

    public function collection()
    {
        return MasterItem::with('kategoriItems')->orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Items',
            'Nama Supplier',
            'Harga',
            'Laba (%)',
            'Harga Jual',
        ];
    }

    public function map($item): array
    {
        $this->rowNumber++;

        $namaKategori = $item->kategoriItems->pluck('nama')->implode(', ');
        if (empty($namaKategori)) {
            $namaKategori = '-';
        }

        $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);
        $hargaJual = round($hargaJual);

        return [
            $this->rowNumber,
            $namaKategori,
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            $hargaJual,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'    => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'    => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '343A40'],
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
