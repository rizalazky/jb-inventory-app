<x-app-layout>
    <x-slot name="header">   
            @if($type == 'penjualan')   
                {{ __('REPORT PENJUALAN') }}
            @else
                {{ __('REPORT PEMBELIAN') }}
            @endif
    </x-slot>

    <div class="container-fluid">
        <form method="post" action="{{ route('report.generatepdf') }}">
            @csrf
            <div class="card">
                <!-- <div class="card-header">

                </div> -->
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="type" value="{{ $type == 'penjualan'? 'out' : 'in' }}">
                        <div class="col-md-2">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="col-md-2">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
