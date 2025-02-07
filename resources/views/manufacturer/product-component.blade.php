<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Products List</h3>
        <button wire:click="openModal" class="btn btn-primary btn-sm float-right">Create Product</button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" width="100">
                                @else
                                    <span>Image Not Found</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="editProduct({{ $product->id }})" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteProduct({{ $product->id }})" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    @if ($modalOpen)
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $product_id ? 'Edit Product' : 'Create Product' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control mb-2" placeholder="Product Name" wire:model="name">
                        <input type="file" class="form-control mb-2" wire:model="image">

                        <h6>Materials</h6>
                        @foreach ($materials as $index => $material)
                            <div class="d-flex gap-2 mb-2">
                                <select class="form-control" wire:model="materials.{{ $index }}.material_id">
                                    <option value="">Select Material</option>
                                    @foreach ($materialsList as $mat)
                                        <option value="{{ $mat->id }}">{{ $mat->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" class="form-control" placeholder="Value"
                                    wire:model="materials.{{ $index }}.value">
                                <button class="btn btn-danger"
                                    wire:click="removeMaterial({{ $index }})">×</button>
                            </div>
                        @endforeach

                        <button class="btn btn-secondary btn-sm" wire:click="addMaterial">+ Add Material</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="saveProduct">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
