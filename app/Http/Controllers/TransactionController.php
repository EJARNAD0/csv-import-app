<?php

namespace App\Http\Controllers;

use App\Imports\TransactionsImport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        $transactions = $query->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        if ($file->getSize() == 0) {
            return back()->withErrors(['file' => 'File is empty']);
        }

        try {
            Excel::import(new TransactionsImport, $file);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error processing file']);
        }

        return back()->with('success', 'CSV uploaded successfully!');
    }
}
