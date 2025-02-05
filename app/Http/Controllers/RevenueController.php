<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

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
            'warehouse' => 'required|exists:warehouses,id',
            'file' => 'required|file|mimes:xlsx,csv',
            'company' => 'required|string|max:255',
        ]);

        // Faylni olish
        $file = $request->file('file');

        // Fayl kengaytmasini tekshirish
        $fileType = $file->getClientOriginalExtension();
        if (!in_array($fileType, ['xlsx', 'csv'])) {
            return back()->withErrors(['file' => 'Fayl faqat xlsx yoki csv formatida bo\'lishi kerak.']);
        }

        // Fayl manzilini olish
        $filePath = $file->getPathname();

        // Fayl mavjudligini tekshirish
        if (!file_exists($filePath)) {
            return back()->withErrors(['file' => 'Fayl topilmadi.']);
        }

        // Faylni o'qish
        try {
            $rows = SimpleExcelReader::create($filePath)->getRows();
            // Faylni to'liq o'qib chiqish
            dd($rows->toArray());
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Faylni o\'qishda xatolik yuz berdi: ' . $e->getMessage()]);
        }
    }
}
