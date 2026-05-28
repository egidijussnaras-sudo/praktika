<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\City;

class StudentController extends Controller
{
    // Display all students with cities (index)
    public function index()
    {
        $students = Student::with('city')->paginate(20);
        return view('students.index', compact('students'));
    }

    // Displaying the form to create a new student
    public function create()
    {
        $cities = City::all();
        return view('students.create', compact('cities'));
    }

    // Registering a new student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'city_id' => 'required|exists:cities,id',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Student added!');
    }

    // Edit form
    public function edit(Student $student)
    {
        $cities = City::all();
        return view('students.edit', compact('student', 'cities'));
    }

   // Update student data
    public function update(Request $request, Student $student)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'address' => 'required|string',
        'phone' => 'required|string|max:20',
        'city_id' => 'required|exists:cities,id',
    ]);

    // Update student data
    $student->update($request->only(['name', 'surname', 'address', 'phone', 'city_id']));

    // Redirect to student list
    return redirect()->route('students.index')->with('success', 'Student updated!');
}

    // Delete the student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted!');
    }
}
