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
                {{ __('STOK FORM') }}
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
                    @if($data->transaction_id)
                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">Link Transaksi</label>
                            <a class='form-control' target='_blank' href="/transaksi/edit/{{ $data->transaction_id}}">{{ $data->transaction->transaction_number }}</a>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="product_price_id" class="form-label">Satuan</label>
                        <select id="product_price_id" name="product_price_id" class="form-control" @disabled($data->transaction_id !== null)>
                            @foreach($data->product->productprices as $proprice)
                                <option value="{{ $proprice->id }}" data-ucv="{{ $proprice->unit_conversion_value ? $proprice->unit_conversion_value : 1 }}" @selected($data->product_price_id == $proprice->id) >{{ $proprice->productunit->name }} {{ $proprice->is_default ? ' - DEFAULT' : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ $data->quantity }}" @disabled($data->transaction_id !== null) class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Unit Conversion Number</label>
                        <input type="number" name="unit_conversion_value" id="unit_conversion_value" value="{{ $data->quantity / $data->base_quantity }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Base Quantity</label>
                        <input type="number" name="base_quantity" id="base_quantity" value="{{ $data->base_quantity }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Catatan</label>
                       <textarea name="notes" id="notes" class="form-control" @disabled($data->transaction_id !== null)>{{ $data->notes }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    @if(!$data->transaction_id)
                        <button type="submit" class="btn btn-primary">Submit</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    @push('js')
        
        <script defer>
            $('#product_price_id').on('change', function(e){
                var selected = $('#product_price_id').find(":selected").data('ucv');

                $('#unit_conversion_value').val(selected);
                const quantity = $('#quantity').val() || 1;
                console.log('Quantity', quantity);
                console.log('UCV', selected);

                let baseQuantity = Number(quantity) / Number(selected); 

                $('#base_quantity').val(baseQuantity);
            })

            $('#quantity').on('change', function(e){
                var selected =$('#unit_conversion_value').val();
                const quantity = $('#quantity').val() || 1;
                console.log('Quantity', quantity);
                console.log('Selected', selected);

                let baseQuantity = Number(quantity) / Number(selected); 

                $('#base_quantity').val(baseQuantity);
            })
        </script>
    @endpush
</x-app-layout>
