<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithMapping
{
    public function __construct(private $transactions)
    {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->transactions;
    }

    public function map($transaction): array
    {
        return [
            $transaction->reference,
            $transaction->amount,
            $transaction->status,
            $transaction->updated_at->toDateTimeString(),
        ];
    }
}
