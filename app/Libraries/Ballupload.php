<?php

namespace App\Libraries;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class Ballupload
{
    public function getData($array)
    {
        $result = [];

        $filteredData = array_filter($array, function ($row) {
            return !empty(trim($row[0] ?? ''));
        });

        foreach ($filteredData as $row) {
            $result[] = [
                'warranty_code' => $row[0],
                'unit_name' => $row[1],
                'serial_number' => $row[2],
                'customer' => $row[3],
                'po_number' => $row[4],
                'so_number' => $row[5],
                'expired_date' => $this->convertExcelDate($row[6]),
                'delivery_date' => $this->convertExcelDate($row[7]),
                'install_date' => $this->convertExcelDate($row[8]),
                'handover_date' => $this->convertExcelDate($row[9]),
            ];
        }

        return $result;
    }

    private function convertExcelDate($value)
    {
        if (is_numeric($value)) {
            try {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Jika bukan angka (mungkin sudah string tanggal)
        return date('Y-m-d', strtotime($value));
    }
}
