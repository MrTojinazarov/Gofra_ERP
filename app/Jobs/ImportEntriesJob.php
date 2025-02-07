<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Entry;
use App\Models\EntryMaterial;
use App\Models\History;
use App\Models\Material;
use App\Models\WarehouseMaterial;
use Illuminate\Support\Str;

class ImportEntriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $warehouse_id;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $warehouse_id)
    {
        $this->filePath = $filePath;
        $this->warehouse_id = $warehouse_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = Storage::path($this->filePath);
        $rows = Excel::toCollection(new \App\Imports\EntriesImport, $file);

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

                $previousValue = WarehouseMaterial::where('warehouse_id', $this->warehouse_id)
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
                    ['warehouse_id' => $this->warehouse_id, 'product_id' => $material->id],
                    ['value' => $currentValue, 'type' => 1]
                );

                History::create([
                    'type' => 1,
                    'material_id' => $material->id,
                    'quantity' => $row[3] ?? null,
                    'was' => $previousValue,
                    'been' => $currentValue,
                    'from_id' => $entry->id,
                    'to_id' => $this->warehouse_id
                ]);
            }
        }

        Storage::delete($this->filePath);
    }
}
