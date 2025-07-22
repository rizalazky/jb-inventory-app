<div class="row"> 
    @if($type == 'in' && Auth::user()->can('transaction-menu transaction-in update') )
        <a href="/transaksi/edit/{{ $id }}"  class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
    @endif
    @if($type == 'in' && Auth::user()->can('transaction-menu transaction-in delete'))
        <a href="/transaksi/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
    @endif
    @if($type == 'out' && Auth::user()->can('transaction-menu transaction-out update') )
        <a href="/transaksi/edit/{{ $id }}"  class="btn btn-info btn-sm mr-1"><i class="fas fa-fw fa-pen"></i></a>
    @endif
    @if($type == 'out' && Auth::user()->can('transaction-menu transaction-out delete'))
        <a href="/transaksi/delete/{{ $id }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fas fa-fw fa-trash"></i></a>
    @endif
</div>