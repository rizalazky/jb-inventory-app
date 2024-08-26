<x-app-layout>
    <x-slot name="header">   
            {{ __('STOK') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('STOK MASUK FORM') }}
                </div>
                <div class="card-body">
                    <input type="hidden" name="type" value="{{ $data->type }}">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select id="product_id" name="product_id" class="form-control" value="{{ $data->product_id }}" disabled>
                            <option value="{{ $data->product_id }}" selected="selected">{{ $data->product->name }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product_price_id" class="form-label">Satuan</label>
                        <select id="product_price_id" name="product_price_id" class="form-control">
                            @foreach($data->product->productprices as $proprice)
                                <option value="{{ $proprice->id }}" @selected($data->product_price_id == $proprice->id)>{{ $proprice->productunit->name }} {{ $proprice->is_default ? ' - DEFAULT' : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ $data->quantity }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Catatan</label>
                       <textarea name="notes" id="notes" class="form-control">{{ $data->notes }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    @push('js')
        
        <script defer>
            
        </script>
    @endpush
</x-app-layout>
