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

class PaymentsExport extends DefaultValueBinder implements FromView, ShouldAutoSize, WithCustomValueBinder , WithEvents//, WithDrawings, WithCustomStartCell
{
    public $PaymentAttempts;
    public $date_from;
    public $date_to;
    public $year_name;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(
        $PaymentAttempts,
        $date_from,
        $date_to,
        $year_name
    ) {
        $this->PaymentAttempts = $PaymentAttempts;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->year_name = $year_name;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return $this->PaymentAttempts;
    }

    public function view(): View
    {
        return view('admin.accounts.export', [
            'PaymentAttempts' => $this->PaymentAttempts,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'year_name' => $this->year_name
        ]);
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
