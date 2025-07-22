<div class="card">
    <div class="card-header">
        Harga Produk
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm btn-add-modal" data-bs-toggle="modal" data-bs-target="#modal-product-price">
            Tambah Harga Produk
        </button>
        <table class="table table-striped">
            <thead>
                <th>NO</th>
                <th>UNIT</th>
                <th>BUY PRICE</th>
                <th>SELL PRICE</th>
                <th>UNIT CONVERSION VALUE</th>
                <th>STOK</th>

                <th class="text-center">DEFAULT</th>

                <th>ACTION</th>
            </thead>
            <tbody>
                @foreach($productprices as $price)
                    <tr>
                        <td>{{  $loop->iteration }}</td>
                        <td>{{ $price->productunit->name }}</td>
                        <td class="text-right">{{ number_format($price->buy_price) }}</td>
                        <td class="text-right">{{ number_format($price->sell_price) }}</td>
                        <td>{{ $price->unit_conversion_value ? $price->unit_conversion_value : 1 }} {{ $price->productunit->name }}</td>
                        <td>{{ $price->unit_conversion_value ? number_format($product_stock * $price->unit_conversion_value) : number_format($product_stock * 1) }} {{ $price->productunit->name }}</td>

                        <td class="d-flex justify-center">
                            <form action="/harga-produk/set-default-display" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $price->id }}">
                                <input type="hidden" name="product_id" value="{{ $price->product_id }}">
                                <input class="form-check-input" onChange="this.form.submit()" type="checkbox" id="flexCheckChecked" @if($price->is_default_display) checked @endif>
                            </form>
                        </td>
                        <td>
                            <button 
                                class="btn btn-sm btn-info btn-product-price-update"
                                data-id="{{ $price->id }}"
                                data-unitid="{{ $price->unit_id }}"
                                data-buyprice="{{ $price->buy_price }}"
                                data-sellprice="{{ $price->sell_price }}"
                                data-ucv="{{ $price->unit_conversion_value ? $price->unit_conversion_value : 1 }}"
                                data-isdefault="{{ $price->is_default}}"
                                data-bs-toggle="modal" data-bs-target="#modal-product-price"
                                >
                                Edit
                            </button>
                            <!-- @if(!$price->is_default)
                                <button type="button" class="btn btn-primary btn-sm btn-add-modal-konversi" data-bs-toggle="modal" data-bs-target="#modal-konversi">
                                    Atur Konversi Stok
                                </button>
                            @endif -->
                            <a href="/harga-produk/delete/{{ $price->id }}" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-product-price" aria-labelledby="modal-product-price-title">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="modal-product-price-title">Tambah Harga Produk</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/harga-produk" method="post" id="product-price-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            <input type="hidden" name="id" id="product_price_id">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="unit_id" class="form-label">Unit Produk</label>
                    <select name="unit_id" class="form-control" id="unit_id">
                        <option value="">-- Pilih Unit Produk --</option>
                        @foreach ($product_units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                    @error('unit_id') <p class="text-danger">{{ $message }}</p> @enderror
                </div>  
                <div class="mb-3">
                    <label for="buy_price" class="form-label">Harga Beli</label>
                    <input type="number" class="form-control" id="buy_price" name="buy_price">
                    @error('buy_price') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="sell_price" class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" id="sell_price" name="sell_price">
                    @error('sell_price') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="unit_conversion_value" class="form-label">Unit Conversion Value</label>
                    <input type="number" class="form-control" id="unit_conversion_value" name="unit_conversion_value" step="any">
                    @error('unit_conversion_value') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
      </form>
    </div>
  </div>
</div>

@push('js')

    <script>
        $(document).ready(function() {
                @if ($errors->any())
                    $('.btn-add-modal').trigger('click');
                @endif

                $('.btn-product-price-update').click(function(){
                    let isDefault = $(this).data('isdefault');
                    $('#product_price_id').val($(this).data('id'))
                    $('#buy_price').val($(this).data('buyprice'))
                    $('#sell_price').val($(this).data('sellprice'))
                    $('#unit_id').val($(this).data('unitid'))
                    $('#unit_conversion_value').val($(this).data('ucv'));

                    $('#unit_conversion_value').prop('readonly', isDefault)
                    $('#modal-product-price-title').text("Edit Product Price")
                    $('#product-price-form').attr('action','/harga-produk/update')
                })

                $('.btn-add-modal').click(function(){
                     $('#product_price_id').val('')
                    $('#buy_price').val('')
                    $('#sell_price').val('')
                    $('#unit_id').val('')
                    $('#unit_conversion_value').val('');

                    $('#unit_conversion_value').prop('disabled', false)
                    $('#modal-product-price-title').text("Add Product Price")
                    $('#product-price-form').attr('action','/harga-produk')
                });

            });
        
    </script>
@endpush


