@extends('layouts.master')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default mt-4">
                <div class="card-header">Listado de deudores</div>

                <div class="card-body">
                    <table class="table table-hover" id='clients'>
                        <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Deuda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            @if ($client->clientDebt()>0)

                            <tr>

                                <td><a href="{{ route('user.show',$client->id) }}">{{ $client->name }}</a></td>
                                <td>{{ $client->clientDebt() }}</td>
                            </tr>

                            @endif
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endsection

@section('scripts')


<script>
    $(document).ready(function () {
        $('#clients').DataTable();
    });

</script>
@endsection
