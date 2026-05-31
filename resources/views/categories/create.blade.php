@extends('layouts.layout')

@section('title', 'Pridėti kategoriją')

@section('content')
<div class="container mt-4">
    <h2>Pridėti naują kategoriją</h2>
    
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Kategorijos pavadinimas</label>
            <input type="text" name="name" class="form-control" required placeholder="Pvz.: Maistas, Kuras, Atlyginimas">
        </div>

        <div class="mb-3">
            <label class="form-label">Tipas</label>
            <select name="type" class="form-control" required>
                <option value="expense">Išlaidos</option>
                <option value="income">Pajamos</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Išsaugoti</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Atšaukti</a>
    </form>
</div>
@endsection