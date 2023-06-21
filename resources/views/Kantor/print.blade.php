
<style>
    table{
        width:100%;
        border-collapse:"collapse";
    }
    table tr td, table tr th{
        font-size: 9pt;
        border:1px solid;
    }
    .centered {
        text-align:center;
    }
    td{
        padding-left:10px;
    }
    h1{
        text-align:center;
    }
</style>
<h1>
    DATA KANTOR
</h1>
<table class="table table-hover table-bordered table-stripped" id="kantor">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kantor</th>
                            <th>Alamat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kantor as $key => $kantor)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$kantor->nama_kantor}}</td>
                                <td>{{$kantor->alamat_kantor}}</td>
                            </tr>
                        @endforeach
                        </tbody>
</table>

