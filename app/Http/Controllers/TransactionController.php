<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // 1. Rodyti visų operacijų sąrašą ir bendrą likutį
    public function index()
    {
        $userId = Auth::id();

        // Pasiimame tik šio prisijungusio vartotojo operacijas (su kategorijų informacija)
        $transactions = Transaction::where('user_id', $userId)
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();

        // Skaičiuojame sumas
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    // 2. Rodyti naujos operacijos pridėjimo formą
    public function create()
    {
        // Pasiimame visas kategorijas, kad vartotojas galėtų pasirinkti iš sąrašo
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    // 3. Išsaugoti naują operaciją į DB
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        // Surandame kategoriją, kad sužinotume jos tipą (income/expense)
        $category = Category::findOrFail($request->category_id);

        Transaction::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $category->type, // Automatiškai paimame tipą iš pasirinktos kategorijos
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Įrašas sėkmingai pridėtas!');
    }

    // 4. Pašalinti operaciją
    public function destroy(Transaction $transaction)
    {
        // Saugumas: leidžiame trinti tik savo įrašus
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Įrašas ištrintas!');
    }
}