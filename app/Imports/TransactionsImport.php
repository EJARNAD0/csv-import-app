<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TransactionsImport implements SkipsOnError, ToModel, WithHeadingRow, WithValidation
{
    use SkipsErrors;

    public function model(array $row)
    {
        return new Transaction([
            'date' => $row['date'] ?? null,
            'description' => $row['description'] ?? null,
            'amount' => $row['amount'] ?? null,
            'business' => $row['business'] ?? null,
            'category' => $row['category'] ?? null,
            'transaction_type' => $row['transaction_type'] ?? null,
            'source' => $row['source'] ?? null,
            'status' => $row['status'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.email' => 'required|email|unique:transactions,email',
        ];
    }
}
