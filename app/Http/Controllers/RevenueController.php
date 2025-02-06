<?php

namespace App\Http\Controllers;

use App\Imports\EntriesImport;
use App\Models\Entry;
use App\Models\EntryMaterial;
use App\Models\History;
use App\Models\Material;
use App\Models\Warehouse;
use App\Models\WarehouseMaterial;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

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
        return view('warehouse_maneger.show', compact('revenue'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('warehouse_maneger.create', compact('warehouses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'file' => 'required|mimes:xlsx,csv',
        ]);
        $rows = Excel::toCollection(new EntriesImport, $request->file('file'));

        $entry = Entry::create([
            'company' => $rows[0][0][2],
            'date' => Date::excelToDateTimeObject($rows[0][1][2])->format('Y-m-d'),
            'text' => $rows[0][2][2],
        ]);

        for ($i = 4; $i <= 8; $i++) {
            $row = $rows[0][$i] ?? null;

            if (!$row || !isset($row[1])) {
                continue;
            }

            $slug = Str::slug($row[1]);

            if ($slug) {
                $material = Material::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $row[1]]
                );

                $previousValue = WarehouseMaterial::where('warehouse_id', $request->warehouse_id)
                    ->where('product_id', $material->id)
                    ->value('value') ?? 0;


                $currentValue = $previousValue + ($row[3] ?? 0);

                EntryMaterial::create([
                    'entry_id' => $entry->id,
                    'material_id' => $material->id,
                    'unit' => $row[2] ?? null,
                    'quantity' => $row[3] ?? null,
                    'price' => $row[4] ?? null,
                    'total' => (isset($row[3], $row[4]) && is_numeric($row[3]) && is_numeric($row[4]))
                        ? $row[3] * $row[4] : 0,
                ]);

                WarehouseMaterial::updateOrCreate(
                    ['warehouse_id' => $request->warehouse_id, 'product_id' => $material->id],
                    ['value' => $currentValue, 'type' => 1]
                );

                History::create([
                    'type' => 1,
                    'material_id' => $material->id,
                    'quantity' => $row[3] ?? null,
                    'was' => $previousValue,
                    'been' => $currentValue,
                    'from_id' => $entry->id,
                    'to_id' => $request->warehouse_id
                ]);
            }
        }

        return redirect()->route('revenues.index')->with('create', 'Revenue created successfully.');
    }
}
