<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Products') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row flex gap-4">
            <div class="flex-1">
                <form method="POST" enctype="multipart/form-data">
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
                                            @if($cat->id == $product->category_id)
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
                                    <select name="" id="unit-default" class="form-control" disabled>
                                        @foreach ($product->productprices as $dt)

                                            @if($dt->is_default)

                                                <option class="option-unit" data-stock="{{ $product->stock }}" data-buyprice="{{ number_format($dt->buy_price) }}" data-sellprice="{{ number_format($dt->sell_price) }}" value="{{ $dt->id }}" selected>{{ $dt->productunit->name }}</option>
                                            @else
                                                <option class="option-unit" data-stock="{{ number_format($dt->unit_conversion_value * $product->stock) }}" data-buyprice="{{ number_format($dt->buy_price) }}" data-sellprice="{{ number_format($dt->sell_price) }}" value="{{ $dt->id }}">{{ $dt->productunit->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="name" class="form-label">Harga Beli</label>

                                    <input type="text" class="form-control" name="buy_price" id="buy-price-default" value="{{ number_format($product->defaultProductPrice->buy_price) }}">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="name" class="form-label">Harga Jual</label>
                                    <input type="text" class="form-control" name="sell_price" id="sell-price-default" value="{{ number_format($product->defaultProductPrice->sell_price) }}">

                                </div>
                                <div class="mb-3 col-4">
                                    <label for="name" class="form-label">Stok</label>
                                    <input type="text" class="form-control" disabled id="stock" value="{{ $product->stock }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                @if(isset($product->image))
                                    <img src="{{ asset('storage/uploads/products/images/' . $product->image) }}" alt="Current Logo" width="100">
                                @endif
                                
                                <label for="image" class="form-label">Gambar Produk</label>
                                <input type="file" name="image" id="image" class="form-control-file mt-3">
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
            <div class="d-none">
                @include('productprice.index', [
                    'product_id'=>$product->id,
                    'product_stock'=>$product->stock,
                    'productprices' => $product->productprices,
                    'productunits' => $product_units,
                ])
                <!-- @if(count($product->productprices) > 1)
                    @include('conversionproductunit.index', [
                        'product_id'=>$product->id,
                        'productprices' => $product->productprices,
                        'unitconversions' => $product->unitconversions,
                    ])
                @endif -->
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function(){
            const onDefaultUnitChange = () =>{
                let buyPrice = $('#unit-default').find(':selected').data('buyprice');
                let sellPrice = $('#unit-default').find(':selected').data('sellprice');
                let stock = $('#unit-default').find(':selected').data('stock');
                $('#buy-price-default').val(buyPrice);
                $('#sell-price-default').val(sellPrice);
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
