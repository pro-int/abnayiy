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

class CouponReportExport extends DefaultValueBinder implements FromCollection, ShouldAutoSize, WithCustomValueBinder, WithEvents, WithHeadings, WithMapping
{
    public $payments;
    public $date_from;
    public $date_to;
    public $year_name;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($payments, $date_from, $date_to, $year_name) {
        $this->payments = $payments;
        $this->date_from = $date_from;
        $this->year_name = $year_name;
        $this->date_to = $date_to;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
    // e'), 'payments.phone', DB::raw('sum(transactions.residual_amount) as total_debt'), 'students.guardian_id')

        return $this->payments;
    }


    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->installment_name,
            $payment->received_ammount,
            $payment->coupon,
            $payment->classification_name ?? 'خصومات عامة',
            $payment->coupon_value,
            $payment->coupon_discount,
            $payment->year_name,
            $payment->guardian_name,
            $payment->phone,
            $payment->admin_name,
            $payment->reference,
            $payment->created_at,
            $payment->updated_at,
            
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'اسم الدفعة',
            'قيمة الدفعة',
            'رمز القسيمة',
            'تصنيف القسيمة',
            'قيمة القسيمة',
            'قيمة الخصم الفعلي',
            'العام الدراسي',
            'ولي الأمر',
            'رقم الجوال',
            'بواسطة',
            'المرجع',
            'تاريخ الانشاء',
            'تاريخ الدفع',
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
