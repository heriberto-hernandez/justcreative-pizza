@extends('layouts.app')

@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  
    <div class="row">
        <div class="col-md-12 mx-auto mt-2">
            <select class="custom-select" id="size">
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mx-auto mt-2">
            <table id="tableOrderPizzaList" class="table table-hover table-sm" style="width:100%">
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

<div class="modal" id="modal_message" tabindex="-1" role="dialog" aria-labelledby="modal_message" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fa fa-exclamation-circle fa-5x text-info" aria-hidden="true"></i>
                        <h4 class="text-black font-weight-medium my-4 text-info" id="modal_message_title">Message</h4>
                    </div>
                </div>
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
    </script>
    <script type="text/javascript">
        var modalMessage  = $('#modal_message');
        var setModalMessage = (msg)=> {
            document.querySelector('#modal_message_title').innerText = msg
            $('#modal_message').modal({
              keyboard: false
            })
        }
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

            $.fn.dataTable.ext.buttons.viewPhotos = {
                text: '<i class="fa fa-picture-o"></i> Ver Fotografias',
                attr:  {
                    'data-toggle':'tooltip',
                    'data-placement':'top' ,
                    'data-html':true,
                    title:'<i class="mdi mdi-arrow-up"></i> + 7'
                },
                key: {
                    key: '7',
                    shiftKey: true
                },
                action:  function () {
                    setModalMessage( 'Mensaje' )
                    // var rowData = table.rows({ selected: true }).data();
                    // if (rowData[0] != undefined ) {
                    //     window.location.href = '/photographs/'+rowData[0].id
                    // } else {
                    //     setModalMessage( select_row )
                    // }
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
                    "viewPhotos"
                    ,"viewPhotos"
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
            
            $.fn.dataTable.ext.buttons.removePizza = {
                text: '<i class="fa fa-picture-o"></i> Remover Pizza',
                action:  function () {
                    var rowData = tableOrderPizzaList.rows({ selected: true }).data();
                    if (rowData[0] != undefined ) {
                        // window.location.href = '/photographs/'+rowData[0].id
                        setModalMessage( 'Mensaje if' )
                    } else {
                        setModalMessage( 'Mensaje else' )
                    }
                }
            };
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
                    "url": "/api/order-details/1"
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
