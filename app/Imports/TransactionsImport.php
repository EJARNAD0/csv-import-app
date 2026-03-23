<?php

namespace App\Imports;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TransactionsImport implements SkipsOnError, ToModel, WithHeadingRow, WithValidation
{
    use SkipsErrors;

    private $rowCount = 0;

    public function model(array $row)
    {
        Log::info('Processing row: '.json_encode($row));

        // Check if the row is effectively empty (at least one of date, description, or amount should be present)
        if (empty(array_filter([
            $row['date'] ?? null,
            $row['description'] ?? null,
            $row['amount'] ?? null,
        ]))) {
            Log::info('Empty row found, skipping: '.json_encode($row));

            return null;
        }

        // Check for duplicates based on date, description, and amount
        $existing = Transaction::where('date', $row['date'] ?? null)
            ->where('description', $row['description'] ?? null)
            ->where('amount', $row['amount'] ?? null)
            ->first();

        if ($existing) {
            Log::info('Duplicate transaction found, skipping: '.json_encode($row));

            return null; // Skip duplicate
        }

        $transaction = new Transaction([
            'date' => $row['date'] ?? null,
            'description' => $row['description'] ?? null,
            'amount' => $row['amount'] ?? null,
            'business' => $row['business'] ?? null,
            'category' => $row['category'] ?? null,
            'transaction_type' => $row['transaction_type'] ?? null,
            'source' => $row['source'] ?? null,
            'status' => $row['status'] ?? null,
        ]);

        $this->rowCount++;
        Log::info('Created transaction: '.$transaction->description);

        return $transaction;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function rules(): array
    {
        return [
            // Add validation rules for your fields if needed
        ];
    }
}
