@extends('layouts.app')

@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>{{ __('Order Detail') }}</h1>

    <div class="row">
        <div class="col-md-12">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">@lang('app.text.number_order'): <strong class="text-uppercase text-primary" id="number_order"></strong></li>
              <li class="list-group-item">@lang('app.text.total'):  <strong class="text-uppercase text-primary" id="subtotal"></strong></li>
              <li class="list-group-item">@lang('app.text.date'): <strong class="text-uppercase text-primary" id="date"></strong></li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 mt-2">
            <table id="tableList" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr class="solid-header">
                        <th>@lang('app.table.name')</th>
                        <th>@lang('app.table.price')</th>
                        <th>@lang('app.table.size')</th>
                    </tr>
                </thead>
                <tbody id="pizzaInfo">
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    var order = @json($order);
    var data = @json($pizza);
    let tableInfo = ``
    for( const pizza of data){
        tableInfo += `
        <tr>
            <td>${pizza.pizza.name}</td>
            <td>${pizza.pizza.price}</td>
            <td>${pizza.pizza.size.name}</td>
        </tr>`
    }
    document.getElementById('number_order').textContent = order.number_order  
    document.getElementById('subtotal').textContent = order.total  
    document.getElementById('date').textContent = order.date  
    document.getElementById('pizzaInfo').innerHTML = tableInfo
</script>
@endsection

