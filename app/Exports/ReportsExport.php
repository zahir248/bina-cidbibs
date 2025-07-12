<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportsExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    protected $data;
    protected $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function array(): array
    {
        $rows = [];

        // Summary Section
        $rows[] = ['Summary Statistics'];
        $rows[] = ['Total Stock', $this->data['total_stock']];
        $rows[] = ['Total Sold', $this->data['total_sold']];
        $rows[] = ['Total Sales', 'RM ' . number_format($this->data['total_revenue'], 2)];
        $rows[] = [];  // Empty row for spacing

        // Ticket Type Statistics
        $rows[] = ['Ticket Type Statistics'];
        $rows[] = ['Ticket Type', 'Stock', 'Sold', 'Total Sales'];
        
        $totalSales = 0;
        foreach ($this->data['ticket_types'] as $ticket) {
            $rows[] = [
                $ticket['name'],
                $ticket['stock'],
                $ticket['sold'],
                'RM ' . number_format($ticket['total_sales'], 2)
            ];
            $totalSales += $ticket['total_sales'];
        }
        
        // Add total row
        $rows[] = [
            'Total',
            '',
            '',
            'RM ' . number_format($totalSales, 2)
        ];
        
        $rows[] = [];  // Empty row for spacing

        // Monthly Sales
        if (isset($this->data['monthly_sales']) && !empty($this->data['monthly_sales'])) {
            $rows[] = ['Monthly Sales'];
            $rows[] = ['Date', 'Total Sales'];
            foreach ($this->data['monthly_sales'] as $sale) {
                $rows[] = [
                    $sale['date'],
                    'RM ' . number_format($sale['total'], 2)
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [];  // We handle headers in the array() method for better formatting
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        // Style for all cells
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 11
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Find and style all section headers
        for ($row = 1; $row <= $lastRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();
            if (in_array($cellValue, ['Summary Statistics', 'Ticket Type Statistics', 'Monthly Sales'])) {
                $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E8E8E8'
                        ]
                    ]
                ]);
            }
        }

        // Style the table headers
        foreach (['B2:B4', 'A7:D7', 'A' . ($lastRow - 1) . ':B' . ($lastRow - 1)] as $range) {
            $sheet->getStyle($range)->applyFromArray([
                'font' => [
                    'bold' => true
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'F4F4F4'
                    ]
                ]
            ]);
        }

        // Style the totals row in ticket type statistics
        $totalRow = null;
        for ($row = 1; $row <= $lastRow; $row++) {
            if ($sheet->getCell('A' . $row)->getValue() === 'Total') {
                $totalRow = $row;
                break;
            }
        }
        if ($totalRow) {
            $sheet->getStyle('A' . $totalRow . ':' . $lastColumn . $totalRow)->applyFromArray([
                'font' => [
                    'bold' => true
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'F4F4F4'
                    ]
                ]
            ]);
        }

        // Add borders to all cells with content
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Auto-size columns
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $sheet;
    }

    public function title(): string
    {
        return 'Report';
    }
} 