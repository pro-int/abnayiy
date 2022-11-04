<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;


class GuardianDebtDetailsExport extends DefaultValueBinder implements FromCollection, ShouldAutoSize, WithCustomValueBinder, WithEvents, WithHeadings, WithMapping, WithStyles
{
    public $transactions;
    public $debt;
    public $students;
    public $student_id;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($transactions, $debt, $students, $student_id = null)
    {
        $this->transactions = $transactions;
        $this->debt = $debt;
        $this->students = $students;
        $this->student_id = $student_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return $this->transactions->get();
    }


    public function map($item): array
    {
        return [
            $item->id,
            $item->student_id,
            $item->installment_name,
            $item->student_name,
            $item->national_id,
            $item->amount_after_discount,
            $item->vat_amount,
            $item->amount_after_discount + $item->vat_amount,
            $item->paid_amount,
            $item->residual_amount,
            $item->debt_year_name,
            $item->year_name,
            $item->created_at,
            $item->phone,
            $item->email,
            $item->guardian_id,
            $item->contract_id,
        ];
    }

    public function headings(): array
    {
        return [
            'كود الدفعة',
            'كود الطالب',
            'الدفعة',
            'اسم الطالب',
            'هوية الطاب',
            'بعد الخثم',
            'الضرائب',
            'الاجمالي ',
            'مدفوع',
            'المتبقي',
            'مديونية عام',
            'مرحلة الي',
            'تاريخ الترحيل',
            'الجوال',
            'البريد',
            'كود ولي الأمر',
            'كود التعاقد',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true] , 'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => '808080'],
            ]],

            // Styling a specific cell by coordinate.
            'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }


    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}
