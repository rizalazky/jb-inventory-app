<div class="row">
    @can('master-menu product-unit update')
        <a href="/unit-produk/edit/{{ $id }}"  class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
    @endif
    @can('master-menu product-unit delete')
        <a href="/unit-produk/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
    @endif
</div>