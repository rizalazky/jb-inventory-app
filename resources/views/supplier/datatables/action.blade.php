<div class="row">
    <div class="row">
        @can('supplier-menu supplier update')
            <a href="/supplier/detail/{{ $id }}"  class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-eye"></i></a>
        @endif
        @can('supplier-menu supplier update')
            <a href="/supplier/edit/{{ $id }}"  class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
        @endif
        @can('supplier-menu supplier delete')
            <a href="/supplier/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
        @endif
    </div>
    
</div>