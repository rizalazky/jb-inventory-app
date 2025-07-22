<div class="row">
    @if($type == 'in' && Auth::user()->can('stock-menu stock-in update'))
        <a href="/stok/edit/{{ $id }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
    @endif

    @if($type == 'in' && Auth::user()->can('stock-menu stock-in delete'))
        <a href="/stok/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
    @endif

    @if($type == 'out' && Auth::user()->can('stock-menu stock-out update'))
        <a href="/stok/edit/{{ $id }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
    @endif

    @if($type == 'out' && Auth::user()->can('stock-menu stock-out delete'))
        <a href="/stok/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
    @endif
</div>
