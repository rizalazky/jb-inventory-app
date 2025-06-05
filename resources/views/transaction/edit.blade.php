<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        @if($data->type == 'out')   
            {{ __('TRANSAKSI PENJUALAN') }}
        @else
            {{ __('TRANSAKSI PEMBELIAN') }}
        @endif
    </x-slot>

    <div class="container-fluid">
        <div class="card">
                <div class="card-header flex justify-content-end">
                    <button type="button" id="btn-new" class="btn btn-default mr-2">
                        <a href="/transaksi/penjualan">Transaksi Baru</a>
                    </button>
                    <button type="button" id="btn-submit" class="btn btn-primary mr-2">Update</button>
                    <button type="button" id="btn-print-receipt" class="btn btn-info">Cetak Struk</button>
                </div>
    
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <label for="date">Tanggal</label>
                            <input type="date" name="date" value="{{ $data->date }}" id="date" class="form-control">

                           
                        </div>
                        <div class="col-4">
                        @if($data->type == 'out')   
                            <label for="date">Customer</label>
                            <select name="" class="form-control" id="customer_id">
                                @if($data->customer)
                                    <option value="{{ $data->customer_id }}" selected>{{ $data->customer->name }}</option>
                                @endif
                            </select> 
                            @else
                            <label for="date">Supplier</label>
                            <select name="" class="form-control" id="supplier_id">
                                @if($data->customer)
                                    <option value="{{ $data->supplier_id }}" selected>{{ $data->supplier->name }}</option>
                                @endif
                            </select> 
                        @endif
                        </div>
                        <div class="col-4">
                            <label for="date">NO TRANSAKSI</label>
                            <input type="transaction_number" value="{{ $data->transaction_number }}" name="transaction_number" id="transaction_number" disabled class="form-control">
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header">
                            PRODUK
                        </div>
                        <div class="card-body">
                             
                            <div class="input-group mb-3" style="width:20%;">
                                <!-- <input type="text" class="form-control" id="product_id" placeholder="Masukan Kode Produk" disabled aria-describedby="button-addon2"> -->
                                 <select id="product_id" name="product_id" class="form-control">

                                </select>
                                <!-- <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">CARI</button>
                                </div> -->
                            </div>
                            
                            <table class="table table-bordered" id="MyTable">
                                <thead>
                                    <thead>
                                    <th>KODE</th>
                                    <th>PRODUK</th>
                                    <th>SATUAN</th>
                                    <th>QTY</th>
                                    <th>UNIT CONVERSION VALUE</th>
                                    <th>BASE QTY</th>
                                    <th>HARGA</th>
                                    <th>SUB TOTAL</th>
                                    <th>DISKON</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </thead>
                                <tbody id="product-tbody">
                                    <tr>
                                        <td colspan="9" class="text-center bg-light">No Items</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <th>KODE</th>
                                    <th>PRODUK</th>
                                    <th>SATUAN</th>
                                    <th>QTY</th>
                                    <th>UNIT CONVERSION VALUE</th>
                                    <th>BASE QTY</th>
                                    <th>HARGA</th>
                                    <th>SUB TOTAL</th>
                                    <th>DISKON</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="type" id="type" value="{{ $data->type }}">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="sub_total" class="form-label">Sub Total</label>
                                <input type="number" name="sub_total" id="sub_total" value="{{ $data->sub_total }}" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="discount" class="form-label">Diskon</label>
                                <input type="number" name="discount" value="{{ $data->discount }}" id="discount" class="form-control">
                            </div>
                            
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="total" class="form-label">TOTAL</label>
                                <input type="number" name="total" id="total" value="{{ $data->total }}" disabled class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="cash_paid" class="form-label">CASH</label>
                                <input type="number" name="cash_paid" value="{{ $data->cash_paid }}" id="cash_paid" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="change" class="form-label">Kembali</label>
                                <input type="number" name="change" value="{{ $data->change }}" id="change" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="name" class="form-label">Catatan</label>
                               <textarea name="notes" id="notes" class="form-control" rows="4">{{ $data->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    

                </div>
                
            </div>
        
    </div>

    @push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    @endpush
    @push('js')
        
        <script defer>
            
            
            
            $(document).ready(function() {
                    const productTbody = document.getElementById('product-tbody');
                    const subTotalEl = document.getElementById('sub_total');
                    const totalEl = document.getElementById('total');
                    const discountEl = document.getElementById('discount');
                    let productList = @json($data->transaction_details);

                    const setTransactionTotal = ()=>{
                        totalEl.value = (Number(subTotalEl.value) || 0) - (Number(discountEl.value) || 0);
                        $('#total').trigger('change');
                    }

                    const setTransactionSubTotal = ()=>{
                        let subTotal = productList.reduce((accumulator,currentValue) => accumulator + currentValue.total, 0);

                        console.log(subTotal)
                        subTotalEl.value = subTotal;

                        setTransactionTotal();
                    }

                    

                    discountEl.addEventListener('change',()=>{
                        setTransactionSubTotal();
                    })

                    const generateTable = ()=>{
                        console.log(productList)
                        // return false;
                        let type = $('#type').val();
                        let html = ``;
                        // let total = 0;
                        // let subTotalEl;
                        for (let i = 0; i < productList.length; i++) {
                            const product = productList[i];
                            let optionsHTML = ``
                            let priceDefault;
                            let productPriceDefault;
                            let unitConversionValue;
                            let baseQty;

                            console.log('product',product)
                            product?.product?.productprices?.map(price=>{
                                
                                    if(price.id == product.product_price_id){
                                        priceDefault = type == 'out' ? price.sell_price : price.buy_price;
                                        productPriceDefault = price.id;
                                        unitConversionValue = price.unit_conversion_value;
                                    }
                                    let option = `<option data-price="${price.sell_price}" data-ucv="${price.unit_conversion_value}" value='${price.id}' ${price.id == product.product_price_id  && 'selected'}>${price.productunit.name} ${price.is_default ? '- DEFAULT' : ''}</option>`
                                    optionsHTML = optionsHTML + option;

                                
                            })

                            let subTotal = priceDefault * product.qty;
                            let total = subTotal - product.discount
                            html += `<tr>
                                <td>${product.product.code}</td>
                                <td>${product.product.name}</td>
                                <td>
                                    <select class="form-control product-select-price" id="product-price-id-${product.product.code}" data-code="${product.product.code}"> ${optionsHTML}</select>
                                </td>
                                <td>
                                    <input type='number' value="${product.qty}" class="form-control product-qty" id="product-qty-${product.product.code}" data-code="${product.product.code}"/>
                                </td>
                                <td>
                                    <input type='number' value="${unitConversionValue}" class="form-control product-qty" readonly id="product-unit-conversion-value-${product.product.code}" data-code="${product.product.code}"/>
                                </td>
                                <td>
                                    <input type='number' value="${product.qty / unitConversionValue}" class="form-control product-base-qty" readonly id="product-base-qty-${product.product.code}" data-code="${product.product.code}"/>
                                </td>
                                <td>
                                    <input type='number' value="${priceDefault}" class="form-control product-price" disabled id="product-price-${product.product.code}"/>
                                </td>
                                <td>
                                    <input type='number' value="${ subTotal || 0 }" disabled class="form-control" id="product-sub-total-${product.product.code}"/>
                                </td>
                                <td>
                                    <input type='number' class="form-control product-discount" value="${product.discount}" id="product-discount-${product.product.code}" data-code="${product.product.code}"/>
                                </td>
                                <td>
                                    <input type='number' value="${ total || 0 }" disabled class="form-control" id="product-total-${product.product.code}"/>
                                </td>
                                <td>
                                    <button data-code="${product.product.code}" class="btn btn-danger btn-sm btn-delete-item-detail" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></button>
                                </td>

                            </tr>`;

                            productList[i].total = (product.price * product.qty) - product.discount
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                        }
                        
                        productTbody.innerHTML = html;
                        setTransactionSubTotal();
                    }

                    generateTable();

                    function changeProductSubTotal(code){
                        
                        const qty = document.getElementById('product-qty-'+code)
                        const baseQty = document.getElementById('product-base-qty-'+code)
                        const price = document.getElementById('product-price-'+code)
                        const discount = document.getElementById('product-discount-'+code)
                        const productPriceSelectOption = document.getElementById('product-price-id-'+code);
                        const subTotalProduct = document.getElementById('product-sub-total-'+code)
                        const totalProduct = document.getElementById('product-total-'+code)

                        let subTotal = Number(price.value) * Number(qty.value);
                        let total = subTotal - Number(discount.value);
                        // update productList
                        let productListSelectedIndex = productList.findIndex((product)=>{return product.product.code === code})

                        productList[productListSelectedIndex].qty = qty.value;
                        productList[productListSelectedIndex].base_qty = baseQty.value;
                        productList[productListSelectedIndex].price = price.value;
                        productList[productListSelectedIndex].subTotal = subTotal;
                        productList[productListSelectedIndex].total = total;
                        productList[productListSelectedIndex].discount = discount.value;
                        productList[productListSelectedIndex].product_price_id = productPriceSelectOption.value;

                        // console.log(productList)

                        subTotalProduct.value = subTotal;
                        totalProduct.value = total;

                        

                        setTransactionSubTotal()
                    }

                    $('#product-tbody').on('change',function(e){
                        const target = e.target;
                        const productCode = target.dataset.code;
                        if(target.classList.contains('product-select-price')){
                            const priceInput = document.getElementById("product-price-"+productCode);
                            const unitConversionValueInput = document.getElementById("product-unit-conversion-value-"+productCode);
                            const baseQuantityInput = document.getElementById("product-base-qty-"+productCode);

                            const quantityInput = document.getElementById("product-qty-"+productCode);
                            let quantity = quantityInput.value;
                            const price = target.options[target.selectedIndex].dataset.price;
                            const unitConversionValue = target.options[target.selectedIndex].dataset.ucv;

                            let baseQuantity = Number(quantity) / Number(unitConversionValue);
                            priceInput.value = price;
                            unitConversionValueInput.value = unitConversionValue;
                            baseQuantityInput.value = baseQuantity;

                            changeProductSubTotal(productCode)
                        }
                        if(target.classList.contains('product-qty')){
                            const unitConversionValueInput = document.getElementById("product-unit-conversion-value-"+productCode);
                            const quantityInput = document.getElementById("product-qty-"+productCode);
                            const baseQuantityInput = document.getElementById("product-base-qty-"+productCode);
                            let quantity = quantityInput.value;
                            let unitConversionValue = unitConversionValueInput.value;

                            let baseQuantity = Number(quantity) / Number(unitConversionValue);

                            baseQuantityInput.value = baseQuantity;

                            changeProductSubTotal(productCode)
                        }
                        if(target.classList.contains('product-discount')){
                            changeProductSubTotal(productCode)
                        }
                    })

                    $('#product_id').select2({
                        theme: "bootstrap4",
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
                                            // productprices : item.productprices,
                                            // product_code : item.code,
                                            item : item
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

                    $('#customer_id').select2({
                        theme: "bootstrap4",
                        ajax: {
                            url: '/customer/search', // URL to fetch data
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {       
                                        return {
                                            text: `${item.name}`, 
                                            id: item.id,
                                            // productprices : item.productprices,
                                            // product_code : item.code,
                                            // item : item
                                        }
                                    })
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 1, 
                        placeholder: 'Search Customer',
                        allowClear: true
                    });

                    $('#cash_paid').on('input',function(){
                        let total = $('#total').val();
                        let cash_paid = $('#cash_paid').val();

                        $('#change').val(cash_paid - total);
                    });

                    $('#total').change(function(){
                        console.log('fiure')
                        let total = $('#total').val();
                        let cash_paid = $('#cash_paid').val();

                        $('#change').val(cash_paid - total);
                    })

                    $('#supplier_id').select2({
                        theme: "bootstrap4",
                        ajax: {
                            url: '/supplier/search', // URL to fetch data
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {       
                                        return {
                                            text: `${item.name}`, 
                                            id: item.id,
                                            // productprices : item.productprices,
                                            // product_code : item.code,
                                            // item : item
                                        }
                                    })
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 1, 
                        placeholder: 'Search Supplier',
                        allowClear: true
                    });

                    $("#MyTable").on("click", ".btn-delete-item-detail", function() {
                        let code = $(this).data('code');
                        const index = productList.findIndex(item => item.product.code == code);

                        if (index !== -1) {
                            productList.splice(index, 1);
                        }

                        console.log(productList)
                        $(this).closest("tr").remove();
                    });

                    

                    const printReceipt = () => {
                        console.log('print');
                        fetch(`/transaksi/pdf/preview/{{ $data->id }}`)
                            .then(res => res.blob())
                            .then(blob => {
                                // Create a URL for the PDF blob
                                const url = URL.createObjectURL(blob);
                                console.log('blob', url);

                                // Embed the PDF in an iframe
                                const iframe = document.createElement('iframe');
                                iframe.style.display = 'none'; // Hide the iframe (optional)
                                document.body.appendChild(iframe);
                                iframe.src = url;

                                // Trigger the print dialog
                                iframe.onload = () => {
                                    console.log('on load iframe');
                                    iframe.contentWindow.print();

                                    // Clean up by removing the iframe and revoking the URL
                                    // iframe.contentWindow.onafterprint = () => {
                                    //     document.body.removeChild(iframe);
                                    //     URL.revokeObjectURL(url);
                                    // };
                                };
                            })
                            .catch(error => console.error('Error fetching PDF:', error));
                    }

                    $('#btn-print-receipt').click(function(){
                        printReceipt();

                    })


                    $('#product_id').on('select2:select', function (e) {
                        var data = e.params.data;
                        // console.log(data);
                        // return false;
                       
                        // let productprices = data.productprices;
                        let checkIfExist = productList.find(list =>{return list.product.code == data.item.code});
                        if(checkIfExist){
                            alert('Item sudah ditambahkan');
                            return false;
                        }

                       console.log(data)
                        
                        let dataToPush = {    
                            discount: 0,
                            price: data.item.productprices.find((price) => price.is_default)?.price,
                            product: data.item,
                            product_id: data.item.id,
                            product_price_id: data.item.productprices.find((price) => price.is_default)?.id,
                            qty: 1,
                            total: 0,
                        }
                        productList.push(dataToPush)
                        generateTable()
                    });

                    async function saveTransaction(data){
                        // let url = 'http://localhost:8000/transaksi/save';
                        let crsfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        let url = '/transaksi/edit/{{ $data->id }}';

                        $.ajax({
                            url: url,
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            contentType: 'application/json',
                            data: JSON.stringify(data),
                            success: function(response) {
                                console.log('result', response);
                                // if(!response.status){
                                //     alert(resp)
                                // }
                                alert('Transaction saved successfully!');
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status === 302) {
                                    window.location.href = xhr.getResponseHeader('Location');
                                } else {
                                    console.log('Error:', error);
                                    console.log('Response:', xhr.responseJSON);
                                    alert(xhr.responseJSON.message);
                                }
                            }
                        });
                    }

                    $('#btn-submit').on('click',function(e){
                        e.preventDefault();
                        let data = {
                            date : $('#date').val(),
                            type : $('#type').val(),
                            customer_id : $('#customer_id').val(),
                            supplier_id : $('#supplier_id').val(),
                            items : productList,
                            sub_total : $('#sub_total').val(),
                            discount : $('#discount').val(),
                            total : $('#total').val(),
                            cash_paid : $('#cash_paid').val(),
                            change : $('#change').val(),
                            notes : $('#notes').val(),
                        }

                        // console.log(data);
                        // return false;


                        saveTransaction(data)
                    })
                });


        </script>
    @endpush
</x-app-layout>
