<div class="card">
    <div class="card-header">
        Konversi Satuan
    </div>
    <div class="card-body">
        
        <table class="table table-striped">
            <thead>
                <th>NO</th>
                <th>DARI(SATUAN)</th>
                <th>KE(SATUAN) </th>
                <th>FAKTOR KONFERSI</th>
                <th>KETERANGAN</th>
                <th>ACTION</th>
            </thead>
            <tbody>
                @foreach($unitconversions as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->productprice_from->productunit->name }}</td>
                        <td>{{ $data->productprice_to->productunit->name }}</td>
                        <td>{{ $data->value }}</td>
                        <td>1 {{ $data->productprice_from->productunit->name }} = {{ $data->value }} {{ $data->productprice_to->productunit->name }}</td>
                        <td>
                            <button 
                                class="btn btn-sm btn-info btn-konversi-update"
                                data-id="{{ $data->id }}"
                                data-to="{{ $data->product_price_id_to }}"
                                data-from="{{ $data->product_price_id_from }}"
                                data-value="{{ $data->value }}"
                                data-bs-toggle="modal" data-bs-target="#modal-konversi"
                                >
                                Edit
                            </button>
                            <a href="/konversi-satuan/delete/{{ $data->id }}" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-konversi" aria-labelledby="modal-konversi-title">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-5" id="modal-konversi-title">Tambah Konversi</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/konversi-satuan" method="post" id="unit-conversion-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            <input type="hidden" name="id" id="conversion_id">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="product_price_id_from" class="form-label">DARI (SATUAN)</label>
                    <select name="product_price_id_from" class="form-control" id="product_price_id_from">
                        @foreach ($productprices as $dt)
                                @if($dt->is_default)
                                    <option value="{{ $dt->id }}">{{ $dt->productunit->name }}</option>
                                @endif
                        @endforeach
                    </select>
                    @error('product_price_id_from') <p class="text-danger">{{ $message }}</p> @enderror
                </div>  
                <div class="mb-3">
                    <label for="product_price_id_to" class="form-label">KE (SATUAN)</label>
                    <select name="product_price_id_to" class="form-control" id="product_price_id_to">
                        <option value="">-- Pilih SATUAN --</option>
                        @foreach ($productprices as $dt)
                                @if(!$dt->is_default)
                                    <option value="{{ $dt->id }}">{{ $dt->productunit->name }}</option>
                                @endif
                        @endforeach
                    </select>
                    @error('product_price_id_to') <p class="text-danger">{{ $message }}</p> @enderror
                </div>  
                <div class="mb-3">
                    <label for="price" class="form-label">Faktor Konversi</label>
                    <input type="number" step=".01" class="form-control" id="value" name="value">
                    @error('value') <p class="text-danger">{{ $message }}</p> @enderror
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
                    $('.btn-add-modal-konversi').trigger('click');
                @endif

                $('.btn-konversi-update').click(function(){
                    
                    $('#conversion_id').val($(this).data('id'))
                    $('#value').val($(this).data('value'))
                    $('#product_price_id_from').val($(this).data('from'))
                    $('#product_price_id_to').val($(this).data('to'))

                    $('#modal-konversi-title').text("Edit Konversi")
                    $('#unit-conversion-form').attr('action','/konversi-satuan/update')
                })
            });
        
    </script>
@endpush
