@extends('layouts.app')

@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1>{{ __('Order List') }}</h1>
   
    <div class="row">
        <div class="col-md-12 mt-2">
            <table id="tableOrderList" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr class="solid-header">
                        <th>@lang('app.table.number_order')</th>
                        <th>@lang('app.table.date')</th>
                        <th>@lang('app.table.total')</th>
                        <th>@lang('app.table.user')</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="solid-header">
                        <th>@lang('app.table.number_order')</th>
                        <th>@lang('app.table.date')</th>
                        <th>@lang('app.table.total')</th>
                        <th>@lang('app.table.user')</th>
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
        let select_row =  "@lang('app.modal.select_row')"
        let btn_order_details =  "@lang('app.form.btn_order_details')"
    </script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            $.fn.dataTable.ext.buttons.viewDetails = {
                text: btn_order_details,
                action:  function () {
                    var rowData = tableOrderList.rows({ selected: true }).data();
                    if (rowData[0] != undefined ) {
                        window.location.href = '/order-details/'+rowData[0].number_order
                    } else {
                        setModalMessage( select_row )
                    }
                }
            };

            var tableOrderList = $('#tableOrderList').DataTable({
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
                    "viewDetails"
                ]
                ,"ajax": {
                    "url": "/api/order"
                }
                ,"columns": [
                     { "data": "number_order" }
                    ,{ "data": "date"}        
                    ,{ "data": "total"}        
                    ,{ "data": "user.name"}        
                ]
                ,"bDestroy": true
            });

            tableOrderList.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
            $(".dt-button").removeClass("dt-button buttons-action").addClass("btn btn-primary btn-sm my-2");
        });
    </script>
@endsection
