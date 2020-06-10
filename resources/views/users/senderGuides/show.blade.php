@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">

                    <h3><strong>Guía de remisión {{ $senderGuide->serie }} - {{ $senderGuide->code }}</strong></h3>

                    <div class="card-tools">
                        <a href="{{ route('sale.index') }}">
                            <button class="btn btn-primary">
                                <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('./img/store.png') }}" alt="logo" width="150">
                        </div>
                        <div class="col-md-9">
                            <div>

                                <label for="" class="col-form-label">{{ auth()->user()->social_reason }}</label>
                            </div>
                            <div>

                                <label for="" class="col-form-label">{{ auth()->user()->ruc }}</label>
                            </div>
                            <div>

                                <label for="" class="col-form-label">{{ auth()->user()->adress }}</label>
                            </div>
                            <div>

                                <label for="" class="col-form-label">@if ($configuration->phone==true){{ auth()->user()->phone1 }},@endif
                                    @if ($configuration->email==true) {{ auth()->user()->public_email }}, @endif
                                    @if ($configuration->web==true) {{ auth()->user()->web }} @endif</label>
                            </div>
                            <div>

                                <label for="" class="col-form-label"> @if ($configuration->user_description==true){{ auth()->user()->description }}
                                    @endif</label>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-tools">

              <button class="btn btn-success" @click="newModal">
                Nuevo cliente
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>-->
                </div>
                <!-- /.card-header -->



                <div class="card-body">
                    {{-- RUC - NOMBRE- DIRECCION --}}
                    {{-- <h3>
                        <strong>Datos de Cliente</strong>
                    </h3> --}}

                    <div class="row mt-4">
                        <div class="form-group  col-md-6 ">
                            <label for="client_name">Cliente</label>
                            <input type="text" name="client_name" id="ruc" class="form-control-plaintext" placeholder="Cliente"
                                value="{{$senderGuide->client_name }}" readonly>

                        </div>
                        <div class="form-group col-md-3 form-inline">
                            @if ($senderGuide->ruc != null)
                            <label for="ruc">Ruc</label>
                            <input type="text" name="ruc" id="ruc" class="form-control-plaintext" placeholder="RUC"
                                value="{{$senderGuide->ruc }}" readonly>
                            @else
                            <label for="ruc">DNI</label>
                            <input type="text" name="ruc" id="ruc" class="form-control-plaintext" placeholder="DNI"
                                value="{{$senderGuide->dni }}" readonly>
                            @endif

                        </div>
                        <div class="form-group col-md-3">
                            <label for="client_email">Correo</label>
                            <input type="text" name="client_email" id="client_email" class="form-control-plaintext"
                                placeholder="Email" value="{{$senderGuide->client_email }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="start_point">Punto de partida</label>
                            <input type="text" name="start_point" id="client_adress" class="form-control-plaintext"
                                placeholder="Punto de partida" value="{{$senderGuide->start_point }}" readonly>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_point">Punto de llegada</label>
                            <input type="text" name="end_point" id="client_adress" class="form-control-plaintext"
                                placeholder="Punto de llegada" value="{{$senderGuide->end_point }}" readonly>

                        </div>
                    </div>



                    <div class="row mt-3">
                        {{-- FECHA DE EMISION --}}
                        <div class="form-group col-md-2">
                            <label for="emission_date">Fecha de emisión</label>
                            <input type="text" name="emission_date" id="emission_date" class="form-control-plaintext"
                                placeholder="Fecha de emision" value="{{$senderGuide->formatted_emission_date }}"
                                readonly>

                        </div>

                        {{-- CONDICION --}}
                        <div class=" form-group col-md-2">
                            <label for="reason">Motivo</label>


                            <input type="text" name="reason" id="reason" class="form-control-plaintext" placeholder="Fecha de emision"
                                value="{{$senderGuide->reason }}" readonly>



                        </div>

                        {{-- FECHA DE VENCIMIENTO --}}
                        <div class="form-group col-md-2">
                            <label for="transfer_date">Fecha de traslado</label>
                            <input type="text" name="transfer_date" id="transfer_date" class="form-control-plaintext"
                                placeholder="Fecha" value="{{$senderGuide->formatted_transfer_date }}" readonly>

                        </div>
                        <div class="form-group col-md-2">
                            <label for="licence_plate">Placa de vehículo</label>
                            <input type="text" name="licence_plate" id="licence_plate" class="form-control-plaintext"
                                placeholder="Placa" value="{{$senderGuide->licence_plate }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="driver_licence">Licencia del conductor</label>
                            <input type="text" name="driver_licence" id="driver_licence" class="form-control-plaintext"
                                placeholder="Licencia" value="{{$senderGuide->driver_licence }}" readonly>
                        </div>



                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="driver_name">Transportista</label>
                            <input type="text" name="driver_name" id="driver_name" class="form-control-plaintext"
                                placeholder="Transportista" value="{{$senderGuide->driver_name }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="driver_ruc">RUC</label>
                            <input type="text" name="driver_ruc" id="driver_ruc" class="form-control-plaintext"
                                placeholder="RUC" value="{{$senderGuide->driver_ruc }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="payer_ruc">RUC o DNI del pagador</label>
                            <input type="text" name="payer_ruc" id="payer_ruc" class="form-control-plaintext"
                                placeholder="RUC o DNI del pagador" value="{{$senderGuide->payer_ruc }}" readonly>
                        </div>
                    </div>

                    <table class="table table-hover" id="table">
                        <thead>
                            <th>#</th>
                            <th>Bienes/Servicios</th>
                            <th>Medida</th>
                            <th>Referencia</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Descuento %</th>
                            <th>Total</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->measure }}</td>
                                <td>{{ $item->reference }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->discount }}</td>
                                <td>{{ $item->total }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5"></div>
                        <div class="col-md-1">
                            <label for="sub_total" class="col-form-label">Sub total</label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="sub_total" class="form-control-plaintext" placeholder="Sub Total"
                                value="{{ $items->sum('sub_total') }}" readonly>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-1">
                            <label for="tax" class="col-form-label">IGV</label>
                        </div>
                        <div class="col-md-2">

                            <input type="number" name="tax" class="form-control-plaintext" placeholder="IGV" value="{{ $items->sum('tax')  }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-1">

                            <label for="total" class="col-form-label">Total</label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="total" class="form-control-plaintext" placeholder="Total" value="{{ $items->sum('total') }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-5">

                            @if ($senderGuide->file)

                            <a href="{{ asset('files/'.auth()->user()->id.'/senderGuides/'. $senderGuide->file) }}">
                                Ver Archivo
                            </a>

                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-3">
                        {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#printModal"> --}}

                        <a href="{{ route('senderGuide.view.pdf',$senderGuide) }}">
                            <button class="btn btn-primary">
                                Imprimir o Previsualizar
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        @if ($senderGuide->status == 'emitida' || $senderGuide->status =="aprobada" ||
                        $senderGuide->status
                        =="guardada" || $senderGuide->status
                        =="facturada" )

                        {{-- <a href="{{ url('pdf/invoice/'.$senderGuide->id.'/view?withBankAccount') }}"> --}}

                        <a href="{{ route('senderGuide.mail',$senderGuide) }}">
                            <button class="btn btn-primary">
                                Enviar por correo
                            </button>
                        </a>
                        {{-- </a> --}}
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if ($senderGuide->status == null || $senderGuide->status == 'emitida' || $senderGuide->status
                        ==
                        'aprobada'|| $senderGuide->status
                        =="guardada" )

                        <form action="{{ route('senderGuide.update',$senderGuide) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="close">
                            <button type="submit" class="btn">Facturar <i class="fas fa-receipt"></i></button>
                        </form>
                        @endif

                    </div>
                    <div class="col-md-2">
                        @if ( $senderGuide->status == 'emitida')

                        <form action=" {{ route('senderGuide.update',$senderGuide) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="rejected">
                            <button type="submit" class="btn btn-danger">
                                Rechazar
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if ($senderGuide->status == 'emitida' )
                        <form action="{{ route('senderGuide.update',$senderGuide) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="aproval">
                            <button type="submit" class="btn btn-success">
                                Aprovar
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>


<!--PRINT Modal -->
<div class="modal fade" id="printModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Imprimir o previsualizar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <a href="{{ url('pdf/invoice/'.$senderGuide->id.'/view?withBankAccount') }}">
                            <button class="btn btn-primary">Con cuentas bancarias</button>
                        </a>

                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('senderGuide.view.pdf',$senderGuide) }}">
                            <button class="
                            btn btn-secondary">Sin cuentas bancarias</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Send MAIL Modal -->
<div class="modal fade" id="mailModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Enviar por correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">

                        <a href="{{ url('mail/invoice/'.$senderGuide->id.'?withBankAccount') }}">
                            <button class="btn btn-primary">Con cuentas bancarias</button>
                        </a>

                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('senderGuide.mail',$senderGuide) }}">
                            <button class="
                            btn btn-secondary">Sin cuentas bancarias</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection




@section('scripts')

<script>
    var t = $('#table').DataTable({
        "order": [
            [1, 'asc']
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
    t.on('order.dt search.dt', function () {
        t.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

</script>



@endsection
