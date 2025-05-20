<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements FromArray, WithHeadings
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function array(): array
    {
        return $this->items;
    }

    public function headings(): array
    {
        return [
            'Warranty Code',
            'Serial Number',
            'Customer',
            'SO Number',
            'PO Number',
            'Unit',
            'Delivery Date',
            'Installed Date',
            'Handover Date',
            'Expired Date',
        ];
    }
}
