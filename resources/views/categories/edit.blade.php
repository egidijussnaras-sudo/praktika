@extends('layouts.layout')

@section('title', 'Redaguoti kategoriją')

@section('content')
<div class="container mt-4">
    <h2>Redaguoti kategoriją</h2>
    
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Kategorijos pavadinimas</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipas</label>
            <select name="type" class="form-control" required>
                <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Išlaidos</option>
                <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Pajamos</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atnaujinti</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Atšaukti</a>
    </form>
</div>
@endsection