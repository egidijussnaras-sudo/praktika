@extends('layouts.layout')

@section('title', 'Finansų Apskaita')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h2>Asmeninių finansų apskaita</h2>
            <div>
                <a href="{{ route('transactions.create') }}" class="btn btn-success">Pridėti įrašą</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Pajamos</h5>
                    <h3 class="card-text">+{{ number_format($totalIncome, 2) }} €</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Išlaidos</h5>
                    <h3 class="card-text">-{{ number_format($totalExpense, 2) }} €</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card {{ $balance >= 0 ? 'bg-primary' : 'bg-warning text-dark' }} text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Realus Likutis</h5>
                    <h3 class="card-text">{{ number_format($balance, 2) }} €</h3>
                </div>
            </div>
        </div>
    </div>
    
<div class="card mb-3">
        <div class="card-body bg-light d-flex align-items-center justify-content-between py-2">
            <span class="text-muted fw-bold">Filtruoti įrašus:</span>
            <div class="btn-group">
                <a href="{{ route('transactions.index') }}" class="btn btn-sm {{ request('type') == '' ? 'btn-dark' : 'btn-outline-dark' }}">Visi</a>
                <a href="{{ route('transactions.index', ['type' => 'income']) }}" class="btn btn-sm {{ request('type') == 'income' ? 'btn-success' : 'btn-outline-success' }}">Tik pajamos</a>
                <a href="{{ route('transactions.index', ['type' => 'expense']) }}" class="btn btn-sm {{ request('type') == 'expense' ? 'btn-danger' : 'btn-outline-danger' }}">Tik išlaidos</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">Paskutinės operacijos</div>
    <div class="card">
        <div class="card-header bg-dark text-white">Paskutinės operacijos</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Kategorija</th>
                        <th>Komentaras</th>
                        <th>Suma</th>
                        <th>Veiksmai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->category->name ?? 'Nėra kategorijos' }}</td>
                            <td>{{ $transaction->description ?? '-' }}</td>
                            <td>
                                <strong class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} €
                                </strong>
                            </td>
                            <td>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Ar tikrai norite ištrinti įrašą?')">Ištrinti</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Operacijų dar nėra. Pridėkite pirmąjį įrašą!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection