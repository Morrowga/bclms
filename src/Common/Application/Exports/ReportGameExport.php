<?php
namespace Src\Common\Application\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportGameExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Gender',
            'Accessbility Devices Used',
            'Game Name',
            'Score',
            'Accuracy',
            'Duration'
        ];
    }
}
