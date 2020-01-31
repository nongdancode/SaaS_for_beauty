

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />



<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"  type="text/javascript"></script>


@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('content')


Welcome1!

<p>Welcome to this beautiful admin panel2222222222222.</p>

<table id="example" class="display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Position</th>
        <th>Office</th>
        <th>Age</th>
        <th>Start date</th>
        <th>Salary</th>
        <th>Extn.</th>
        <th>E-mail</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Tiger</td>
        <td>Nixon</td>
        <td>System Architect</td>
        <td>Edinburgh</td>
        <td>61</td>
        <td>2011/04/25</td>
        <td>$320,800</td>
        <td>5421</td>
        <td>t.nixon@datatables.net</td>
    </tr>
    <tr>
        <td>Garrett</td>
        <td>Winters</td>
        <td>Accountant</td>
        <td>Tokyo</td>
        <td>63</td>
        <td>2011/07/25</td>
        <td>$170,750</td>
        <td>8422</td>
        <td>g.winters@datatables.net</td>
    </tr>
    <tr>
        <td>Ashton</td>
        <td>Cox</td>
        <td>Junior Technical Author</td>
        <td>San Francisco</td>
        <td>66</td>
        <td>2009/01/12</td>
        <td>$86,000</td>
        <td>1562</td>
        <td>a.cox@datatables.net</td>
    </tr>
    <tr>
        <td>Cedric</td>
        <td>Kelly</td>
        <td>Senior Javascript Developer</td>
        <td>Edinburgh</td>
        <td>22</td>
        <td>2012/03/29</td>
        <td>$433,060</td>
        <td>6224</td>
        <td>c.kelly@datatables.net</td>
    </tr>
    <tr>
        <td>Airi</td>
        <td>Satou</td>
        <td>Accountant</td>
        <td>Tokyo</td>
        <td>33</td>
        <td>2008/11/28</td>
        <td>$162,700</td>
        <td>5407</td>
        <td>a.satou@datatables.net</td>
    </tr>
    <tr>
        <td>Brielle</td>
        <td>Williamson</td>
        <td>Integration Specialist</td>
        <td>New York</td>
        <td>61</td>
        <td>2012/12/02</td>
        <td>$372,000</td>
        <td>4804</td>
        <td>b.williamson@datatables.net</td>
    </tr>


    </tbody>
</table>



<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: {
                details: true
            }
        } );
    } );
</script>


@stop
