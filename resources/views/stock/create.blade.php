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
                            url: '/stok/search', // URL to fetch data
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
                        let optionsHTML = ``;
                        productprices?.map(price=>{
                            let option = `<option value='${price.id}' ${price.is_default && 'selected'}>${price.productunit.name} ${price.is_default ? '- DEFAULT' : ''}</option>`
                            optionsHTML = optionsHTML + option;
                        })
                        $('#product_price_id').html(optionsHTML)
                        console.log(data.productprices);
                    });
                });
        </script>
    @endpush
</x-app-layout>
