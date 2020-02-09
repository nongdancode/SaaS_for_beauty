

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />

<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />


@section('js')
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"  type="text/javascript"></script>
@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('content')




<p> List phone of customer</p>

<table id="example" class="display" style="width:100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Send Message</th>


    </tr>
    </thead>

</table>

<textarea class="form-control" style="min-width: 100%"></textarea>
<script>
    //var dataSet = <?php //echo $data?>//;



    $(document).ready( function () {
        $('#example').DataTable({
            processing: false,
            serverSide: false,
            ajax: "{{ url('/admin/smsapi') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'phone_number', name: 'phone number' },
                {data: 'action', name: 'action'},


            ]

        });
    });

    var checkedValue = $('.example:checked').val();

    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
    } );

</script>



@stop
