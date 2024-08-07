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
                <th>PRICE</th>
                <th>STOK</th>
                <th class="text-center">DEFAULT</th>
                <th>ACTION</th>
            </thead>
            <tbody>
                @foreach($productprices as $price)
                    <tr>
                        <td>{{ $price->id }}</td>
                        <td>{{ $price->productunit->name }}</td>
                        <td>{{ number_format($price->price) }}</td>
                        <td>{{ $price->is_default ? $product_stock : $price->convert_stock($price->id,$product_stock) }}</td>
                        <td class="d-flex justify-center">
                            <form action="/harga-produk/set-default" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $price->id }}">
                                <input type="hidden" name="product_id" value="{{ $price->product_id }}">
                                <input class="form-check-input" onChange="this.form.submit()" type="checkbox" id="flexCheckChecked" @if($price->is_default) checked @endif>
                            </form>
                        </td>
                        <td>
                            <button 
                                class="btn btn-sm btn-info btn-product-price-update"
                                data-id="{{ $price->id }}"
                                data-unitid="{{ $price->unit_id }}"
                                data-price="{{ $price->price }}"
                                data-bs-toggle="modal" data-bs-target="#modal-product-price"
                                >
                                Edit
                            </button>
                            @if(!$price->is_default)
                                <button type="button" class="btn btn-primary btn-sm btn-add-modal-konversi" data-bs-toggle="modal" data-bs-target="#modal-konversi">
                                    Atur Konversi Stok
                                </button>
                            @endif
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
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="price" name="price">
                    @error('price') <p class="text-danger">{{ $message }}</p> @enderror
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
                    
                    $('#product_price_id').val($(this).data('id'))
                    $('#price').val($(this).data('price'))
                    $('#unit_id').val($(this).data('unitid'))
                    $('#modal-product-price-title').text("Edit Harga Produk")
                    $('#product-price-form').attr('action','/harga-produk/update')
                })
            });
        
    </script>
@endpush
