<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class TransferRequestExport extends DefaultValueBinder implements FromCollection, ShouldAutoSize, WithCustomValueBinder, WithEvents, WithHeadings, WithMapping
{
    public $requestss;
    public $date_from;
    public $date_to;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($requestss) {
        $this->requestss = $requestss;
       
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
    // e'), 'requestss.phone', DB::raw('sum(transactions.residual_amount) as total_debt'), 'students.guardian_id')

        return $this->requestss->get();
    }


    public function map($requests): array
    {
        return [
            $requests->id,
            $requests->student_name . '(#' . $requests->student_id . ')',
            $requests->contract_id,
            $requests->national_id,
            $requests->phone,
            $requests->level_name,
            $requests->new_level_name,
            $requests->year_name,
            $requests->plan_name,
            $requests->tuition_fee,
            $requests->tuition_fee_vat,
            $requests->period_discount,
            $requests->minimum_tuition_fee,
            $requests->bus_fees,
            $requests->bus_fees_vat,
            $requests->total_debt,
            $requests->minimum_debt,
            $requests->dept_paid,
            $requests->total_paid,
            $requests->method_name,
            $requests->bank_name,
            $requests->getStatus(1)['status'],
            $requests->approved_by_admin,
            
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'اسم الطالب',
            'كود التعاقد',
            'هوية الطالب',
            'رقم الجوال',
            'الصف الحالي',
            'منقول الي',
            'العام الدراسي',
            'خطة السداد',
            'الرسوم الدراسية',
            'الضرائب',
            'خصم الفترة',
            'دفعة تعاقد',
            'رسوم النقل',
            'ضرائب النقل',
            'اجمالي المديونية',
            'الحد الادني',
            'مسدد من المديونية',
            'اجمالي المدفوع',
            'وسيلة السداد',
            'البنك',
            'حالة الطلب',
            'بواسطة',
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
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}
