<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('name', 'surname', 'email', 'phone', 'city', 'created_at')->get();
    }

    /**
     * Возвращение заголовков столбцов
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Имя',
            'Фамилия',
            'Почта',
            'Телефон',
            'Город',
            'Дата регистрации'
        ];
    }

    /**
     * Стилизация заголовков
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Преобразование данных перед их экспортом
     *
     * @param mixed $user
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->surname,
            $row->email,
            $row->phone,
            $row->city,
            $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : null, // Форматирование даты и времени
        ];
    }
}


