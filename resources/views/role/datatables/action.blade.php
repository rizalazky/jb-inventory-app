<div class="row">
    @can('setting-menu role update')
        <a href="/role/edit/{{ $id }}"  class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
    @endif
    @can('setting-menu role delete')
       <a href="/role/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
    @endif
</div>