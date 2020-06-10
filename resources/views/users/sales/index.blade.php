@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    @include('layouts.salesTopButtons')
                    {{-- <div class="dropdown-divider" style="border: solid #000 5px;"></div> --}}




                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#searchByDateModal">

                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                        <div class="col-md-7">

                        </div>
                        <div class="d-flex">
                            <div class="dropdown">
                                <button type="button" class="btn btn-warning dropdown-toggle" id="dropdownMenuNewOperation"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-NewOperation="10,20">
                                    Nueva Operación
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuNewOperation">
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#createBudgetModal"
                                        onclick="budgetFormAction()">Cotización</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#createSenderGuideModal">Guía
                                        remisión</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#createBudgetModal"
                                        onclick="invoiceFormAction()">Factura</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#createBudgetModal"
                                        onclick="ticketFormAction()">Boleta
                                        de venta</a>
                                    <a class="dropdown-item" href="#">Venta interna</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#createNoteModal"
                                        onclick="creditNoteFormAction()">Nota
                                        de crédito</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#createNoteModal"
                                        onclick="debitNoteFormAction()">Nota
                                        de débito</a>
                                    <a class="dropdown-item" href="#">Letra de cambio</a>
                                    <a class="dropdown-item" href="#">Cobro</a>
                                    <a class="dropdown-item" href="#">Adelanto</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button type="button" class="btn btn-link dropdown-toggle" id="dropdownMenuConfiguration"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-NewOperation="10,20">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuConfiguration">
                                    <form action="{{ route('sale.config',$configuration) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('PUT')
                                        @if ($configuration->emission_date == true)

                                        <input type="checkbox" name="emission_date" id="" class="" checked>
                                        <label for="emission_date">Fecha de emisión</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="emission_date" id="" class="">
                                        <label for="emission_date">Fecha de emisión</label>
                                        <br>
                                        @endif

                                        @if ($configuration->type == true)

                                        <input type="checkbox" name="type" id="" class="" checked>
                                        <label for="type">Tipo</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="type" id="" class="">
                                        <label for="type">Tipo</label>
                                        <br>
                                        @endif

                                        @if ($configuration->number == true)

                                        <input type="checkbox" name="number" id="" class="" checked>
                                        <label for="number">Número</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="number" id="" class="">
                                        <label for="number">Número</label>
                                        <br>
                                        @endif

                                        @if ($configuration->client == true)

                                        <input type="checkbox" name="client" id="" class="" checked>
                                        <label for="client">Cliente</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="client" id="" class="">
                                        <label for="client">Cliente</label>
                                        <br>
                                        @endif

                                        @if ($configuration->expiration_date == true)

                                        <input type="checkbox" name="expiration_date" id="" class="" checked>
                                        <label for="expiration_date">Fecha de expiración</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="expiration_date" id="" class="">
                                        <label for="expiration_date">Fecha de expiración</label>
                                        <br>
                                        @endif

                                        @if ($configuration->invoiced == true)

                                        <input type="checkbox" name="invoiced" id="" class="" checked>
                                        <label for="invoiced">Facturado</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="invoiced" id="" class="">
                                        <label for="invoiced">Facturado</label>
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

                                        @if ($configuration->status == true)

                                        <input type="checkbox" name="status" id="" class="" checked>
                                        <label for="status">Estado</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="status" id="" class="">
                                        <label for="status">Estado</label>
                                        <br>
                                        @endif

                                        @if ($configuration->seller == true)

                                        <input type="checkbox" name="seller" id="" class="" checked>
                                        <label for="seller">Vendedor</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="seller" id="" class="">
                                        <label for="seller">Vendedor</label>
                                        <br>
                                        @endif

                                        @if ($configuration->unique_code == true)

                                        <input type="checkbox" name="unique_code" id="" class="" checked>
                                        <label for="unique_code">Código único</label>
                                        <br>
                                        @else
                                        <input type="checkbox" name="unique_code" id="" class="">
                                        <label for="unique_code">Código único</label>
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
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                @if ($configuration->emission_date == true)

                                <th>Fecha de emisión</th>
                                @endif

                                @if ($configuration->type == true)

                                <th>Tipo</th>
                                @endif
                                @if ($configuration->number == true)

                                <th>Número</th>
                                @endif
                                @if ($configuration->client == true)

                                <th>Cliente</th>
                                @endif
                                @if ($configuration->expiration_date == true)

                                <th>Fecha de vencimiento</th>
                                @endif
                                @if ($configuration->invoiced == true)

                                <th>Facturación</th>
                                @endif
                                @if ($configuration->debt == true)

                                <th>Deuda</th>
                                @endif
                                @if ($configuration->status == true)

                                <th>Estado</th>
                                @endif
                                @if ($configuration->seller == true)

                                <th>Vendedor</th>
                                @endif
                                @if ($configuration->unique_code == true)

                                <th>Código Único</th>
                                @endif

                                <th class="noExport">Acción</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($operations as $operation)
                            <tr>
                                @if ($configuration->emission_date == true)
                                <td>{{ $operation->emission_date }}</td>
                                @endif
                                @if ($configuration->type == true)

                                <td>
                                    <p class="text-capitalize">{{ $operation->real_type }}</p>
                                </td>
                                @endif
                                @if ($configuration->number == true)
                                <td>
                                    <a href="{{ $operation->show }}"> {{ $operation->number }}</a>

                                </td>
                                @endif
                                @if ($configuration->client == true)

                                <td>{{ $operation->client }}</td>
                                @endif
                                @if ($configuration->expiration_date == true)
                                <td>{{ $operation->expiration_date }}</td>
                                @endif
                                @if ($configuration->invoiced == true)
                                <td></td>
                                @endif
                                @if ($configuration->debt == true)
                                <td></td>
                                @endif
                                @if ($configuration->status == true)
                                <td>
                                    <p class="text-capitalize">{{ $operation->status }}</p>
                                </td>
                                @endif

                                @if ($configuration->seller == true)
                                <td></td>
                                @endif

                                @if ($configuration->unique_code == true)
                                <td></td>
                                @endif
                                <td>
                                    <div class="input-group">

                                        <a href="{{ url($operation->url) }}">Generar Cobro</a>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-link dropdown-toggle" id="dropdownMenuActions"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                data-NewOperation="10,20">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuActions">
                                                <a class="dropdown-item" href="{{ $operation->pdf_view_url }}">Imprimir</a>
                                                <a class="dropdown-item" href="#">Enviar correo cobranza</a>
                                                <form action="{{ $operation->delete_url }}" method="POST" id="deleteOpertionForm{{ $operation->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="dropdown-item" href="" onclick="event.preventDefault();
                                                     document.getElementById('deleteOpertionForm{{ $operation->id }}').submit();">Eliminar</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                            </tr>
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

