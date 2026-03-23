<?php

namespace App\Http\Controllers;

use App\Imports\TransactionsImport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->search) {
            $query->where('description', 'like', "%{$request->search}%")
                ->orWhere('business', 'like', "%{$request->search}%")
                ->orWhere('category', 'like', "%{$request->search}%");
        }

        $transactions = $query->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function upload(Request $request)
    {
        Log::info('Upload method called', [
            'has_file' => $request->hasFile('file'),
            'all_files' => $request->allFiles(),
            'all_data' => $request->all(),
        ]);

        $request->validate([
            'file' => 'required|file',
        ]);

        Log::info('Validation passed');

        $file = $request->file('file');

        Log::info('File info', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $file->getPathname(),
        ]);

        if ($file->getSize() == 0) {
            Log::info('File is empty');

            return back()->withErrors(['file' => 'File is empty']);
        }

        Log::info('File size: '.$file->getSize());

        try {
            Log::info('Starting Excel import');
            $import = new TransactionsImport;
            Excel::import($import, $file);

            // Check if any rows were actually imported
            if ($import->getRowCount() == 0) {
                return back()->withErrors(['file' => 'No valid data found in the CSV file.']);
            }

            Log::info('Excel import completed, rows imported: '.$import->getRowCount());
        } catch (\Exception $e) {
            Log::error('Import error: '.$e->getMessage());

            return back()->withErrors(['file' => 'Error processing file: '.$e->getMessage()]);
        }

        return back()->with('success', 'CSV uploaded successfully! '.$import->getRowCount().' transactions imported.');
    }
}
