<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
// 1. Rodyti visų operacijų sąrašą su filtravimu ir bendrą likutį
    public function index(Request $request)
    {
        $userId = Auth::id();
        $filter = $request->query('type'); // Pasiimame filtrą iš adreso (pvz., ?type=income)

        // Pradinė užklausa: tik šio vartotojo įrašai
        $query = Transaction::where('user_id', $userId)->with('category');

        // Jei pasirinktas konkretus filtras, pritaikome jį sąrašui
        if (in_array($filter, ['income', 'expense'])) {
            $query->where('type', $filter);
        }

        $transactions = $query->orderBy('date', 'desc')->get();

        // Suminiai skaičiavimai visada lieka bendri (nepriklauso nuo filtro)
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance', 'filter'));
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

    // 5. Generuoti finansinę ataskaitą pagal 3 pjūvius (Kategorijos, Periodas, Analizė)
    public function report()
    {
        $userId = Auth::id();

        // 1 PJŪVIS: Suminė ataskaita pagal kategorijas
        // Sugrupuojame vartotojo operacijas pagal kategorijos pavadinimą ir tipą, bei susumuojame sumas
        $categoriesData = Transaction::where('transactions.user_id', $userId)
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, categories.type as category_type, SUM(transactions.amount) as total_amount')
            ->groupBy('categories.name', 'categories.type')
            ->get();

        // 2 PJŪVIS: Periodo ataskaita (Einamojo mėnesio statistika)
        $currentMonthCount = Transaction::where('user_id', $userId)
            ->whereMonth('date', date('m'))
            ->whereYear('date', date('Y'))
            ->count();

        $currentMonthSum = Transaction::where('user_id', $userId)
            ->whereMonth('date', date('m'))
            ->whereYear('date', date('Y'))
            ->where('type', 'expense')
            ->sum('amount');

        // 3 PJŪVIS: Finansinė analizė (Max, Min, Vidurkis) tik išlaidoms
        $expenseQuery = Transaction::where('user_id', $userId)->where('type', 'expense');
        
        $maxExpense = $expenseQuery->max('amount') ?? 0;
        $minExpense = $expenseQuery->min('amount') ?? 0;
        $avgExpense = $expenseQuery->avg('amount') ?? 0;

        return view('transactions.report', compact(
            'categoriesData', 
            'currentMonthCount', 
            'currentMonthSum', 
            'maxExpense', 
            'minExpense', 
            'avgExpense'
        ));
    }

}