{{-- SEARCH BY DATE --}}
<div class="modal fade" id="searchByDateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Busqueda por fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('sale.index') }}" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="type">Tipo</label>
                            <select name="type" id="type" class="form-control">
                                <option value="all">Todas las operaciones</option>
                                <option value="budget">Cotización</option>
                                <option value="invoice">Factura</option>
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

{{-- CREATE BUDGET MODAL --}}
<div class="modal fade" id="createBudgetModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Seleccione cliente y condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="budgetForm" name="CreateForm">

                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group  col-md-6 ">
                            <label for="client_name">Cliente</label>
                            <select name="client_name" id="client_name" class="form-control" style="width: 100%">
                                <option value="">Nombre</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->client_name }}">{{ $client->client_name }}</option>
                                @endforeach
                            </select>
                            {{--
                                <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Nombre"
                                    value="{{ old('client_name',$budget->client_name) }}"> --}}
                            @if ($errors->has('client_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_name') }}
                            </span>
                            @endif
                            {{-- <button class="btn btn-link" id="searchRuc"><i class="fas fa-search"></i></button>
                                --}}
                        </div>
                        <div class="form-group col-md-5">
                            <label for="ruc" id="rucLabel">RUC - DNI - Pasaporte</label>
                            <div class="input-group">

                                <input type="text" name="ruc" id="ruc" class="form-control" placeholder="RUC - DNI - Pasaporte"
                                    value="{{ old('ruc') }}">
                                <button class="btn btn-link" id="searchRuc"><i class="fas fa-search"></i></button>
                            </div>
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
                            <input type="text" name="client_email" id="client_email" class="form-control" placeholder="Email"
                                value="{{ old('client_email') }}">
                            @if ($errors->has('client_email'))
                            <span style="color:red;">
                                {{ $errors->first('client_email') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-8">
                            <label for="client_main_adress">Direccion</label>
                            <select name="client_main_adress" id="client_main_adress" class="form-control">

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
                            <input type="text" name="emission_date" id="emission_date" class="form-control" placeholder="Fecha de emision"
                                onfocus="(this.type='date')" onblur="(this.type='text')" value="{{ old('emission_date') }}">
                            @if ($errors->has('emission_date'))
                            <span style="color:red;">
                                {{ $errors->first('emission_date') }}
                            </span>
                            @endif
                        </div>

                        {{-- CONDICION --}}
                        <div class=" form-group col-md-3">
                            <label for="condition">Condición</label>
                            <select name="condition" id="condition" class="form-control select2" style="width: 100%">


                                <option value="">Condicion (Días)</option>

                                <option value="7">7</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="60">60</option>
                                <option value="90">90</option>
                                <option value="120">120</option>
                            </select>
                            @if ($errors->has('condition'))
                            <span style="color:red;">
                                {{ $errors->first('condition') }}
                            </span>
                            @endif
                        </div>

                        {{-- FECHA DE VENCIMIENTO --}}
                        <div class="form-group col-md-3">
                            <label for="expiration_date">Fecha de expiración</label>
                            <input type="text" id="expiration_date" class="form-control-plaintext" placeholder="Fecha de Vencimiento"
                                readonly>
                            @if ($errors->has('expiration_date'))
                            <span style="color:red;">
                                {{ $errors->first('expiration_date') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="coin">Moneda</label>
                            <select name="coin" id="coin" class="form-control select2">

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
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CREATE NOTE MODAL --}}
<div class="modal fade" id="createNoteModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Razón</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" id="noteForm" name="CreateNoteForm">
                    @csrf
                    {{-- DATOS DE FACTURA --}}
                    {{-- <h3 class="mt-4">
                    <strong>Datos de presupuesto</strong>
                </h3> --}}
                    <div class="row">

                        {{-- FECHA DE VENCIMIENTO --}}

                        <div class="form-group col-md-12">
                            <label for="reason">Razón</label>
                            <input type="text" name="reason" id="reason" class="form-control" placeholder="Razón">
                            @if ($errors->has('reason'))
                            <span style="color:red;">
                                {{ $errors->first('reason') }}
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
</div>
{{-- CREATE BUDGET MODAL --}}
<div class="modal fade" id="createSenderGuideModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Seleccione cliente y condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('senderGuide.store') }}">

                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group  col-md-6 ">
                            <label for="client_name">Cliente</label>
                            <select name="client_name" id="SG_client_name" class="form-control" style="width: 100%">
                                <option value="">Nombre</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->client_name }}">{{ $client->client_name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('client_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_name') }}
                            </span>
                            @endif

                        </div>
                        <div class="form-group col-md-5">
                            <label for="ruc" id="SG_rucLabel">RUC - DNI - Pasaporte</label>
                            <div class="input-group">

                                <input type="text" name="ruc" id="SG_ruc" class="form-control" placeholder="RUC - DNI - Pasaporte"
                                    value="{{ old('ruc') }}">
                                <button class="btn btn-link" id="SG_searchRuc"><i class="fas fa-search"></i></button>
                            </div>
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
                            <input type="text" name="client_email" id="SG_client_email" class="form-control"
                                placeholder="Email" value="{{ old('client_email') }}">
                            @if ($errors->has('client_email'))
                            <span style="color:red;">
                                {{ $errors->first('client_email') }}
                            </span>
                            @endif
                        </div>

                        {{-- FECHA DE EMISION --}}
                        <div class="form-group col-md-3">
                            <label for="emission_date">Fecha de emisión</label>
                            <input type="text" name="emission_date" id="SG_emission_date" class="form-control"
                                placeholder="Fecha de emision" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ old('emission_date') }}">
                            @if ($errors->has('emission_date'))
                            <span style="color:red;">
                                {{ $errors->first('emission_date') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="transfer_date">Fecha de traslado</label>
                            <input type="text" name="transfer_date" id="SG_transfer_date" class="form-control"
                                placeholder="Fecha de traslado" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ old('transfer_date') }}">
                            @if ($errors->has('transfer_date'))
                            <span style="color:red;">
                                {{ $errors->first('transfer_date') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="reason">Motivo</label>
                            <input type="text" name="reason" id="SG_reason" class="form-control" placeholder="Motivo"
                                value="{{ old('reason') }}">
                            @if ($errors->has('reason'))
                            <span style="color:red;">
                                {{ $errors->first('reason') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="start_point">Punto de partida</label>
                            <input type="text" name="start_point" id="SG_start_point" class="form-control" placeholder="Punto de partida"
                                value="{{ old('start_point') }}">
                            @if ($errors->has('start_point'))
                            <span style="color:red;">
                                {{ $errors->first('start_point') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_point">Punto de llegada</label>
                            <input type="text" name="end_point" id="SG_end_point" class="form-control" placeholder="Punto de llegada"
                                value="{{ old('end_point') }}">
                            @if ($errors->has('end_point'))
                            <span style="color:red;">
                                {{ $errors->first('end_point') }}
                            </span>
                            @endif
                        </div>

                    </div>
                    <div class="row ">
                        <div class="form-group col-md-4">
                            <label for="licence_plate">Placa del vehículo</label>
                            <input type="text" name="licence_plate" id="SG_licence_plate" class="form-control"
                                placeholder="Placa del vehículo" value="{{ old('licence_plate') }}">
                            @if ($errors->has('licence_plate'))
                            <span style="color:red;">
                                {{ $errors->first('licence_plate') }}
                            </span>
                            @endif
                        </div>

                        {{-- FECHA DE EMISION --}}
                        <div class="form-group col-md-4">
                            <label for="car_brand">Marca del vehículo</label>
                            <input type="text" name="car_brand" id="SG_car_brand" class="form-control" placeholder="Marca del vehículo"
                                value="{{ old('car_brand') }}">
                            @if ($errors->has('car_brand'))
                            <span style="color:red;">
                                {{ $errors->first('car_brand') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="driver_licence">Licencia del conductor</label>
                            <input type="text" name="driver_licence" id="SG_driver_licence" class="form-control"
                                placeholder="Licencia del conductor" value="{{ old('driver_licence') }}">
                            @if ($errors->has('driver_licence'))
                            <span style="color:red;">
                                {{ $errors->first('driver_licence') }}
                            </span>
                            @endif
                        </div>



                    </div>
                    <div class="row ">
                        <div class="form-group col-md-4">
                            <label for="driver_name">Nombre del transportista</label>
                            <input type="text" name="driver_name" id="SG_driver_name" class="form-control" placeholder="Placa del vehículo"
                                value="{{ old('driver_name') }}">
                            @if ($errors->has('driver_name'))
                            <span style="color:red;">
                                {{ $errors->first('driver_name') }}
                            </span>
                            @endif
                        </div>

                        {{-- FECHA DE EMISION --}}
                        <div class="form-group col-md-4">
                            <label for="driver_ruc">RUC</label>
                            <input type="text" name="driver_ruc" id="SG_driver_ruc" class="form-control" placeholder="RUC"
                                value="{{ old('driver_ruc') }}">
                            @if ($errors->has('driver_ruc'))
                            <span style="color:red;">
                                {{ $errors->first('driver_ruc') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="payer_ruc">RUC o DNI del pagador</label>
                            <input type="text" name="payer_ruc" id="SG_driver_licence" class="form-control"
                                placeholder="RUC o DNI del pagador" value="{{ old('payer_ruc') }}">
                            @if ($errors->has('payer_ruc'))
                            <span style="color:red;">
                                {{ $errors->first('payer_ruc') }}
                            </span>
                            @endif
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function (data, row, column, node) {
                        // Strip $ from salary column to make it numeric
                        return data;
                    }
                }
            }
        };

        $('#table').dataTable({
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
    });
    $(function () {
        $('#searchRuc').on('click', function () {
            var ruc = $('#ruc').val();
            var client_name_options;
            var adresses_options;
            // var url = 'api/sunat';

            $.ajax({
                type: 'GET',
                url: '/byRuc/api',
                data: 'ruc=' + ruc,
                success: function (datos) {
                    var datos = JSON.parse(datos);
                    console.log(datos.adresses.length);
                    var nada = 'nada';
                    if (datos[0] == nada) {
                        alert('DNI o RUC no válido o no registrado');
                    } else {


                        $('#client_email').val(datos.client_email);
                        //$('#client_adress').val(datos[2]);
                        // $('#client_name').val(datos[0]);

                        client_name_options += '<option value="' + datos.client_name +
                            '">' +
                            datos.client_name + '</option>';

                        if (datos.adresses.length > 0) {


                            for (let index = 0; index < datos.adresses.length; index++) {
                                adresses_options += '<option value="' +
                                    datos.adresses[index].client_adress + '">' + datos.adresses[
                                        index].client_adress + '</option>';
                                $('#client_main_adress').html(adresses_options);
                            }
                        } else {
                            adresses_options =
                                '<option value="">No tiene direcciones registradas</option>';
                            $('#client_main_adress').html(adresses_options);
                        }
                        $('#client_name').html(client_name_options);
                    }
                }
            });
            return false;
        });
    });
    $(function () {
        $('#client_name').on('change', function () {
            var name = $('#client_name').val();
            var adresses_options;

            $.ajax({
                type: 'GET',
                url: '/byName/api',
                data: 'name=' + name,
                success: function (response) {
                    var data = JSON.parse(response);

                    var nada = 'nada';
                    if (data[0] == nada) {
                        alert('no válido o no registrado');
                    } else {
                        if (data['client'].ruc != null) {
                            $('#ruc').val(data['client'].ruc);
                            $('#rucLabel').html('RUC');
                        } else if (data['client'].dni != null) {
                            $('#ruc').val(data['client'].dni);
                            $('#rucLabel').html('DNI');
                        } else {
                            $('#ruc').val(data['client'].passport);
                            $('#rucLabel').html('Pasaporte');
                        }
                        $('#client_email').val(data['client'].client_email);

                        if (data['adresses'].length > 0) {

                            for (let index = 0; index < data['adresses'].length; index++) {
                                adresses_options += '<option value="' +
                                    data['adresses'][index].client_adress + '">' + data[
                                        'adresses'][index].client_adress + '</option>';
                                $('#client_main_adress').html(adresses_options);
                            }
                        } else {
                            adresses_options =
                                '<option value="">No tiene direcciones registradas</option>';
                            $('#client_main_adress').html(adresses_options);
                        }
                        //$('#client_adress').val(data['client'].client_main_adress);
                    } //$('#brand').val(data[0].brand); //

                }
            });
            return false;
        });
    });
    $(function () {
        $('#SG_searchRuc').on('click', function () {
            var ruc = $('#SG_ruc').val();
            var client_name_options;
            var adresses_options;
            // var url = 'api/sunat';

            $.ajax({
                type: 'GET',
                url: '/byRuc/api',
                data: 'ruc=' + ruc,
                success: function (datos) {
                    var datos = JSON.parse(datos);
                    console.log(datos.adresses.length);
                    var nada = 'nada';
                    if (datos[0] == nada) {
                        alert('DNI o RUC no válido o no registrado');
                    } else {


                        $('#SG_client_email').val(datos.client_email);
                        //$('#SG_client_adress').val(datos[2]);
                        // $('#SG_client_name').val(datos[0]);

                        client_name_options += '<option value="' + datos.client_name +
                            '">' +
                            datos.client_name + '</option>';

                        if (datos.adresses.length > 0) {


                            for (let index = 0; index < datos.adresses.length; index++) {
                                adresses_options += '<option value="' +
                                    datos.adresses[index].client_adress + '">' + datos.adresses[
                                        index].client_adress + '</option>';
                                $('#SG_client_main_adress').html(adresses_options);
                            }
                        } else {
                            adresses_options =
                                '<option value="">No tiene direcciones registradas</option>';
                            $('#SG_client_main_adress').html(adresses_options);
                        }
                        $('#SG_client_name').html(client_name_options);
                    }
                }
            });
            return false;
        });
    });
    $(function () {
        $('#SG_client_name').on('change', function () {
            var name = $('#SG_client_name').val();
            var adresses_options;

            $.ajax({
                type: 'GET',
                url: '/byName/api',
                data: 'name=' + name,
                success: function (response) {
                    var data = JSON.parse(response);

                    var nada = 'nada';
                    if (data[0] == nada) {
                        alert('no válido o no registrado');
                    } else {
                        if (data['client'].ruc != null) {
                            $('#SG_ruc').val(data['client'].ruc);
                            $('#SG_rucLabel').html('RUC');
                        } else if (data['client'].dni != null) {
                            $('#SG_ruc').val(data['client'].dni);
                            $('#SG_rucLabel').html('DNI');
                        } else {
                            $('#SG_ruc').val(data['client'].passport);
                            $('#SG_rucLabel').html('Pasaporte');
                        }
                        $('#SG_client_email').val(data['client'].client_email);

                        if (data['adresses'].length > 0) {

                            for (let index = 0; index < data['adresses'].length; index++) {
                                adresses_options += '<option value="' +
                                    data['adresses'][index].client_adress + '">' + data[
                                        'adresses'][index].client_adress + '</option>';
                                $('#SG_client_main_adress').html(adresses_options);
                            }
                        } else {
                            adresses_options =
                                '<option value="">No tiene direcciones registradas</option>';
                            $('#SG_client_main_adress').html(adresses_options);
                        }
                        //$('#client_adress').val(data['client'].client_main_adress);
                    } //$('#brand').val(data[0].brand); //

                }
            });
            return false;
        });
    });


    $('#condition').select2({
        theme: 'bootstrap4',
        tags: true,
    });
    $('#client_name').select2({
        theme: 'bootstrap4',
    });
    $('#SG_condition').select2({
        theme: 'bootstrap4',
        tags: true,
    });
    $('#SG_client_name').select2({
        theme: 'bootstrap4',
    });






    $(document).ready(function () {
        var client_name_options;
        var condition_options;
        var adress_options;
        const nameOldValue = "{{ old('client_name') }}";
        const adressOldValue = "{{ old('client_main_adress') }}";

        const conditionOldValue = "{{ old('condition') }}";

        if (nameOldValue != '') {
            // $('#client_name').val(nameOldValue);
            // $('.myList').select2({}).select2('val', PRESELECTED_FRUITS);
            client_name_options += '<option value="' + nameOldValue +
                '">' +
                nameOldValue + '</option>';

            $('#client_name').html(client_name_options);
        }
        if (conditionOldValue != '') {
            condition_options += '<option value="' + conditionOldValue +
                '">' +
                conditionOldValue + '</option>';

            $('#condition').html(condition_options);
        }
        if (adressOldValue != '') {
            adress_options += '<option value="' + adressOldValue +
                '">' +
                adressOldValue + '</option>';

            $('#client_main_adress').html(adress_options);
        }
    });


    $('#emission_date').on('change', function () {
        var emission = moment($(this).val());
        var condition = $('#condition').val();
        var expiration = emission.add(condition, 'd').format('DD/MM/YYYY');

        if (expiration != 'Invalid date') {
            $('#expiration_date').val(expiration);

        }



    })

    $('#condition').on('change', function () {
        var emission = moment($('#emission_date').val());
        var condition = $(this).val();
        var expiration = emission.add(condition, 'd').format('DD/MM/YYYY');

        if (expiration != 'Invalid date') {
            $('#expiration_date').val(expiration);

        }

    })

    function budgetFormAction() {
        document.CreateForm.action = "/budget";
    }

    function invoiceFormAction() {
        document.CreateForm.action = "/invoice";
    }

    function ticketFormAction() {
        document.CreateForm.action = "/ticket";
    }

    function debitNoteFormAction() {
        document.CreateNoteForm.action = "/debitNote";
    }

    function creditNoteFormAction() {
        document.CreateNoteForm.action = "/creditNote";
    }

</script>

@endsection
