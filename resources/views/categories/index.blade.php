@extends('layouts.layout')

@section('title', 'Kategorijų klasifikatorius')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Kategorijų klasifikatorius</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-success">Pridėti kategoriją</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pavadinimas</th>
                <th>Tipas</th>
                <th>Veiksmai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <span class="badge {{ $category->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                            {{ $category->type == 'income' ? 'Pajamos' : 'Išlaidos' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Redaguoti</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Ar tikrai norite ištrinti?')">Ištrinti</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection