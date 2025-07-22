<div class="row">
    @can('setting-menu user update')
        <a href="/user/edit/{{ $id }}"  class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
    @endif
    @can('setting-menu user delete')
        <a href="/user/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
    @endif
</div>