@extends('layouts.master')
@section('content')
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">

                    @include('layouts.salesTopButtons')
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#searchByDateModal">

                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                        <div class="col-md-7"></div>
                        <div class="col-md-3 input-group">
                            {{-- <a href="{{ route('client.create') }}"></a> --}}

                            <div class="dropdown">
                                <button type="button" class="btn btn-warning dropdown-toggle" id="dropdownMenuActions"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-NewOperation="10,20">Nuevo
                                    cliente
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuActions">
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#DNICreateModal">DNI</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#clientCreateModal">RUC</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#passportCreateModal">Pasaporte</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <button type="button" class="btn btn-link dropdown-toggle" id="dropdownMenuConfiguration"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-NewOperation="10,20">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuConfiguration">
                                    <form action="{{ route('client.config',$configuration) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('PUT')

                                        @if ($configuration->client == true)

                                        <input type="checkbox" name="client" id="" class="" checked>
                                        <label for="client">Cliente</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="client" id="" class="">
                                        <label for="client">Cliente</label>
                                        <br>
                                        @endif

                                        @if ($configuration->phone == true)

                                        <input type="checkbox" name="phone" id="" class="" checked>
                                        <label for="phone">Teléfono</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="phone" id="" class="">
                                        <label for="phone">Teléfono</label>
                                        <br>
                                        @endif

                                        @if ($configuration->invoiced == true)

                                        <input type="checkbox" name="invoiced" id="" class="" checked>
                                        <label for="invoiced">Facturación</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="invoiced" id="" class="">
                                        <label for="invoiced">Facturación</label>
                                        <br>
                                        @endif

                                        @if ($configuration->debt == true)

                                        <input type="checkbox" name="debt" id="" class="" checked>
                                        <label for="debt">Deuda</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="debt" id="" class="">
                                        <label for="debt">Deuda</label>
                                        <br>
                                        @endif


                                        <button type="submit" class="btn btn-seconday ml-2">Configurar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <table class="table table-hover" id="clients">
                        <thead>
                            <tr>
                                @if ($configuration->client)
                                <th>Nombre</th>
                                @endif
                                @if ($configuration->phone)
                                <th>Teléfono</th>
                                @endif
                                @if ($configuration->invoiced)
                                <th>Facturado</th>
                                @endif
                                @if ($configuration->debt)
                                <th>Deuda</th>
                                @endif
                                <th class="noExport">Acción</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                @if ($configuration->client)
                                <td>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <a href="{{ route('client.edit',$client) }}">
                                                {{ $client->client_name }}
                                            </a>
                                        </div>
                                        @if ($client->client_email != null)

                                        <div class="col-md-3">
                                            <a href="{{ route('client.debt.mail',$client) }}">

                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                @endif
                                @if ($configuration->phone)
                                <td>{{ $client->client_cellphone }}</td>
                                @endif
                                @if ($configuration->invoiced)
                                <td></td>
                                @endif
                                @if ($configuration->debt)
                                <td></td>
                                @endif
                                <td>
                                    <div class="input-group">

                                        <div class="dropdown">
                                            <button type="button" class="btn btn-link " id="dropdownMenuActions"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                data-NewOperation="10,20">Nueva Operación
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuActions">
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#newOperationModal{{ $client->id }}"
                                                    onclick="document.CreateForm{{ $client->id }}.action =
'/budget';">Cotización</a>
                                                <a class="dropdown-item" href="#">Pedido</a>
                                                <a class="dropdown-item" href="#">Guía remisión</a>
                                                <a class="dropdown-item" href="" href="" data-toggle="modal"
                                                    data-target="#newOperationModal{{ $client->id }}" onclick="document.CreateForm{{ $client->id }}.action =
'/invoice';">Factura</a>
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#newOperationModal{{ $client->id }}"
                                                    onclick="document.CreateForm{{ $client->id }}.action =
