@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3><strong>Facturas</strong></h3>

                    <div class="card-tools">

                        {{-- <button data-toggle="modal" data-target="#goodCreateModal" class="btn btn-success">
                            Agregar
                            <i class="fas fa-user-plus fa-fw"></i>
                        </button> --}}


                        <button class="btn btn-success" data-target="#createinvoiceModal" data-toggle="modal">Agregar</button>


                    </div>
                    <!-- <div class="card-tools">

              <button class="btn btn-success" @click="newModal">
                Nuevo cliente
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>-->
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>Emisión</th>
                                <th>Expiración</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->serie }} - {{ $invoice->code }}</td>
                                <td>{{ $invoice->client_name }}</td>
                                <td>{{ $invoice->emission_date }}</td>
                                <td>{{ $invoice->expiration_date }}</td>
                                <td>{{ $invoice->items()->sum('total') }}</td>
                                <td>{{ $invoice->status }}</td>
                                <td>
                                    <a href="{{ route('invoice.edit',$invoice) }}"><i class="fas fa-eye"></i></a>
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




<div class="modal fade" id="createinvoiceModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Seleccione cliente y condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('invoice.store') }}" method="POST" id="invoiceForm">
                <div class="modal-header">
                    <div class="input-group">

                        <div class="form-group col-md-5">
                            <input type="text" name="serie" id="serie" class="form-control" @if ($lastInvoice !=null)
                                value="{{ old('code',$lastInvoice->serie) }}" @endif placeholder="Codigo">
                            @if ($errors->has('serie'))
                            <span style="color:red;">
                                {{ $errors->first('serie') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-5">
                            <input type="number" name="code" id="code" class="form-control" placeholder="Empieza desde"
                                @if ($lastInvoice !=null) value="{{ old('code',$lastInvoice->code + 1) }}" @endif>
                            @if ($errors->has('code'))
                            <span style="color:red;">
                                {{ $errors->first('code') }}
                            </span>
                            @endif
                        </div>
                    </div>


                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group  col-md-7 ">

                            <select name="client_name" id="client_name" class="form-control" style="width: 100%">
                                <option value="">Nombre</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->client_name }}">{{ $client->client_name }}</option>
                                @endforeach
                            </select>
                            {{--
                                <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Nombre"
                                    value="{{ old('client_name',$invoice->client_name) }}"> --}}
                            @if ($errors->has('client_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_name') }}
                            </span>
                            @endif
                            {{-- <button class="btn btn-link" id="searchRuc"><i class="fas fa-search"></i></button>
                                --}}
                        </div>
                        <div class="form-group col-md-4 form-inline">
                            <input type="text" name="ruc" id="ruc" class="form-control" placeholder="RUC" value="{{ old('ruc') }}">
                            <button class="btn btn-link" id="searchRuc"><i class="fas fa-search"></i></button>
                            @if ($errors->has('ruc'))
                            <span style="color:red;">
                                {{ $errors->first('ruc') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-3">
                            <input type="text" name="client_email" id="client_email" class="form-control" placeholder="Email"
                                value="{{ old('client_email') }}">
                            @if ($errors->has('client_email'))
                            <span style="color:red;">
                                {{ $errors->first('client_email') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" name="client_main_adress" id="client_adress" class="form-control"
                                placeholder="Direccion" value="{{ old('client_main_adress') }}">
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

                            <input type="text" id="expiration_date" class="form-control-plaintext" placeholder="Fecha de Vencimiento"
                                readonly>
                            @if ($errors->has('expiration_date'))
                            <span style="color:red;">
                                {{ $errors->first('expiration_date') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
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
            </form>
        </div>
    </div>
</div>



@endsection





@section('scripts')

<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#table').DataTable({
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
            // var url = 'api/sunat';

            $.ajax({
                type: 'POST',
                url: '/api/clientRuc',
                data: 'ruc=' + ruc,
                success: function (datos) {
                    var datos = eval(datos);
                    var nada = 'nada';
                    if (datos[0] == nada) {
                        alert('DNI o RUC no válido o no registrado');
                    } else {


                        $('#client_email').val(datos[1]);
                        $('#client_adress').val(datos[2]);
                        // $('#client_name').val(datos[0]);

                        client_name_options += '<option value="' + datos[0] +
                            '">' +
                            datos[0] + '</option>';

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


            $.ajax({
                type: 'POST',
                url: '/api/clientName',
                data: 'name=' + name,
                success: function (response) {
                    var data = JSON.parse(response);

                    var nada = 'nada';
                    if (data[0] == nada) {
                        alert('no válido o no registrado');
                    } else {
                        $('#ruc').val(data.ruc);
                        $('#client_email').val(data.client_email);
                        $('#client_adress').val(data.client_main_adress);
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





    $(document).ready(function () {
        var client_name_options;
        var condition_options;
        const nameOldValue = "{{ old('client_name') }}";

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

</script>

@endsection
