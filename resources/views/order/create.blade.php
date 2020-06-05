@extends('layouts.app')

@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>{{ __('Create an Order') }}</h1>
    <div class="row">
        <div class="col-md-3" >
            <ul class="list-group list-group-flush">
              <li class="list-group-item">@lang('app.text.number_order'): <strong class="text-uppercase text-primary" id="number_order">{{ $data->number_order}}</strong></li>
              <li class="list-group-item">@lang('app.text.total'):  <strong class="text-uppercase text-primary" id="subtotal">{{ $data->total}}</strong></li>
              <li class="list-group-item">@lang('app.text.date'): <strong class="text-uppercase text-primary">{{ $data->date}}</strong></li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 mx-auto mt-2">
            <div class="form-group">
                <label for="exampleFormControlSelect1" class="text-primary">{{ __('Pizza Filter by Size') }}</label>
                <select class="form-control" id="size">
                </select>
              </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mx-auto mt-2">
            <table id="tableOrderPizzaList" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr class="solid-header">
                        <th>@lang('app.table.name')</th>
                        <th>@lang('app.table.prece')</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="solid-header">
                        <th>@lang('app.table.name')</th>
                        <th>@lang('app.table.prece')</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-8 mx-auto mt-2">
            <table id="tablePizzaList" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr class="solid-header">
                        <th>@lang('app.table.name')</th>
                        <th>@lang('app.table.preci')</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="solid-header">
                        <th>@lang('app.table.name')</th>
                        <th>@lang('app.table.preci')</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/language-es.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
        let open_this_select_menu =  "@lang('app.form.open_this_select_menu')"
        let select_all =  "@lang('app.form.select_all')"
        let select_row =  "@lang('app.modal.select_row')"
        let remove_pizza = "@lang('app.text.remove_pizza')"
        let add_order = "@lang('app.text.add_order')"
        let add_pizza = "@lang('app.text.add_pizza')"
    </script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            
            document.getElementById('size').addEventListener('change', function() {
                let id = this.value
                if(id === "0"){
                    tablePizzaList.ajax.url(`/api/pizza`).load();        
                }else{
                    tablePizzaList.ajax.url(`/api/by-size/${id}`).load(); 
                }
            });
            axios.get('/api/size')
            .then( (response) => {
                const data = response.data.data
                var list =` <option value="0" selected>${ open_this_select_menu }</option>`;
                list +=` <option value="0" >${ select_all }</option>`;
                data.forEach(function(element) {
                    list+=`
                    <option  value="${ element.id }"> ${ element.name } </option>
                    `;
                });             
                document.getElementById('size').innerHTML = list
            })
            .catch( (error) => {
                console.log(error);
            });

            var addPizzaOrder = (order, pizza, price) => {
                axios.post(`/api/add-pizza-order/`, {
                    number_order: order,
                    pizzas_id: pizza
                })
                .then( (response) => {
                    const data = response.data.data
                    setModalMessage( data )
                    tableOrderPizzaList.ajax.reload( null, false );
                    let subtotal = document.getElementById('subtotal').textContent                
                    let total = (parseFloat(subtotal) + parseFloat(price));
                    document.getElementById('subtotal').textContent = `${total}`;
                })
                .catch( (error) => {
                    const errors = error.response.data
                    setModalMessage( errors )
                });
            }

            var updateOrder = (order, subtotal) => {
                axios.post(`/api/order/${order}`, {
                    number_order: order,
                    total: subtotal,
                     _method: 'patch'   
                })
                .then( (response) => {
                    const data = response.data.data
                    window.location.href = '/home'
                })
                .catch( (error) => {
                    const errors = error.response.data
                    setModalMessage( errors )
                });
            }

            $.fn.dataTable.ext.buttons.addPizza = {
                text: add_pizza,
                action:  function () {
                    var rowData = tablePizzaList.rows({ selected: true }).data();
                    if (rowData[0] != undefined ) {
                        let number_order = document.getElementById('number_order').textContent
                        addPizzaOrder(number_order, rowData[0].id, rowData[0].price )
                    } else {
                        setModalMessage( select_row )
                    }
                }
            };

            $.fn.dataTable.ext.buttons.addOrderPizza = {
                text: add_order,
                action:  function () {
                    var rowData = tablePizzaList.rows({ selected: true }).data();
                    if (rowData[0] != undefined ) {
                        let number_order = document.getElementById('number_order').textContent
                        let subtotal = document.getElementById('subtotal').textContent   
                        updateOrder(number_order, subtotal)
                    } else {
                        setModalMessage( select_row )
                    }

                }
            };

            var tablePizzaList = $('#tablePizzaList').DataTable({
                dom:  "<'row'<'col-sm-12 col-md-12 d-flex justify-content-center'B> >" 
                + "<'row'<'col-sm-12 col-md-12 d-flex justify-content-stard'f>>" 
                + "<'row'<'col-sm-12'tr>>" 
                + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                ,"select": {
                    "className": 'bg-primary'
                }
                ,"paging": false
                ,"lengthChange": true
                ,"scrollY": "500px"
                ,"scrollCollapse": true
                ,"scrollX": true
                ,"responsive": true
                ,"language": es
                ,"buttons": [
                    "addPizza",
                    "addOrderPizza"
                ]
                ,"ajax": {
                    "url": "/api/pizza"
                }
                ,"columns": [
                     { "data": "name" }
                    ,{ "data": "price"}        
                ]
                ,"bDestroy": true
            });
            tablePizzaList.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
                       
            var removePizzaOrder = (order, pizza, created, price) => {
                axios.get(`/api/remove-pizza-order/${order}/${pizza}/${created}`)
                .then( (response) => {
                    const data = response.data.data
                    setModalMessage( data )
                    let subtotal = document.getElementById('subtotal').textContent                
                    let total = (parseFloat(subtotal) - parseFloat(price));
                    document.getElementById('subtotal').textContent = `${total}`;
                    tableOrderPizzaList.ajax.reload( null, false );
                })
                .catch( (error) => {
                    const errors = error.response.data
                    setModalMessage( errors )
                });
            }
            
            $.fn.dataTable.ext.buttons.removePizza = {
                text: remove_pizza,
                action:  function () {
                    var rowData = tableOrderPizzaList.rows({ selected: true }).data();
                    if (rowData[0] != undefined ) {
                        removePizzaOrder( rowData[0].number_order, rowData[0].pizzas_id, rowData[0].created_at, rowData[0].pizza.price)
                    } else {
                       setModalMessage( select_row )
                    }
                }
            };

            let number_order = document.getElementById('number_order').textContent
            var tableOrderPizzaList = $('#tableOrderPizzaList').DataTable({
                dom:  "<'row'<'col-sm-12 col-md-12 d-flex justify-content-center'B> >" 
                + "<'row'<'col-sm-12 col-md-12 d-flex justify-content-stard'f>>" 
                + "<'row'<'col-sm-12'tr>>" 
                + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                ,"select": {
                    "className": 'bg-primary'
                }
                ,"ordering": false
                ,"info": false
                ,"searching": false
                ,"paging": false
                ,"lengthChange": true
                ,"scrollY": "500px"
                ,"scrollCollapse": true
                ,"scrollX": true
                ,"responsive": true
                ,"language": es
                ,"buttons": [
                    "removePizza"
                ]
                ,"ajax": {
                    "url": "/api/order-details/"+number_order
                }
                ,"columns": [
                     { "data": "pizza.name" }
                    ,{ "data": "pizza.price"}        
                ]
                ,"bDestroy": true
            });

            tableOrderPizzaList.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
            $(".dt-button").removeClass("dt-button buttons-action").addClass("btn btn-primary btn-sm my-2");
        });
    </script>
@endsection