'/ticket';">Boleta
                                                    de venta</a>
                                                <a class="dropdown-item" href="#">Venta interna</a>
                                                <a class="dropdown-item" href="#">Nota de crédito</a>
                                                {{-- <a class="dropdown-item" href="" data-toggle="modal" data-target="#createNoteModal{{ $client->id }}"
                                                onclick="document.CreateNoteForm{{ $client->id }}.action =
                                                '/debtNote';">Nota
                                                de débito</a> --}}



                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-link dropdown-toggle" id="dropdownMenuActions"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                data-NewOperation="10,20">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuActions">
                                                <a class="dropdown-item" href="">Imprimir</a>
                                                <a class="dropdown-item" href="{{ route('client.edit',$client) }}">Editar</a>
                                                @if ($client->client_email != null)
                                                <a class="dropdown-item" href="#">Enviar correo cobranza</a>
                                                @endif
                                                <form action="{{ route('client.destroy',$client) }}" method="POST" id="deleteClientForm{{ $client->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="dropdown-item" href="" onclick="event.preventDefault();
document.getElementById('deleteClientForm{{ $client->id }}').submit();">Eliminar</a>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {{-- NEW Budget MODAL --}}

                            <div class="modal fade" id="newOperationModal{{ $client->id }}" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Datos cliente y
                                                condiciones</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" id="CreateForm" name="CreateForm{{ $client->id }}">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group  col-md-7 ">
                                                        <label for="client_name">Cliente</label>
                                                        <input type="text" name="client_name" id="client_name" class="form-control-plaintext"
                                                            placeholder="Nombre" value="{{ old('client_name',$client->client_name) }}"
                                                            readonly>
                                                        @if ($errors->has('client_name'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_name') }}
                                                        </span>
                                                        @endif
                                                        {{-- <button class="btn btn-link" id="searchRuc"><i class="fas fa-search"></i></button>
                                --}}
                                                    </div>
                                                    <div class="form-group col-md-4 ">
                                                        @if ($client->ruc != null)

                                                        <label for="ruc">Ruc</label>
                                                        <input type="text" name="ruc" id="ruc" class="form-control-plaintext"
                                                            placeholder="RUC" value="{{ $client->ruc }}" readonly>
                                                        @elseif($client->dni != null)
                                                        <label for="ruc">DNI</label>
                                                        <input type="text" name="dni" id="dni" class="form-control-plaintext"
                                                            placeholder="DNI" value="{{ $client->dni }}" readonly>
                                                        @else
                                                        <label for="ruc">Pasaporte</label>
                                                        <input type="text" name="passport" id="passport" class="form-control-plaintext"
                                                            placeholder="DNI" value="{{ $client->passport }}" readonly>
                                                        @endif
                                                        @if ($errors->has('ruc'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('ruc') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="form-group col-md-3">
                                                        <label for="client_email">Correo de contacto</label>
                                                        <input type="text" name="client_email" id="client_email" class="form-control"
                                                            placeholder="Email" value="{{ old('client_email',$client->client_email) }}">
                                                        @if ($errors->has('client_email'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_email') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-8">
                                                        <label for="client_main_adress">Direccion</label>
                                                        {{-- <input type="text" name="client_main_adress" id="client_adress"
                                                            class="form-control" placeholder="Direccion" value="{{ old('client_main_adress',$client->client_main_adress) }}">
                                                        --}}

                                                        <select name="client_main_adress" id="client_main_adress{{ $client->id }}"
                                                            class="form-control">
                                                            @foreach ($client->adresses as $adress)
                                                            <option value="{{ $adress->client_adress }}">{{ $adress->client_adress }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('client_main_adress'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_main_adress') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>


                                                {{-- DATOS DE FACTURA --}}
                                                {{-- <h3 class="mt-4">
                            <strong>Datos de presupuesto</strong>
                        </h3> --}}
                                                <div class="row mt-4">
                                                    {{-- FECHA DE EMISION --}}
                                                    <div class="form-group col-md-3">
                                                        <label for="emission_date">Fecha de emisión</label>
                                                        <input type="text" name="emission_date" id="emission_date{{ $client->id }}"
                                                            class="form-control" placeholder="Fecha de emision" onfocus="(this.type='date')"
                                                            onblur="(this.type='text')" value="{{ old('emission_date') }}">
                                                        @if ($errors->has('emission_date'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('emission_date') }}
                                                        </span>
                                                        @endif
                                                    </div>

                                                    {{-- CONDICION --}}
                                                    <div class=" form-group col-md-3">
                                                        <label for="condition">Condición (días)</label>
                                                        <input type="number" name="condition" id="condition{{ $client->id }}"
                                                            class="form-control" placeholder="Condición (días)" value="{{ old('condition') }}">
                                                        {{-- <select name="condition" id="condition{{ $client->id }}"
                                                        class="form-control select2WithTag"
                                                        style="width: 100%">
                                                        <option value="">Condicion (Días)</option>
                                                        <option value="7">7</option>
                                                        <option value="15">15</option>
                                                        <option value="30">30</option>
                                                        <option value="60">60</option>
                                                        <option value="90">90</option>
                                                        <option value="120">120</option>
                                                        </select> --}}
                                                        @if ($errors->has('condition'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('condition') }}
                                                        </span>
                                                        @endif
                                                    </div>

                                                    {{-- FECHA DE VENCIMIENTO --}}
                                                    <div class="form-group col-md-3">
                                                        <label for="expiration_date">Fecha de expiración</label>
                                                        <input type="text" id="expiration_date{{ $client->id }}" class="form-control-plaintext"
                                                            placeholder="Fecha de Vencimiento" readonly>
                                                        @if ($errors->has('expiration_date'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('expiration_date') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="coin">Moneda</label>
                                                        <select name="coin" id="coin" class="form-control">

                                                            <option value="Soles">Soles</option>
                                                            <option value="Dolares">Dolares</option>

                                                        </select>
                                                        @if ($errors->has('coin'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('coin') }}
                                                        </span>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Generar</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <script>
                                $('#emission_date{{ $client->id }}').on('change', function () {
var emission = moment($(this).val());
var condition = $('#condition{{ $client->id }}').val();
var expiration = emission.add(condition, 'd').format('DD/MM/YYYY');
console.log('mosca');
if (expiration != 'Invalid date') {
$('#expiration_date{{ $client->id }}').val(expiration);
}

});

$('#condition{{ $client->id }}').on('keyup', function () {
var emission = moment($('#emission_date{{ $client->id }}').val());
var condition = $(this).val();
var expiration = emission.add(condition, 'd').format('DD/MM/YYYY');

if (expiration != 'Invalid date') {
$('#expiration_date{{ $client->id }}').val(expiration);

}

});
function budgetFormAction() {
document.CreateForm{{ $client->id }}.action = "/budget";
console.log('budget');
}

function invoiceFormAction() {
document.CreateForm{{ $client->id }}.action = "/invoice";
console.log('invoice');
}
</script>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- /.card -->
        </div>

    </div>
</div>


<!-- Import EXCEL Modal -->
<div class="modal fade" id="excelImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Importar desde Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('client.import') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="file" name="xls">
                    <div class="modal-footer">
                    </div>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SEARCH BY DATE --}}
<div class="modal fade" id="searchByDateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Busqueda por fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('client.index') }}" method="GET">
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="client_name">Cliente</label>
                            <select name="client_name" id="client_name" class="form-control select2" style="width: 100%">
                                <option value="all">Todos los clientes</option>
                                @foreach ($clientsList as $client)
                                <option value="{{ $client->client_name }}">{{ $client->client_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="from_date">Desde</label>
                            <input type="date" name="from_date" id="from_date" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="to_date">Hasta</label>
                            <input type="date" name="to_date" id="to_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mx-auto">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="clientCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-4">


                        <label for="ruc_number">Ruc a buscar</label>
                        <div class="input-group ">
                            <input type="text" id="client_create_ruc" name="ruc_number" placeholder="RUC" class="form-control">
                            <button id="searchRUC" class="btn btn-link"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>

                </div>

                <form action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <!-- RUC -->
                            <label for="ruc">RUC</label>
                            <input readonly type="text" name="ruc" id="ruc_number" placeholder="RUC" class="form-control"
                                value="{{ old('ruc') }}">
                            @if ($errors->has('ruc'))
                            <span style="color:red;">
                                {{ $errors->first('ruc') }}
                            </span>
                            @endif
                        </div>
                        <!-- SITUACION SUNAT -->
                        <div class="form-group col-md-3">
                            <label for="sunat_situation">Situación en Sunat</label>
                            <input readonly type="text" name="sunat_situation" id="sunat_situation" placeholder="Situacion con el Sunat"
                                class="form-control" value="{{ old('sunat_situation') }}">
                            @if ($errors->has('sunat_situation'))
                            <span style="color:red;">
                                {{ $errors->first('sunat_situation') }}
                            </span>
                            @endif
                        </div>

                    </div>
                    {{-- <!-- client_cellphone -->
                            <div class="form-group col-md-3">
                                <input type="text" name="client_cellphone" placeholder="Telefono" class="form-control"
                                    value="{{ old('client_cellphone') }}">
                    @if ($errors->has('client_cellphone'))
                    <span style="color:red;">
                        {{ $errors->first('client_cellphone') }}
                    </span>
                    @endif
            </div> --}}

            <div class="row">
                <!-- NOMBRE -->
                <div class="form-group col-md-8">
                    <label for="client_name">Cliente</label>
                    <input readonly type="text" value="{{ old('client_name') }}" name="client_name" id="create_client_name"
                        placeholder="Nombre" class="form-control">
                    @if ($errors->has('client_name'))
                    <span style="color:red;">
                        {{ $errors->first('client_name') }}
                    </span>
                    @endif
                </div>

                <!-- EMAIL -->
                <div class="form-group col-md-4">
                    <label for="client_email">Enviar facturas a:</label>
                    <input type="client_email" value="{{ old('client_email') }}" name="client_email" placeholder="Email"
                        class="form-control">
                    @if ($errors->has('client_email'))
                    <span style="color:red;">
                        {{ $errors->first('client_email') }}
                    </span>
                    @endif </div>
            </div>

            <!-- DOMICIO FISCAL - DIRECCION -->
            {{-- <div class="row">
                <div class="form-group col-md-12">
                    <label for="client_main_adress">Domicilio Fiscal</label>
                    <input readonly type="text" value="{{ old('client_main_adress') }}"
            name="client_main_adress" id="client_main_adress"
            placeholder="Dirección" class="form-control">
            @if ($errors->has('client_main_adress'))
            <span style="color:red;">
                {{ $errors->first('client_main_adress') }}
            </span>
            @endif
        </div>

    </div> --}}

    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
    </form>
</div>
</div>
</div>
</div>

<div class="modal fade" id="DNICreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-4">


                        <label for="dni_number">DNI a buscar</label>
                        <div class="input-group ">
                            <input type="text" id="dniToSeach" name="dniToSeach" placeholder="DNI" class="form-control">
                            <button id="searchDNI" class="btn btn-link"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>

                </div>

                <form action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <!-- RUC -->
                            <label for="dni">DNI</label>
                            <input readonly type="text" name="dni" id="dni_number" placeholder="DNI" class="form-control"
                                value="{{ old('dni') }}">
                            @if ($errors->has('dni'))
                            <span style="color:red;">
                                {{ $errors->first('dni') }}
                            </span>
                            @endif
                        </div>

                        <!-- NOMBRE -->
                        <div class="form-group col-md-8">
                            <label for="client_name">Nombres</label>
                            <input readonly type="text" value="{{ old('client_name') }}" name="client_name" id="dni_client_name"
                                placeholder="Nombre" class="form-control">
                            @if ($errors->has('client_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_name') }}
                            </span>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="client_lastname">Apellido Parterno</label>
                            <input readonly type="text" value="{{ old('client_lastname') }}" name="client_lastname" id="dni_client_lastname"
                                placeholder="Nombre" class="form-control">
                            @if ($errors->has('client_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_name') }}
                            </span>
                            @endif
                        </div>

                        <!-- EMAIL -->
                        <div class="form-group col-md-4">
                            <label for="client_email">Enviar facturas a:</label>
                            <input type="client_email" value="{{ old('client_email') }}" name="client_email"
                                placeholder="Email" class="form-control">
                            @if ($errors->has('client_email'))
                            <span style="color:red;">
                                {{ $errors->first('client_email') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <!-- DOMICIO FISCAL - DIRECCION -->
                    {{-- <div class="row">

                        <div class="form-group col-md-12">
                            <label for="client_main_adress">Domicilio Fiscal</label>
                            <input type="text" value="{{ old('client_main_adress') }}"
                    name="client_main_adress" id="dni_main_adress"
                    placeholder="Dirección" class="form-control">
                    @if ($errors->has('client_main_adress'))
                    <span style="color:red;">
                        {{ $errors->first('client_main_adress') }}
                    </span>
                    @endif
            </div>

        </div> --}}

        <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
    </div>
    </form>
</div>
</div>
</div>
</div>


{{-- SEARCH BY DATE --}}
<div class="modal fade" id="passportCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('client.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-10">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" name="client_name">
                            @if ($errors->has('client_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_name') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="">Pasaporte</label>
                            <input type="text" class="form-control" name="passport">
                            @if ($errors->has('passport'))
                            <span style="color:red;">
                                {{ $errors->first('passport') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Enviar facturas a</label>
                            <input type="text" class="form-control" name="client_email">
                            @if ($errors->has('client_email'))
                            <span style="color:red;">
                                {{ $errors->first('client_email') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class=" col-md-2">
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>

                    </div>
            </form>
        </div>
    </div>
</div>




@endsection



@section('scripts')


<script>
    $(document).ready(function () {
        $('#clients').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }

                },
                {
                    extend: 'pdfHtml5',
                    text: 'Pdf',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },


            ],
            language: {

                "decimal": "",

                "emptyTable": "No hay información",

                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",

                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",

                "infoFiltered": "(Filtrado de _MAX_ total entradas)",

                "infoPostFix": "",

                "thousands": ",",

                "lengthMenu": "Mostrar _MENU_ Entradas",

                "loadingRecords": "Cargando...",

                "processing": "Procesando...",

                "search": "Buscar:",

                "zeroRecords": "Sin resultados encontrados",

                "paginate": {

                    "first": "Primero",

                    "last": "Ultimo",

                    "next": "Siguiente",

                    "previous": "Anterior"

                }

            },

        });

        $('.select2').select2({
            theme: 'bootstrap4',
        });

        $('.select2WithTag').select2({
            theme: 'bootstrap4',
            tags: true,
        });

        // $('.select2WithTag').on('select2:select', function (e) {
        //     console.log(e);
        // });


    });

    $(function () {
        $('#searchRUC').on('click', function () {
            var ruc = $('#client_create_ruc').val();

            // var url = 'api/sunat';

            $.ajax({
                type: 'GET',
                url: '/sunat/api',
                data: 'ruc=' + ruc,
                success: function (datos_dni) {
                    var datos = eval(datos_dni);
                    var nada = 'nada';
                    var exists = 'exists'
                    // console.log(datos);
                    if (datos[0] == nada) {
                        alert('DNI o RUC no válido o no registrado');
                    } else if (datos[0] == exists) {
                        alert('El cliente que intentas agregar ya existe en el sistema');
                    } else {
                        $('#ruc_number').val(datos[0]);
                        $('#create_client_name').val(datos[1]);
                        $('#sunat_situation').val(datos[2]);
                        $('#client_main_adress').val(datos[3]);


                    }
                }
            });
            return false;
        });
    });
    $(function () {
        $('#searchDNI').on('click', function () {
            var dni = $('#dniToSeach').val();
            var url = '/reniec/api';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'dni=' + dni,
                success: function (datos_dni) {
                    var datos = eval(datos_dni);

                    if (datos[3] == "") {
                        alert('DNI no encontrado')
                    } else if (datos[0] == "") {
                        alert('Cliente ya existente en sistema');
                    } else {

                        $('#dni_number').val(datos[0]);
                        $('#dni_client_lastname').val(datos[1]);

                        $('#dni_client_name').val(datos[3]);
                    }
                }
            });
            return false;
        });
    });

    function budgetFormAction() {
        document.CreateForm.action = "/budget";
        console.log('budget');
    }

    function invoiceFormAction() {
        document.CreateForm.action = "/invoice";
        console.log('invoice');
    }

</script>
@endsection
