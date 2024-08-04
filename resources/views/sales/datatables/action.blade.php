<div class="row">
    <button 
        type="button" 
        data-name="{{ $name }}" 
        data-address="{{ $address }}" 
        data-id="{{ $id }}" 
        data-phone="{{ $phone }}" 
        class="btn btn-info btn-sm mr-1 btn-sales-edit" 
        data-bs-toggle="modal" 
        data-bs-target="#exampleModal"
        >
            <i class="fas fa-fw fa-pen"></i>
        </button>
    <a href="/sales/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
</div>

<script>
    $(document).ready(function(){
        console.log('ready')
        $('.btn-sales-edit').click(function(){
            console.log('OKE')
            $('#sales-id').val($(this).data('id'))
            $('#sales-name').val($(this).data('name'))
            $('#sales-address').val($(this).data('address'))
            $('#sales-phone').val($(this).data('phone'))

            $('#form-sales').attr('action','/sales/edit_post')
            $('.modal-title').text('Edit Sales')
        })
    })
</script>