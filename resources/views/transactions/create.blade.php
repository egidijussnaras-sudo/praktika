@extends('layouts.layout')

@section('title', 'Pridėti įrašą')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Pridėti naują finansinę operaciją</div>
                <div class="card-body">
                    
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Suma (€)</label>
                            <input type="number" name="amount" step="0.01" min="0.01" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required placeholder="0.00">
                            @error('amount')
                                <div class="invalid-feedback">Įveskite teisingą, teigiamą sumą (pvz. 10.50).</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategorija (Klasifikatorius)</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Pasirinkite kategoriją...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->type == 'income' ? 'Pajamos' : 'Išlaidos' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">Pasirinkite kategoriją iš sąrašo.</div>
                            @enderror
                            <div class="form-text">Nerandate reikiamos kategorijos? <a href="{{ route('categories.index') }}">Valdykite jas čia</a>.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">Pasirinkite teisingą datą.</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Komentaras / Aprašymas</label>
                            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="Pvz.: Parduotuvė Maxima, Atlyginimas už gegužę...">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Išsaugoti įrašą</button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Atšaukti</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection