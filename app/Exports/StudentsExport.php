<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class StudentsExport extends DefaultValueBinder implements FromView, ShouldAutoSize, WithCustomValueBinder , WithEvents//, WithDrawings, WithCustomStartCell
{
    public $students;
    public $date_from;
    public $date_to;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(
        $students,
    ) {
        $this->students = $students;
       
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return $this->students;
    }

    public function view(): View
    {

        return view('admin.student.export', [
            'students' => $this->students
        ]);
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
