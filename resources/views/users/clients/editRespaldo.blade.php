@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>

                    <div class="card-tools">
                        <a href="{{ route('user.index') }}">
                            <button class="btn btn-danger">
                                Salir
                                <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <form action="{{ route('user.update',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <h5>
                                    <strong>Informacion de la cliente</strong>
                                </h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <!-- RUC -->
                                    <input type="text" name="ruc" placeholder="RUC o DNI" class="form-control" value="{{ old('ruc',$user->ruc) }}">
                                    @if ($errors->has('ruc'))
                                    <span style="color:red;">
                                        {{ $errors->first('ruc') }}
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-3">
                                    <!-- client_cellphone -->
                                    <input type="text" name="client_cellphone" placeholder="Telefono" class="form-control"
                                        value="{{ old('client_cellphone',$user->client_cellphone) }}">
                                    @if ($errors->has('client_cellphone'))
                                    <span style="color:red;">
                                        {{ $errors->first('client_cellphone') }}
                                    </span>
                                    @endif
                                </div>

                                <!-- SITUACION SUNAT -->
                                <div class="form-group col-md-6">
                                    <input type="text" name="sunat_situation" placeholder="Situacion con el Sunat"
                                        class="form-control" value="{{ old('sunat_situation',$user->sunat_situation) }}">
                                    @if ($errors->has('sunat_situation'))
                                    <span style="color:red;">
                                        {{ $errors->first('sunat_situation') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <!-- NOMBRE -->
                                <div class="form-group col-md-8">
                                    <input type="text" value="{{ old('name',$user->name) }}" name="name" placeholder="Nombre"
                                        class="form-control">
                                    @if ($errors->has('name'))
                                    <span style="color:red;">
                                        {{ $errors->first('name') }}
                                    </span>
                                    @endif
                                </div>

                                <!-- EMAIL -->
                                <div class="form-group col-md-4">
                                    <input type="email" value="{{ old('email',$user->email) }}" name="email"
                                        placeholder="Email de registro" class="form-control">
                                    @if ($errors->has('email'))
                                    <span style="color:red;">
                                        {{ $errors->first('email') }}
                                    </span>
                                    @endif </div>
                            </div>

                            {{-- <div class="form-group">
                                <h5>
                                    <strong>Direccion fiscal</strong>
                                </h5>





                                <!-- DOMICIO FISCAL - DIRECCION -->
                                <div class="row" id="adresses">
                                    <div class="form-group col-md-12">
                                        <input type="text" value="{{ old('client_adress',$user->adresses()->first()->client_adress) }}"
                            name="client_adress" placeholder="Dirección" class="form-control">
                            @if ($errors->has('client_adress'))
                            <span style="color:red;">
                                {{ $errors->first('client_adress') }}
                            </span>
                            @endif
                        </div>
                </div>

                <div class="form-group">
                    <h5>
                        <strong>Informacion de contacto</strong>
                    </h5>
                </div>
                <div class="row">
                    <!-- CONTACTO - NOMBRE -->
                    <div class="form-group col-md-3">
                        <input type="text" value="{{ old('client_contact_name',$user->contacts()->first()->client_contact_name) }}"
                            name="client_contact_name" placeholder="Nombre y Apellido" class="form-control">
                        @if ($errors->has('client_contact_name'))
                        <span style="color:red;">
                            {{ $errors->first('client_contact_name') }}
                        </span>
                        @endif
                    </div>

                    <!-- CONTACTO - CELULAR -->
                    <div class="form-group col-md-3">
                        <input type="text" value="{{ old('client_contact_cellphone',$user->contacts()->first()->client_contact_cellphone) }}"
                            name="client_contact_cellphone" placeholder="Celular" class="form-control">
                        @if ($errors->has('client_contact_cellphone'))
                        <span style="color:red;">
                            {{ $errors->first('client_contact_cellphone') }}
                        </span>
                        @endif
                    </div>
                    <!-- CONTACTO - TELEFONO -->
                    <div class="form-group col-md-3">
                        <input type="text" value="{{ old('client_contact_phone',$user->contacts()->first()->client_contact_phone) }}"
                            name="client_contact_phone" placeholder="Telefono" class="form-control">
                        @if ($errors->has('client_contact_phone'))
                        <span style="color:red;">
                            {{ $errors->first('client_contact_phone') }}
                        </span>
                        @endif
                    </div>
                    <!-- CONTACTO - ANEXO -->
                    <div class="form-group col-md-3">
                        <input type="text" value="{{ old('client_contact_anexo',$user->contacts()->first()->client_contact_anexo) }}"
                            name="client_contact_anexo" placeholder="Anexo" class="form-control">
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
                        <input type="text" value="{{ old('client_contact_email',$user->contacts()->first()->client_contact_email) }}"
                            name="client_contact_email" placeholder="Correo" class="form-control">
                        @if ($errors->has('client_contact_name'))
                        <span style="color:red;">
                            {{ $errors->first('client_contact_name') }}
                        </span>
                        @endif </div>
                    <!-- CONTACTO - CARGO -->
                    <div class="form-group col-md-3">
                        <input type="text" value="{{ old('client_contact_charge',$user->contacts()->first()->client_contact_charge) }}"
                            name="client_contact_charge" placeholder="Cargo" class="form-control">
                        @if ($errors->has('client_contact_charge'))
                        <span style="color:red;">
                            {{ $errors->first('client_contact_charge') }}
                        </span>
                        @endif </div>
                    <!-- CONTACTO - CUMPLEAÑOS -->
                    <div class="form-group col-md-3">
                        <input type="date" value="{{ old('client_contact_birthday',$user->contacts()->first()->client_contact_birthday) }}"
                            name="client_contact_birthday" placeholder="Nombre" class="form-control">
                        @if ($errors->has('client_contact_birthday'))
                        <span style="color:red;">
                            {{ $errors->first('client_contact_birthday') }}
                        </span>
                        @endif
                    </div>
                    <!-- CONTACTO - RESPONSABLE POR -->
                    <div class="form-group col-md-3">
                        <input type="text" value="{{ old('client_contact_responsableFor',$user->contacts()->first()->client_contact_responsableFor) }}"
                            name="client_contact_responsableFor" placeholder="Responsable Por" class="form-control">

                        @if ($errors->has('client_contact_responsableFor'))
                        <span style="color:red;">
                            {{ $errors->first('client_contact_responsableFor') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <h5>
                        <strong>Acuerdos</strong>
                    </h5>
                </div>
                <div class="row">
                    <!-- ACUERDOS - CONDICIONES DE PAGO -->
                    <div class="form-group col-md-4">
                        <select name="conditions" id="conditions" class="form-control">
                            <option value>Condiciones de pago</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        @if ($errors->has('conditions'))
                        <span style="color:red;">
                            {{ $errors->first('conditions') }}
                        </span>
                        @endif
                    </div>
                    <!-- ACUERDOS - LINEA DE CREDITO -->
                    <div class="form-group col-md-4">
                        <select name="credit_line" id="credit_line" class="form-control">
                            <option value>Linea de credito</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        @if ($errors->has('credit_line'))
                        <span style="color:red;">
                            {{ $errors->first('credit_line') }}
                        </span>
                        @endif
                    </div>
                    <!-- ACUERDOS - MEDIO DE PAGO PREFERIDO -->
                    <div class="form-group col-md-4">
                        <select name="pay_method" id="pay_method" class="form-control">
                            <option value>Metodo de pago</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
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
                        <input type="text" value="{{ old('document_type',$user->debts()->first()->document_type) }}"
                            name="document_type" placeholder="Tipo de documento" class="form-control">

                        @if ($errors->has('document_type'))
                        <span style="color:red;">
                            {{ $errors->first('document_type') }}
                        </span>
                        @endif
                    </div>
                    <!-- DEUDA - TIPO DE DOCUMENTO -->
                    <div class="form-group col-md-3">
                        <input type="text" value="{{ old('document_number',$user->debts()->first()->document_number) }}"
                            name="document_number" placeholder="Nro. Documento" class="form-control">
                        @if ($errors->has('document_number'))
                        <span style="color:red;">
                            {{ $errors->first('document_number') }}
                        </span>
                        @endif
                    </div>
                    <!-- DEUDA - FECHA EMISION -->
                    <div class="form-group col-md-3">
                        <input type="date" value="{{ old('document_emission',$user->debts()->first()->document_emission) }}"
                            name="document_emission" class="form-control">
                        @if ($errors->has('document_emission'))
                        <span style="color:red;">
                            {{ $errors->first('document_emission') }}
                        </span>
                        @endif
                    </div>
                    <!-- DEUDA - FECHA VENCIMIENTO -->
                    <div class="form-group col-md-2">
                        <input type="date" value="{{ old('document_expiration',$user->debts()->first()->document_expiration) }}"
                            name="document_expiration" class="form-control">

                        @if ($errors->has('document_expiration'))
                        <span style="color:red;">
                            {{ $errors->first('document_expiration') }}
                        </span>
                        @endif
                    </div>
                    <!-- DEUDA - SALDO DEUDA -->
                    <div class="form-group col-md-2">
                        <input type="text" value="{{ old('debt',$user->debts()->first()->debt) }}" name="debt"
                            placeholder="Saldo deuda" class="form-control">
                        @if ($errors->has('debt'))
                        <span style="color:red;">
                            {{ $errors->first('debt') }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="form-group col-md-2">

                    </div>
                </div>
            </div> --}}
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>

            </div>
            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer"></div>
    </div>
    <!-- /.card -->
</div>
</div>


</div>

@endsection

@section('scripts')
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/depending_selectors.js') }}"></script>

<script>
    function preselect_items() {

        //condiciones de pago
        var condition = '<?php echo $user->agreements()->first()->conditions; ?>';
        var select_condition = document.getElementById('conditions');
        select_condition.value = condition;
        //metodo de pago
        var pay_method = '<?php echo $user->agreements()->first()->pay_method; ?>';
        var select_pay_method = document.getElementById('pay_method');
        select_pay_method.value = pay_method;
        //metodo de pago
        var credit_line = '<?php echo $user->agreements()->first()->credit_line; ?>';
        var select_credit_line = document.getElementById('credit_line');
        select_credit_line.value = credit_line;




    }
    window.addEventListener('load', preselect_items);

</script>
@endsection
