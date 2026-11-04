<?php

namespace App\Exports;

use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Borrowing::with(['user', 'details.tool']);
        
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }
        if ($this->request->filled('from')) {
            $query->whereDate('borrowing_date', '>=', $this->request->from);
        }
        if ($this->request->filled('to')) {
            $query->whereDate('borrowing_date', '<=', $this->request->to);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Kode', 'Peminjam', 'Kelas', 'Alat', 'Tgl Pinjam', 'Tgl Kembali', 'Status'
        ];
    }

    public function map($borrowing): array
    {
        $alat = '';
        foreach($borrowing->details as $d) {
            $alat .= $d->tool->name . ' (' . $d->quantity . 'x), ';
        }

        return [
            $borrowing->borrowing_code,
            $borrowing->user->name,
            $borrowing->user->class ?? '-',
            rtrim($alat, ', '),
            $borrowing->borrowing_date->format('d/m/Y'),
            $borrowing->return_date->format('d/m/Y'),
            $borrowing->status,
        ];
    }
}