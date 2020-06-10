@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nuevo Cliente</h3>
                    <div class="card-tools">
                        <a href="{{ route('client.index') }}">

                            <button class="btn btn-danger">
                                Salir
                                <i class="fas fa-times"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="modal-body">
                        <div class="form-group col-md-3">
                            <h5>
                                <strong>Informacion de la cliente</strong>
                                <input type="hidden" name="client_id" id="client_id">
                            </h5>
                            <label for="ruc_number">Ruc a buscar</label>
                            <div class="input-group">
                                <input type="text" id="ruc" name="ruc_number" placeholder="RUC" class="form-control">
                                <button id="searchRUC" class="btn btn-link"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>

                        <form action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <!-- RUC -->
                                    <label for="ruc">RUC</label>
                                    <input readonly type="text" name="ruc" id="ruc_number" placeholder="RUC o DNI"
                                        class="form-control" value="{{ old('ruc') }}">
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
                            <input readonly type="text" value="{{ old('client_name') }}" name="client_name" id="client_name"
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
                            @endif </div>
                    </div>

                    <!-- DOMICIO FISCAL - DIRECCION -->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="client_main_adress">Domicilio Fiscal</label>
                            <input readonly type="text" value="{{ old('client_main_adress') }}" name="client_main_adress"
                                id="client_main_adress" placeholder="Dirección" class="form-control">
                            @if ($errors->has('client_main_adress'))
                            <span style="color:red;">
                                {{ $errors->first('client_main_adress') }}
                            </span>
                            @endif
                        </div>
                        <!-- <div class="form-group ml-4">
                    <a href>Agregar mas domicilo</a>
                  </div>-->
                    </div>

                    <div class="form-group">
                        <h5>
                            <strong>Informacion de contacto</strong>
                        </h5>
                    </div>
                    <div class="row">
                        <!-- CONTACTO - NOMBRE -->
                        <div class="form-group col-md-1">
                            <label for="client_contact_name">Nombre</label>
                            <input type="text" value="{{ old('client_contact_name') }}" name="client_contact_name"
                                class="form-control " readonly>
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-1">
                            <label for="client_contact_surname">Apellido</label>
                            <input type="text" value="{{ old('client_contact_surname') }}" name="client_contact_surname"
                                class="form-control " readonly>
                            @if ($errors->has('client_contact_surname'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_surname') }}
                            </span>
                            @endif
                        </div>

                        <!-- CONTACTO - EMAIL -->
                        <div class="form-group col-md-1">
                            <label for="client_contact_email">E-mail</label>
                            <input type="text" value="{{ old('client_contact_email') }}" name="client_contact_email"
                                class="form-control" readonly>
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif </div>
                        <!-- CONTACTO - CELULAR -->
                        <div class="form-group col-md-1">
                            <label for="client_contact_cellphone">Móvil</label>
                            <input type="text" value="{{ old('client_contact_cellphone') }}" name="client_contact_cellphone"
                                class="form-control" readonly>
                            @if ($errors->has('client_contact_cellphone'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_cellphone') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - TELEFONO -->
                        <div class="form-group col-md-1">
                            <label for="client_contact_phone">Teléfono</label>
                            <input type="text" value="{{ old('client_contact_phone') }}" name="client_contact_phone"
                                class="form-control" readonly>
                            @if ($errors->has('client_contact_phone'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_phone') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - ANEXO -->
                        <div class="form-group col-md-1">
                            <label for="client_contact_anexo">Anexo</label>
                            <input type="text" value="{{ old('client_contact_anexo') }}" name="client_contact_anexo"
                                class="form-control" readonly>
                            @if ($errors->has('client_contact_anexo'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_anexo') }}
                            </span>
                            @endif
                        </div>

                        <!-- CONTACTO - CARGO -->
                        <div class="form-group col-md-1">
                            <label for="client_contact_charge">Cargo</label>
                            <input type="text" value="{{ old('client_contact_charge') }}" name="client_contact_charge"
                                class="form-control" readonly>
                            @if ($errors->has('client_contact_charge'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_charge') }}
                            </span>
                            @endif </div>
                        <!-- CONTACTO - CUMPLEAÑOS -->
                        <div class="form-group col-md-2">
                            <label for="client_contact_birthday">Cumpleaños</label>
                            <input  name="client_contact_birthday" id="client_contact_birthday" class="form-control"
                                type="text" onfocus="(this.type='date')" onblur="(this.type='text')" value="{{ old('client_contact_birthday') }}"
                                id="date" readonly>
                            @if ($errors->has('client_contact_birthday'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_birthday') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - RESPONSABLE POR -->
                        <div class="form-group col-md-2">
                            <label for="client_contact_responsableFor">Responsable de</label>
                            <input type="text" value="{{ old('client_contact_responsableFor') }}" name="client_contact_responsableFor"
                                class="form-control" readonly>

                            @if ($errors->has('client_contact_responsableFor'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_responsableFor') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <button class="btn btn-link" data-toggle="modal" data-target="#contactCreateModal" onclick="contactClientId()">Agregar
                            información de contacto</button>
                    </div>
                    <div class="form-group">
                        <h5>
                            <strong>Acuerdos</strong>
                        </h5>
                    </div>
                    <div class="row">
                        <!-- ACUERDOS - CONDICIONES DE PAGO -->
                        <div class="form-group col-md-4">
                            <label for="conditions">Condiciones de pago</label>
                            <select name="conditions" id="conditions" class="form-control select2WithTags">
                                <option value="1">Espera</option>

                            </select>
                            @if ($errors->has('conditions'))
                            <span style="color:red;">
                                {{ $errors->first('conditions') }}
                            </span>
                            @endif
                        </div>
                        <!-- ACUERDOS - LINEA DE CREDITO -->
                        <div class="form-group col-md-4">
                            <label for="credit_line">Línea de crédito aprobada</label>
                            <select name="credit_line" id="credit_line" class="form-control select2WithTags">
                                <option value>Línea de crédito</option>
                                <option value="1">10 días</option>
                                <option value="2">15 días</option>
                                <option value="30">30 días</option>
                                <option value="60">60 días</option>
                                <option value="90">90 días</option>
                            </select>
                            @if ($errors->has('credit_line'))
                            <span style="color:red;">
                                {{ $errors->first('credit_line') }}
                            </span>
                            @endif
                        </div>
                        <!-- ACUERDOS - MEDIO DE PAGO PREFERIDO -->
                        <div class="form-group col-md-4">
                            <label for="pay_method">Medio de pago preferido</label>
                            <select name="pay_method" id="pay_method" class="form-control select2WithTags">
                                <option value>Medio de pago</option>
                                @foreach ($pay_options as $option)
                                <option value="{{ $option->code }}">[{{ $option->code }}]{{ $option->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('pay_method'))
                            <span style="color:red;">
                                {{ $errors->first('pay_method') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <h5>
                            <strong>Deuda</strong>
                        </h5>
                    </div>
                    <div class="row">
                        <!-- DEUDA - TIPO DE DOCUMENTO -->
                        <div class="form-group col-md-2">
                            <label for="document_type">Tipo de documento</label>
                            <select class="form-control select2WithTags" name="document_type" id="document_type" style="width: 100%">
                                <option value="">Documento</option>
                                @foreach ($document_type_options as $option)
                                <option value="{{ $option->code }}">[{{ $option->code }}]{{ $option->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('document_type'))
                            <span style="color:red;">
                                {{ $errors->first('document_type') }}
                            </span>
                            @endif
                        </div>
                        <!-- DEUDA - TIPO DE DOCUMENTO -->
                        <div class="form-group col-md-2">
                            <label for="document_number">Nro. documento</label>
                            <input type="text" value="{{ old('document_number') }}" name="document_number" placeholder="Nro. documento"
                                class="form-control">

                            @if ($errors->has('document_number'))
                            <span style="color:red;">
                                {{ $errors->first('document_number') }}
                            </span>
                            @endif
                        </div>

                        <!-- DEUDA - FECHA EMISION -->
                        <div class="form-group col-md-2">
                            <label for="document_emission">Fecha emisión</label>
                            <input required name="document_emission" id="document_emission" placeholder="Fecha de Emision"
                                class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ old('document_emission') }}" id="date">
                            @if ($errors->has('document_emission'))
                            <span style="color:red;">
                                {{ $errors->first('document_emission') }}
                            </span>
                            @endif
                        </div>
                        <!-- DEUDA - FECHA VENCIMIENTO -->
                        <div class="form-group col-md-2">
                            <label for="document_expiration">Vencimiento</label>
                            <input required name="document_expiration" id="document_expiration" placeholder="Fecha de Vencimiento"
                                class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ old('document_expiration') }}" id="date">

                            @if ($errors->has('document_expiration'))
                            <span style="color:red;">
                                {{ $errors->first('document_expiration') }}
                            </span>
                            @endif
                        </div>
                        <!-- DEUDA - SALDO DEUDA -->
                        <div class="form-group col-md-2">
                            <label for="debt">Saldo deuda</label>
                            <input type="text" value="{{ old('debt') }}" name="debt" placeholder="Saldo deuda" class="form-control">
                            @if ($errors->has('debt'))
                            <span style="color:red;">
                                {{ $errors->first('debt') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <label class="custom-file" id="customFile">Agregar un archivo <i class="fas fa-file-upload"></i>
                                <input type="file" name="file" class="custom-filse-input" id="exampleInputFile"
                                    aria-describedby="fileHelp">
                                <span class="custom-file-control form-control-file"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crear</button>

                </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"></div>
        </div>
        <!-- /.card -->
    </div>
</div>


<!--CREATE CONTACT Modal -->
<div class="modal fade" id="contactCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Contacto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="client_id" id="contact_client_id" value="">
                    <div class="row">
                        <!-- CONTACTO - NOMBRE -->
                        <div class="form-group col-md-2">
                            <label for="client_contact_name">Nombre</label>
                            <input type="text" value="{{ old('client_contact_name') }}" name="client_contact_name"
                                placeholder="Nombre" class="form-control" required>
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-2">
                            <label for="client_contact_surname">Apellido</label>
                            <input type="text" value="{{ old('client_contact_name') }}" name="client_contact_surname"
                                placeholder="Apellido" class="form-control" required>
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif
                        </div>

                        <!-- CONTACTO - CELULAR -->
                        <div class="form-group col-md-3">
                            <label for="client_contact_cellphone">Móvil</label>
                            <input required type="text" value="{{ old('client_contact_cellphone') }}" name="client_contact_cellphone"
                                placeholder="Celular" class="form-control">
                            @if ($errors->has('client_contact_cellphone'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_cellphone') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - TELEFONO -->
                        <div class="form-group col-md-3">
                            <label for="client_contact_phone">Teléfono</label>
                            <input required type="text" value="{{ old('client_contact_phone') }}" name="client_contact_phone"
                                placeholder="Telefono" class="form-control">
                            @if ($errors->has('client_contact_phone'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_phone') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - ANEXO -->
                        <div class="form-group col-md-2">
                            <label for="client_contact_anexo">Anexo</label>
                            <input required type="text" value="{{ old('client_contact_anexo') }}" name="client_contact_anexo"
                                placeholder="Anexo" class="form-control">
                            @if ($errors->has('client_contact_anexo'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_anexo') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <!-- CONTACTO - EMAIL -->
                        <div class="form-group col-md-3">
                            <label for="client_contact_email">E-mail</label>
                            <input required type="text" value="{{ old('client_contact_email') }}" name="client_contact_email"
                                placeholder="Correo" class="form-control">
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif </div>
                        <!-- CONTACTO - CARGO -->
                        <div class="form-group col-md-3">
                            <label for="client_contact_charge">Cargo</label>
                            <input required type="text" value="{{ old('client_contact_charge') }}" name="client_contact_charge"
                                placeholder="Cargo" class="form-control">
                            @if ($errors->has('client_contact_charge'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_charge') }}
                            </span>
                            @endif </div>
                        <!-- CONTACTO - CUMPLEAÑOS -->
                        <div class="form-group col-md-3">
                            <label for="birthday">Cumpleaños</label>
                            {{-- <input required type="date" value="{{ old('client_contact_birthday') }}"
                            name="client_contact_birthday"
                            placeholder="Cumpleaños" class="form-control "> --}}
                            <input required name="client_contact_birthday" id="client_contact_birthday" placeholder="Cumpleaños"
                                class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ old('client_contact_birthday') }}" id="date">

                            @if ($errors->has('client_contact_birthday'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_birthday') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - RESPONSABLE POR -->
                        <div class="form-group col-md-3">
                            <label for="client_contact_responsableFor">Responsable de:</label>
                            <input required type="text" value="{{ old('client_contact_responsableFor') }}" name="client_contact_responsableFor"
                                placeholder="Responsable Por" class="form-control">

                            @if ($errors->has('client_contact_responsableFor'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_responsableFor') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/depending_selectors.js') }}"></script>
<script>
    $(function () {
        $('#searchRUC').on('click', function () {
            var ruc = $('#ruc').val();

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
                        $('#client_name').val(datos[1]);
                        $('#sunat_situation').val(datos[2]);
                        $('#client_main_adress').val(datos[3]);
                        $('#client_id').val(datos[4]);

                    }
                }
            });
            return false;
        });
    });

</script>


<script>
    $('.custom-file-input').on('change', function () {
        var fileName = document.getElementById("exampleInputFile").files[0].name;
        $(this).next('.form-control-file').addClass("selected").html(fileName);
    })

    /* method 2 - change file input to text input after selection
    $('.custom-file-input').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.form-control-file').hide();
        $(this).toggleClass('form-control custom-file-input').attr('type','text').val(fileName);
    })
    */

    $('.select2WithTags').select2({
        theme: 'bootstrap4',
        tags: true,
    });


    function contactClientId() {
        var client_id = document.getElementById('client_id').value;
        document.getElementById('contact_client_id').value = client_id;

    }

</script>
@endsection
