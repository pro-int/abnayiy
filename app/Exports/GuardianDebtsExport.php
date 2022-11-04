<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class GuardianDebtsExport extends DefaultValueBinder implements FromCollection, ShouldAutoSize, WithCustomValueBinder, WithEvents, WithHeadings, WithMapping
{
    public $users;
    public $date_from;
    public $date_to;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($users) {
        $this->users = $users;
       
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
    // e'), 'users.phone', DB::raw('sum(transactions.residual_amount) as total_debt'), 'students.guardian_id')

        return $this->users->get();
    }


    public function map($user): array
    {
        return [
            $user->guardian_id,
            $user->guardian_name,
            $user->phone,
            $user->total_debt,
            
        ];
    }

    public function headings(): array
    {
        return [
            'كود ولي الأمر',
            'اسم ولي الأمر',
            'رقم الجوال',
            'قيمة المديونية',
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
