<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Products') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                        {{ __('Edit Product') }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Kode Produk/Barcode</label>
                                    <input type="text" class="form-control" id="code" value="{{ $product->code }}" name="code">
                                    @error('code') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Kategori Produk</label>
                                    <select name="category_id" class="form-control" id="role">
                                        <option value="">-- Pilih Kategori Produk --</option>
                                        @foreach ($categories as $cat)
                                            @if($cat->id == $product->id)
                                                <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                                            @else
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" value="{{ $product->name }}" name="name">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label for="name" class="form-label">Satuan</label>
                                    <select name="" id="unit-default" class="form-control">
                                        @foreach ($product->productprices as $dt)
                                            @if($dt->is_default)
                                                <option class="option-unit" data-stock="{{ $product->stock }}" data-price="{{ number_format($dt->price) }}" value="{{ $dt->id }}" selected>{{ $dt->productunit->name }}</option>
                                            @else
                                                <option class="option-unit" data-stock="{{ $dt->convert_stock($dt->id,$product->stock) }}" data-price="{{ number_format($dt->price) }}" value="{{ $dt->id }}">{{ $dt->productunit->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="name" class="form-label">Harga</label>
                                    <input type="text" class="form-control" disabled id="price-default" value="{{ $product->stock }}">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="name" class="form-label">Stok</label>
                                    <input type="text" class="form-control" disabled id="stock" value="{{ $product->stock }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="col-md-6">
                @include('productprice.index', [
                    'product_id'=>$product->id,
                    'product_stock'=>$product->stock,
                    'productprices' => $product->productprices,
                    'productunits' => $product_units,
                ])
                @if(count($product->productprices) > 1)
                    @include('conversionproductunit.index', [
                        'product_id'=>$product->id,
                        'productprices' => $product->productprices,
                        'unitconversions' => $product->unitconversions,
                    ])
                @endif
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function(){
            const onDefaultUnitChange = () =>{
                let price = $('#unit-default').find(':selected').data('price');
                let stock = $('#unit-default').find(':selected').data('stock');
                $('#price-default').val(price);
                $('#stock').val(stock);
            }

            $('#unit-default').click(function(){
                onDefaultUnitChange();
            })

            onDefaultUnitChange();
        })
    </script>
    @endpush
</x-app-layout>
