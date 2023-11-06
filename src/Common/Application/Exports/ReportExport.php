<?php
namespace Src\Common\Application\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
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
            'Age of Child',
            'Date of Birth',
            'Gender',
            'Level of Education',
            'Accessbility Devices Used',
        ];
    }
}
