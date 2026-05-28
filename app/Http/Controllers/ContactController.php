<?php
namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ContactController extends Controller
{
public function index()
{
$contacts = Contact::all();
return view('contacts.index', compact('contacts'));
}
public function create()
{
return view('contacts.create');
}
public function store(Request $request)
{
$request->validate([
    'name' => 'required|string|min:2|max:255',
    'phone' => 'required|string|min:10|max:50',
]);
Contact::create($request->only('name', 'phone'));
return redirect()->route('contacts.index')->with('success', 'Contact added successfully!');
}
}
