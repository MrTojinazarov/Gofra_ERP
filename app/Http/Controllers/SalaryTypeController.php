<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary_Type;

class SalaryTypeController extends Controller
{
    public function index()
    {
        $salary_types = Salary_Type::all();
        return view('hr.salary_types.index', compact('salary_types'));
    }

    public function create()
    {
        return view('hr.salary_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Salary_Type::create($request->all());
        return redirect()->route('salary_types.index')->with('create', 'Salary Type created successfully.');
    }

    public function edit(Salary_Type $salary_type)
    {
        return view('hr.salary_types.edit', compact('salary_type'));
    }

    public function update(Request $request, Salary_Type $salary_type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $salary_type->update($request->all());
        return redirect()->route('salary_types.index')->with('update', 'Salary Type updated successfully.');
    }

    public function destroy(Salary_Type $salary_type)
    {
        $salary_type->delete();
        return redirect()->route('salary_types.index')->with('delete', 'Salary Type deleted successfully.');
    }

    public function status(Salary_Type $salary_type)
    {
        $salary_type->status = !$salary_type->status;
        $salary_type->save();
        return redirect()->route('salary_types.index')->with('update', 'Salary Type status updated successfully!');
    }
}
