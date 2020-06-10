@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">

                    <h3><strong>Factura {{ $invoice->serie }} - {{ $invoice->code }}</strong></h3>

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
                            <input type="text" name="client_name" id="ruc" class="form-control-plaintext" placeholder="RUC"
                                value="{{ $invoice->client_name }}" readonly>

                        </div>
                        <div class="form-group col-md-3 form-inline">
                            @if ($invoice->ruc != null)
                            <label for="ruc">Ruc</label>
                            <input type="text" name="ruc" id="ruc" class="form-control-plaintext" placeholder="RUC"
                                value="{{ $invoice->ruc }}" readonly>
                            @else
                            <label for="ruc">DNI</label>
                            <input type="text" name="ruc" id="ruc" class="form-control-plaintext" placeholder="RUC"
                                value="{{ $invoice->dni }}" readonly>
                            @endif


                        </div>
                        <div class="form-group col-md-3">
                            <label for="client_email">Correo</label>
                            <input type="text" name="client_email" id="client_email" class="form-control-plaintext"
                                placeholder="Email" value="{{ $invoice->client_email }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="client_main_adress">Direccion</label>
                            <input type="text" name="client_main_adress" id="client_adress" class="form-control-plaintext"
                                placeholder="Direccion" value="{{ $invoice->client_main_adress }}" readonly>

                        </div>
                    </div>


                    {{-- DATOS DE FACTURA --}}
                    {{-- <h3 class="mt-4">
                            <strong>Datos de presupuesto</strong>
                        </h3> --}}
                    <div class="row mt-3">
                        {{-- FECHA DE EMISION --}}
                        <div class="form-group col-md-3">
                            <label for="emission_date">Fecha de emisión</label>
                            <input type="text" name="emission_date" id="emission_date" class="form-control-plaintext"
                                placeholder="Fecha de emision" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ $invoice->formatted_emission_date }}">

                        </div>

                        {{-- CONDICION --}}
                        <div class=" form-group col-md-3">
                            <label for="condition">Condicion</label>
                            <input type="text" name="condition" id="condition" class="form-control-plaintext"
                                placeholder="Fecha de emision" value="{{ $invoice->condition }}" readonly>

                        </div>

                        {{-- FECHA DE VENCIMIENTO --}}
                        <div class="form-group col-md-3">
                            <label for="expiration_date">Fecha de expiración</label>
                            <input type="text" name="expiration_date" id="expiration_date" class="form-control-plaintext"
                                placeholder="Fecha de emision" value="{{ $invoice->formatted_expiration_date }}"
                                readonly>

                        </div>
                        <div class="form-group col-md-3">
                            <label for="coin">Moneda</label>
                            <input type="text" name="coin" id="coin" class="form-control-plaintext" placeholder="Fecha de emision"
                                value="{{ $invoice->coin }}" readonly>
                        </div>



                    </div>
                    {{-- <div class="row ml-1 mt-4">
                    <div class="col-md-10">
                        <h3>
                            <strong>
                                Items
                            </strong>
                        </h3>
                    </div>


                </div> --}}

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

                            @if ($invoice->file)

                            <a href="{{ asset('files/'.auth()->user()->id.'/invoices/'. $invoice->file) }}">
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

                        <a href="{{ route('invoice.view.pdf',$invoice) }}">
                            <button class="btn btn-primary">
                                Imprimir o Previsualizar
                            </button>
                        </a>
                    </div>
                    <div class="col-md-2">
                        @if ($invoice->status == 'emitida' || $invoice->status =="aprobada" || $invoice->status
                        =="guardada" || $invoice->status
                        =="facturada" )

                        {{-- <a href="{{ url('pdf/invoice/'.$invoice->id.'/view?withBankAccount') }}"> --}}

                        <a href="{{ route('invoice.mail',$invoice) }}">
                            <button class="btn btn-primary">
                                Enviar por correo
                            </button>
                        </a>
                        {{-- </a> --}}
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if ($invoice->status == null || $invoice->status == 'emitida' || $invoice->status ==
                        'aprobada'|| $invoice->status
                        =="guardada" )

                        <form action="{{ route('invoice.update',$invoice) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="close">
                            <button type="submit" class="btn">Facturar <i class="fas fa-receipt"></i></button>
                        </form>
                        @endif

                    </div>
                    <div class="col-md-2">
                        @if ( $invoice->status == 'emitida')

                        <form action=" {{ route('invoice.update',$invoice) }}" method="POST">
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
                        @if ($invoice->status == 'emitida' )
                        <form action="{{ route('invoice.update',$invoice) }}" method="POST">
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
                        <a href="{{ url('pdf/invoice/'.$invoice->id.'/view?withBankAccount') }}">
                            <button class="btn btn-primary">Con cuentas bancarias</button>
                        </a>

                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('invoice.view.pdf',$invoice) }}">
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

                        <a href="{{ url('mail/invoice/'.$invoice->id.'?withBankAccount') }}">
                            <button class="btn btn-primary">Con cuentas bancarias</button>
                        </a>

                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('invoice.mail',$invoice) }}">
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
