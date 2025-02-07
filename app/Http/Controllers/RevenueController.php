<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Models\Entry;
use App\Models\Warehouse;
use App\Jobs\ImportEntriesJob;
use App\Models\EntryMaterial;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;

class RevenueController extends Controller
{
    public function index()
    {
        $revenues = Entry::orderBy('id', 'desc')->paginate(10);
        return view('warehouse_maneger.index', compact('revenues'));
    }

    public function show($id)
    {
        $revenue = Entry::with('entry_materials.material')->findOrFail($id);
        $materials = EntryMaterial::where('entry_id', $id)->get();
        return view('warehouse_maneger.show', compact('revenue', 'materials'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('warehouse_maneger.create', compact('warehouses'));
    }

    public function store(ImportRequest $request)
    {
        $request->validated();

        if (Warehouse::find($request->warehouse_id)->status == false) {
            return redirect()->back()->with('error', 'Warehouse is not active');
        }

        $path = $request->file('file')->store('imports');

        ImportEntriesJob::dispatch($path, $request->warehouse_id);

        return redirect()->route('revenues.index')->with('create', 'Revenue import started, it will be processed soon.');
    }

}
