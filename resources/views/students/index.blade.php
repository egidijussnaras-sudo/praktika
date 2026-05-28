@extends('layouts.layout')

@section('title', 'List of students')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>List of students</h2>
        <a href="{{ route('students.create') }}" class="btn btn-success">Add student</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
            <th>ID</th>
<th>Vardas</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
<tbody>
            @foreach ($students as $student)
                <tr>
                     <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->surname }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->city->name }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary btn-sm">Redaguoti</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Ištrinti</button>
                        </form>
                    </td>
                </tr>
            @endforeach
</tbody>
    </table>

    {{ $students->links() }} <!-- Pagination -->
@endsection
