@extends('layouts.layout')

@section('title', 'Finansinė Ataskaita')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 Finansinė analitika ir ataskaitos</h2>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Grįžti į finansus</a>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">📅 Periodo suvestinė (Šis mėnuo)</div>
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h5 class="card-title text-muted">Operacijų skaičius šį mėnesį</h5>
                    <p class="display-5 fw-bold text-primary">{{ $currentMonthCount }}</p>
                    <hr>
                    <h5 class="card-title text-muted">Iš viso išleista šį mėnesį</h5>
                    <p class="display-6 fw-bold text-danger">-{{ number_format($currentMonthSum, 2) }} €</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">🧮 Išlaidų analizė (Statistika)</div>
                <div class="card-body">
                    <table class="table table-hover mt-3">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted">Didžiausia vienkartinė išlaida (Max):</td>
                                <td class="text-end fw-bold text-danger">{{ number_format($maxExpense, 2) }} €</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Mažiausia vienkartinė išlaida (Min):</td>
                                <td class="text-end fw-bold text-warning">{{ number_format($minExpense, 2) }} €</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Vidutinė operacijos kaina (Vidurkis):</td>
                                <td class="text-end fw-bold text-info">{{ number_format($avgExpense, 2) }} €</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-info py-2 px-3 small mt-3">
                        Analizė apskaičiuojama automatiškai, remiantis visais jūsų sistemoje esančiais išlaidų įrašais.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">🗂️ Suminė apyvarta pagal kategorijas</div>
        <div class="card-body">
            @if($categoriesData->isEmpty())
                <p class="text-muted text-center py-3">Nėra jokių duomenų ataskaitai generuoti.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kategorijos pavadinimas</th>
                                <th>Tipas</th>
                                <th class="text-end">Suminė apyvarta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categoriesData as $data)
                                <tr>
                                    <td class="fw-bold">{{ $data->category_name }}</td>
                                    <td>
                                        <span class="badge {{ $data->category_type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $data->category_type == 'income' ? 'Pajamos' : 'Išlaidos' }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold {{ $data->category_type == 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ $data->category_type == 'income' ? '+' : '-' }}{{{ number_format($data->total_amount, 2) }}} €
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection