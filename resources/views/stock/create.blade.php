<x-app-layout>
    <x-slot name="header">   
            {{ __('STOK') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST" action="/stok">
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('STOK MASUK FORM') }}
                </div>
                <div class="card-body">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select id="product_id" name="product_id" class="form-control">
                
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product_price_id" class="form-label">Satuan</label>
                        <select id="product_price_id" name="product_price_id" class="form-control">

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Unit Conversion Number</label>
                        <input type="number" name="unit_conversion_value" id="unit_conversion_value" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Base Quantity</label>
                        <input type="number" name="base_quantity" id="base_quantity" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Catatan</label>
                       <textarea name="notes" id="notes" class="form-control"></textarea>
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
            
                $(document).ready(function() {
                    $('#product_id').select2({
                        theme: "classic",
                        ajax: {
                            url: '/produk/search', // URL to fetch data
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        
                                        return {
                                            text: `${item.code} - ${item.name}`, 
                                            id: item.id,
                                            productprices : item.productprices 
                                        }
                                    })
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 1, 
                        placeholder: 'Search for a product',
                        allowClear: true
                    });

                    $('#product_id').on('select2:select', function (e) {
                        var data = e.params.data;
                        let productprices = data.productprices;
                        let optionsHTML = `<option>Select Unit</option>`;
                        productprices?.map(price=>{
                            let option = `<option value='${price.id}' data-ucv='${price.unit_conversion_value || 1}'>${price.productunit.name} ${price.is_default ? '- DEFAULT' : ''}</option>`
                            optionsHTML = optionsHTML + option;
                        })
                        $('#product_price_id').html(optionsHTML)
                        console.log(data.productprices);
                    });

                    $('#product_price_id').on('change', function(e){
                        var selected = $('#product_price_id').find(":selected").data('ucv');

                        $('#unit_conversion_value').val(selected);
                        const quantity = $('#quantity').val() || 1;
                        console.log('Quantity', quantity);

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
                });
        </script>
    @endpush
</x-app-layout>
