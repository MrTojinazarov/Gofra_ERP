<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\Material;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductComponent extends Component
{
    use WithFileUploads;

    public $products, $name, $image, $materials = [], $product_id;
    public $modalOpen = false;

    public function mount()
    {
        $this->products = Product::with('product_materials.material')->get();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
    }

    private function resetFields()
    {
        $this->product_id = null;
        $this->name = '';
        $this->image = null;
        $this->materials = [];
    }


    public function addMaterial()
    {
        $this->materials[] = ['material_id' => '', 'value' => '', 'unit' => 'kg'];
    }

    public function removeMaterial($index)
    {
        unset($this->materials[$index]);
        $this->materials = array_values($this->materials);
    }

    public function saveProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.value' => 'required|numeric|min:0.1',
        ]);

        $imagePath = $this->image ? $this->image->store('products', 'public') : null;

        $product = Product::updateOrCreate(
            ['id' => $this->product_id],
            ['name' => $this->name, 'image' => $imagePath]
        );

        foreach ($this->materials as $mat) {
            ProductMaterial::updateOrCreate(
                ['product_id' => $product->id, 'material_id' => $mat['material_id']],
                ['value' => $mat['value'], 'unit' => $mat['unit'], 'warehouse_id' => 1]
            );
        }

        $this->mount();
        $this->closeModal();
    }

    public function editProduct($id)
    {
        $product = Product::with('product_materials')->findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->image = $product->image;
        $this->materials = $product->product_materials->map(function ($mat) {
            return ['material_id' => $mat->material_id, 'value' => $mat->value, 'unit' => $mat->unit];
        })->toArray();

        $this->modalOpen = true;
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        $this->mount();
    }

    public function render()
    {
        return view('manufacturer.product-component', ['materialsList' => Material::all()]);
    }
}
