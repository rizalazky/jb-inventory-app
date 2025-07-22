<div class="row">
    @can('master-menu product-category update')
        <a href="/kategori-produk/edit/{{ $id }}" class="btn btn-info btn-sm mr-1">
            <i class="fas fa-fw fa-pen"></i>
        </a>
    @endcan

    @can('master-menu product-category delete')
        <a href="/kategori-produk/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true">
            <i class="fas fa-fw fa-trash"></i>
        </a>
    @endcan
</div>
