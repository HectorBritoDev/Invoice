@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">


                    <h3 class="card-title">{{ $client->client_name }} {{ $client->client_lastname }}</h3>
                    <div class="input-group">

                        <form id="delete-form" action="{{ route('client.destroy',$client->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> Eliminar</button>
                        </form>
                        @if ($client->ruc!=null)
                        <input type="hidden" name="" id="ruc" value="{{ $client->ruc }}">
                        <button class="btn btn-primary ml-3" id="contactsBySunat">Cargar contactos por Sunat</button>
                        @endif
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('client.index') }}">
                            <button class="btn btn-primary">
                                <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="modal-body">
                        <div class="form-group">
                            <h3 class="text-center">
                                <strong>Informacion de la cliente</strong>
                            </h3>
                        </div>
                        <div class="row">
                            @if ($client->ruc != null)


                            <div class="form-group col-md-2">
                                <!-- RUC -->
                                <label for="ruc">RUC</label>
                                <input readonly type="text" name="ruc" placeholder="RUC o DNI" class="form-control-plaintext"
                                    value="{{ old('ruc',$client->ruc) }}">

                            </div>

                            <!-- SITUACION SUNAT -->
                            <div class="form-group col-md-2">
                                <label for="sunat_situation">Situación en sunat</label>
                                <input readonly type="text" name="sunat_situation" placeholder="Situacion con el Sunat"
                                    class="form-control-plaintext" value="{{ old('sunat_situation',$client->sunat_situation) }}">

                            </div>
                            @elseif($client->dni != null)
                            <div class="form-group col-md-2">
                                <!-- RUC -->
                                <label for="dni">DNI</label>
                                <input readonly type="text" name="dni" placeholder="DNI" class="form-control-plaintext"
                                    value="{{ old('dni',$client->dni) }}">

                            </div>
                            @else
                            <div class="form-group col-md-2">
                                <!-- RUC -->
                                <label for="dni">Pasaporte</label>
                                <input readonly type="text" name="dni" placeholder="DNI" class="form-control-plaintext"
                                    value="{{ old('dni',$client->passport) }}">

                            </div>
                            @endif
                        </div>

                        <div class="row">
                            <!-- NOMBRE -->
                            <div class="form-group col-md-8">
                                <label for="name">Cliente</label>
                                <input readonly type="text" value="{{ old('name',$client->client_name) }}" name="name"
                                    placeholder="Nombre" class="form-control-plaintext">

                            </div>

                            <!-- EMAIL -->
                            <div class="form-group col-md-4">
                                <label for="email">E-mail</label>
                                <input readonly type="email" value="{{ old('email',$client->client_email) }}" name="email"
                                    placeholder="Sin correo agregado" class="form-control-plaintext">
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="form-group col-md-8">
                                <label for="email">Domicilio fiscal</label>
                                <input readonly type="text" value="{{ $client->client_main_adress }}"
                        name="client_main_adress"
                        placeholder="Sin direcciones agregas" class="form-control-plaintext">
                    </div>
                </div> --}}

                <div class="form-group">
                    <h3 class="text-center">
                        <strong>Dirección fiscal</strong>
                    </h3>
                </div>
                @if ($client->adresses->count()>0)


                <table class="table table-hover text-center" id="adresses">
                    <thead>
                        <tr>
                            <th>Direcciones</th>

                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client->adresses()->get() as $adress)
                        <tr>
                            <td>{{ $adress->client_adress }}</td>

                            <td>
                                <form action="{{ route('adress.destroy',$adress->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <div class="form-group ">
                    <button data-toggle="modal" data-target="#adressCreateModal" class="btn btn-link">Agregar
                        mas domicilios</button>
                </div>

                <div class="form-group">
                    <h3 class="text-center">
                        <strong>Informacion de contacto</strong>
                    </h3>
                    <table class="table table-hover" id="contacts">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Responsable de</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client->contacts()->get() as $contact)
                            <tr>
                                <td>{{ $contact->client_contact_name }}</td>
                                <td>{{ $contact->client_contact_lastname }}</td>
                                <td>{{ $contact->client_contact_phone }}</td>
                                <td>{{ $contact->client_contact_email }}</td>
                                <td>{{ $contact->client_contact_charge }}</td>
                                <td>{{ $contact->client_contact_responsableFor }}</td>
                                <td>
                                    <div class="input-group">

                                        <button class="btn btn-link">
                                            <i class="fa fa-edit blue" data-toggle="modal" data-target="#contactEditModal{{ $contact->id }}"></i>
                                        </button>/

                                        <form action="{{ route('contact.destroy',$contact->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                        </form>
                                    </div>

                                </td>

                            </tr>
                            <!--UPDATE CONTACT Modal -->
                            <div class="modal fade" id="contactEditModal{{ $contact->id }}" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">{{ $contact->client_contact_name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('contact.update',$contact) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                                <div class="row">
                                                    <!-- CONTACTO - NOMBRE -->
                                                    <div class="form-group col-md-3">
                                                        <label for="">Nombre</label>
                                                        <input type="text" value="{{ old('client_contact_name',$contact->client_contact_name) }}"
                                                            name="client_contact_name" placeholder="Nombre" class="form-control"
                                                            required>
                                                        @if ($errors->has('client_contact_name'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_contact_name') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="">Apellido</label>
                                                        <input type="text" value="{{ old('client_contact_lastname',$contact->client_contact_lastname) }}"
                                                            name="client_contact_lastname" placeholder="Apellido" class="form-control"
                                                            required>
                                                        @if ($errors->has('client_contact_lastname'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_contact_lastname') }}
                                                        </span>
                                                        @endif
                                                    </div>


                                                    <!-- CONTACTO - CELULAR -->
                                                    <div class="form-group col-md-2">
                                                        <label for="">Móvil</label>
                                                        <input required type="text" value="{{ old('client_contact_cellphone',$contact->client_contact_cellphone) }}"
                                                            name="client_contact_cellphone" placeholder="Celular" class="form-control">
                                                        @if ($errors->has('client_contact_cellphone'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_contact_cellphone') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <!-- CONTACTO - TELEFONO -->
                                                    <div class="form-group col-md-2">
                                                        <label for="">Teléfono</label>
                                                        <input required type="text" value="{{ old('client_contact_phone',$contact->client_contact_phone) }}"
                                                            name="client_contact_phone" placeholder="Telefono" class="form-control">
                                                        @if ($errors->has('client_contact_phone'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_contact_phone') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <!-- CONTACTO - ANEXO -->
                                                    <div class="form-group col-md-2">
                                                        <label for="">Anexo</label>
                                                        <input required type="text" value="{{ old('client_contact_anexo',$contact->client_contact_anexo) }}"
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
                                                        <label for="">E-mail</label>
                                                        <input required type="text" value="{{ old('client_contact_email',$contact->client_contact_email) }}"
                                                            name="client_contact_email" placeholder="Correo" class="form-control">
                                                        @if ($errors->has('client_contact_name'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_contact_name') }}
                                                        </span>
                                                        @endif </div>
                                                    <!-- CONTACTO - CARGO -->
                                                    <div class="form-group col-md-3">
                                                        <label for="">Cargo</label>
                                                        <input required type="text" value="{{ old('client_contact_charge',$contact->client_contact_charge) }}"
                                                            name="client_contact_charge" placeholder="Cargo" class="form-control">
                                                        @if ($errors->has('client_contact_charge'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_contact_charge') }}
                                                        </span>
                                                        @endif </div>
                                                    <!-- CONTACTO - CUMPLEAÑOS -->
                                                    <div class="form-group col-md-3">
                                                        {{-- <input required type="date" value="{{ old('client_contact_birthday') }}"
                                                        name="client_contact_birthday"
                                                        placeholder="Cumpleaños" class="form-control "> --}}
                                                        <label for="">Cumpleaños</label>
                                                        <input required name="client_contact_birthday" id="client_contact_birthday"
                                                            placeholder="Cumpleaños" class="form-control" type="text"
                                                            onfocus="(this.type='date')" onblur="(this.type='text')"
                                                            value="{{ old('client_contact_birthday',$contact->client_contact_birthday) }}"
                                                            id="date">

                                                        @if ($errors->has('client_contact_birthday'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_contact_birthday') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <!-- CONTACTO - RESPONSABLE POR -->
                                                    <div class="form-group col-md-3">
                                                        <label for="">Responsable de:</label>
                                                        <input required type="text" value="{{ old('client_contact_responsableFor',$contact->client_contact_responsableFor) }}"
                                                            name="client_contact_responsableFor" placeholder="Responsable de"
                                                            class="form-control">

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
                            @endforeach
                        </tbody>
                    </table>
                    <button data-toggle="modal" data-target="#contactCreateModal" class="btn btn-link">Agregar
                        mas contactos</button>
                </div>


                <div class="form-group">
                    <h3 class="text-center">
                        <strong>Acuerdos</strong>
                    </h3>
                    <table class="table table-hover " id="agreements">
                        <thead>
                            <tr>
                                <th>Codiciones de pago</th>
                                <th>Linea de crédito aprobada</th>
                                <th>Medio de pago</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client->agreements()->get() as $agreement)
                            <tr>
                                <td>

                                    @if (is_numeric($agreement->conditions))

                                    A {{ $agreement->conditions }} días

                                    @else
                                    {{ $agreement->conditions }}
                                    @endif


                                </td>
                                <td>{{ $agreement->credit_line }}</td>
                                <td>{{ $agreement->pay_method }}</td>
                                <td>
                                    <div class="input-group">

                                        <button class="btn btn-link">
                                            <i class="fa fa-edit blue" data-toggle="modal" data-target="#agreementUpdateModal{{ $agreement->id }}"></i>
                                        </button>/

                                        <form action="{{ route('agreement.destroy',$agreement->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            <!--UPDATE AGREEMENT Modal -->
                            <div class="modal fade" id="agreementUpdateModal{{ $agreement->id }}" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Agregar condiciones</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('agreement.update',$agreement) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                                <div class="row">
                                                    <!-- ACUERDOS - CONDICIONES DE PAGO -->
                                                    <div class="form-group col-md-12">
                                                        <label for="">Condiciones de pago</label>
<select name="conditions" id="conditionsUpdate{{ $agreement->id }}" class="form-control select2"
                                                            style="width:100%;">
                                                            @if($condition_options->where('name',$agreement->conditions)->first()==null)
                                                            <option value="{{ $agreement->conditions }}">A {{ $agreement->conditions }}
                                                                Días</option>
                                                            @endif
                                                            @foreach ($condition_options as $option)
                                                            <option value="{{ $option->code }}" @if ($option->name ==
                                                                $agreement->conditions)
                                                                selected
                                                                @endif>{{ $option->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('conditions'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('conditions') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- ACUERDOS - LINEA DE CREDITO -->
                                                    <div class="form-group col-md-12">
                                                        <label for="">Línea de crédito</label>
                                                        <input type="number" name="credit_line" id="credit_line" class="form-control"
                                                            value="{{ old('credit_line',$agreement->credit_line) }}">
                                                        @if ($errors->has('credit_line'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('credit_line') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- ACUERDOS - MEDIO DE PAGO PREFERIDO -->
                                                    <div class="form-group col-md-12">

<select name="pay_method" id="pay_methodUpdate{{ $agreement->id }}" class="form-control select2"
                                                            style="width:100%;">
                                                            @if($pay_options->where('name',$agreement->pay_method)->first()==null)
                                                            <option value="{{ $agreement->pay_method }}">{{ $agreement->pay_method }}</option>
                                                            @endif


                                                            @foreach ($pay_options as $option)
                                                            <option value="{{ $option->code }}" @if ($option->name ==
                                                                $agreement->pay_method)
                                                                selected
                                                                @endif >{{ $option->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('pay_method'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('pay_method') }}
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
                            @endforeach

                        </tbody>
                    </table>
                    <button data-toggle="modal" data-target="#agreementCreateModal" class="btn btn-link">Agregar
                        mas acuerdos</button>


                </div>

                <div class="form-group">
                    <h3 class="text-center">
                        <strong>Deuda</strong>
                    </h3>
                    <table class="table table-hover" id="debts">
                        <thead>
                            <tr>
                                <th>Tipo de documento</th>
                                <th>Numero documento</th>
                                <th>Fecha de Emision</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Deuda</th>
                                <th>Archivo</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($client->debts()->get() as $debt)
                            <tr>
                                <td>{{ $debt->document_type }}</td>
                                <td>{{ $debt->document_number }}</td>
                                <td>{{ $debt->document_emission }}</td>
                                <td>{{ $debt->document_expiration }}</td>
                                <td>{{ $debt->debt }}</td>
                                <td><a href="{{ asset('files/'.$client->id.'/'.$debt->file) }}">{{ $debt->file_title }}</a></td>
                                <td>

                                    <form action="{{ route('debt.destroy',$debt->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                    </form>
                                </td>
                            </tr>

                </div>
                @endforeach
                </tbody>
                </table>
                <button data-toggle="modal" data-target="#debtCreateModal" class="btn btn-link">Agregar
                    mas deudas</button>
            </div>
            @if ($client->files()->count() > 0)

            <div class="form-group">
                <h3 class="text-center">
                    <strong>Archivos</strong>
                </h3>
                <table class="table table-hover" id="debts">
                    <thead>
                        <tr>
                            <td>Nombre</td>

                            <td></td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($client->files()->get() as $file)
                        <tr>
                            <td>

                                <a href="{{ asset('files/'.$file->client->id.'/'.$file->name) }}">
                                    {{ $file->title }}
                                </a>
                            </td>

                            <td>

                                <form action="{{ route('client.file.destroy',[$client,$file]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                </form>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>



                @endif
                <button data-toggle="modal" data-target="#fileCreateModal" class="btn btn-success">Agregar
                    archivo <i class="fas fa-plus"></i></button>
                <button data-toggle="modal" data-target="#noteEditModal" class="btn btn-primary">Notas <i class="fas fa-sticky-note"></i></button>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <a href="{{ route('client.edit',$client->id) }}">
            <button type="submit" class="btn btn-primary">Editar</button>
            </a> --}}
        </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer"></div>
</div>
<!-- /.card -->
</div>
</div>
</div>




<!--CREATE ADRESS Modal -->
<div class="modal fade" id="adressCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Domicilio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('adress.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <input type="hidden" name="client_id" value="{{ $client->id }}" required>
                        <label for="">Dirección</label>
                        <input type="text" name="client_adress" id="client_adress" placeholder="Dirección" class="form-control"
                            required>
                        @if ($errors->has('client_id'))
                        <span style="color:red;">
                            {{ $errors->first('client_id') }}
                        </span>
                        @endif
                    </div>

                    <!-- DOMICIO FISCAL - DEPARTAMENTO -->
                    {{-- <div class="row mt-3">
                        <div class="form-group col-md-4">
                            <select name="client_department_id" class="form-control" id="select-department" required>
                                <option value="">Departamento</option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                    </select>
            </div>
            @if ($errors->has('client_department_id'))
            <span style="color:red;">
                {{ $errors->first('client_department_id') }}
            </span>
            @endif --}}
            <!-- DOMICIO FISCAL - PROVINCIA -->

            {{-- <div class="form-group col-md-4">
                            <select name="client_province_id" class="form-control" id="select-province" required>
                                <option value="">Provincia</option>
                            </select>
                            @if ($errors->has('client_province_id'))
                            <span style="color:red;">
                                {{ $errors->first('client_province_id') }}
            </span>
            @endif
        </div> --}}
        <!-- DOMICIO FISCAL - DISTRITO -->
        {{-- <div class="form-group col-md-4">
                            <select name="client_district_id" id="select-district" class="form-control" required>
                                <option value="">Distrito</option>
                            </select>
                            @if ($errors->has('client_district_id'))
                            <span style="color:red;">
                                {{ $errors->first('client_district_id') }}
        </span>
        @endif
    </div>
</div>--}}

<button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
</form>
</div>

</div>
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
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="row">
                        <!-- CONTACTO - NOMBRE -->
                        <div class="form-group col-md-3">
                            <label for="">Nombre</label>
                            <input type="text" value="{{ old('client_contact_name') }}" name="client_contact_name"
                                placeholder="Nombre" class="form-control" required>
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Apellido</label>
                            <input type="text" value="{{ old('client_contact_lastname') }}" name="client_contact_lastname"
                                placeholder="Apellido" class="form-control" required>
                            @if ($errors->has('client_contact_lastname'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_lastname') }}
                            </span>
                            @endif
                        </div>

                        <!-- CONTACTO - CELULAR -->
                        <div class="form-group col-md-2">
                            <label for="">Móvil</label>
                            <input required type="text" value="{{ old('client_contact_cellphone') }}" name="client_contact_cellphone"
                                placeholder="Celular" class="form-control">
                            @if ($errors->has('client_contact_cellphone'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_cellphone') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - TELEFONO -->
                        <div class="form-group col-md-2">
                            <label for="">Teléfono</label>
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
                            <label for="">Anexo</label>
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
                            <label for="">E-mail</label>
                            <input required type="text" value="{{ old('client_contact_email') }}" name="client_contact_email"
                                placeholder="Correo" class="form-control">
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif </div>
                        <!-- CONTACTO - CARGO -->
                        <div class="form-group col-md-3">
                            <label for="">Cargo</label>
                            <input required type="text" value="{{ old('client_contact_charge') }}" name="client_contact_charge"
                                placeholder="Cargo" class="form-control">
                            @if ($errors->has('client_contact_charge'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_charge') }}
                            </span>
                            @endif </div>
                        <!-- CONTACTO - CUMPLEAÑOS -->
                        <div class="form-group col-md-3">
                            {{-- <input required type="date" value="{{ old('client_contact_birthday') }}"
                            name="client_contact_birthday"
                            placeholder="Cumpleaños" class="form-control "> --}}
                            <label for="">Cumpleaños</label>
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
                            <label for="">Responsable de:</label>
                            <input required type="text" value="{{ old('client_contact_responsableFor') }}" name="client_contact_responsableFor"
                                placeholder="Responsable de" class="form-control">

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



<!--CREATE AGREEMENT Modal -->
<div class="modal fade" id="agreementCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('agreement.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="row">
                        <!-- ACUERDOS - CONDICIONES DE PAGO -->
                        <div class="form-group col-md-12">
                            <label for="">Condiciones de pago</label>
                            <select name="conditions" id="conditions" class="form-control select2" style="width:100%;">
                                <option value>Condiciones de pago</option>
                                @foreach ($condition_options as $option)
                                <option value="{{ $option->code }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('conditions'))
                            <span style="color:red;">
                                {{ $errors->first('conditions') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <!-- ACUERDOS - LINEA DE CREDITO -->
                        <div class="form-group col-md-12">
                            <label for="">Línea de crédito</label>
                            <input type="number" name="credit_line" id="credit_line" class="form-control">
                            @if ($errors->has('credit_line'))
                            <span style="color:red;">
                                {{ $errors->first('credit_line') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <!-- ACUERDOS - MEDIO DE PAGO PREFERIDO -->
                        <div class="form-group col-md-12">
                            <select name="pay_method" id="pay_method" class="form-control select2" style="width:100%;">
                                <option value>Metodo de pago</option>
                                @foreach ($pay_options as $option)
                                <option value="{{ $option->code }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('pay_method'))
                            <span style="color:red;">
                                {{ $errors->first('pay_method') }}
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

<!--CREATE DEBT Modal -->
<div class="modal fade" id="debtCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('debt.store') }}" method='POST' enctype="multipart/form-data">
                    @csrf
                    <input required type="hidden" name='client_id' value='{{ $client->id }}'>
                    <div class="row">
                        <!-- DEUDA - TIPO DE DOCUMENTO -->
                        <div class="form-group col-md-12">
                            <label for="">Tipo de documento</label>
                            <select name="document_type" id="document_type" class="form-control select2" style="width:100%">
                                <option value="">Documento</option>
                                @foreach ($document_options as $option)
                                <option value="{{ $option->code }}">{{ $option->name  }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('document_type'))
                            <span style="color:red;">
                                {{ $errors->first('document_type') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <!-- DEUDA - NUMERO DE DOCUMENTO -->
                        <div class="form-group col-md-6">
                            <label for="">Nro. documento</label>
                            <input required type="text" value="{{ old('document_number') }}" name="document_number"
                                placeholder="Nro. Documento" class="form-control">
                            @if ($errors->has('document_number'))
                            <span style="color:red;">
                                {{ $errors->first('document_number') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class='row'>
                        <!-- DEUDA - FECHA EMISION -->
                        <div class="form-group col-md-4">
                            <label for="">Fecha emisión</label>
                            <input required name="document_emission" id="document_emission" placeholder="Fecha de emision"
                                class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ old('document_emission') }}" id="date">
                            @if ($errors->has('document_emission'))
                            <span style="color:red;">
                                {{ $errors->first('document_emission') }}
                            </span>
                            @endif
                        </div>
                        <!-- DEUDA - FECHA VENCIMIENTO -->
                        <div class="form-group col-md-4">
                            <label for="">Fecha vencimiento</label>
                            <input required name="document_expiration" id="document_expiration" placeholder="Fecha de Expiracion"
                                class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                value="{{ old('document_expiration') }}" id="date">
                            @if ($errors->has('document_expiration'))
                            <span style="color:red;">
                                {{ $errors->first('document_expiration') }}
                            </span>
                            @endif
                        </div>
                        <!-- DEUDA - SALDO DEUDA -->
                        <div class="form-group col-md-4">
                            <label for="">Deuda</label>
                            <input required type="text" value="{{ old('debt') }}" name="debt" placeholder="Saldo deuda"
                                class="form-control">
                            @if ($errors->has('debt'))
                            <span style="color:red;">
                                {{ $errors->first('debt') }}
                            </span>
                            @endif
                        </div>
                        <div class="row ml-3">

                            <label for="">Archivo (PDF)</label>

                            <input type="file" name="file" id="file" required>
                            @if ($errors->has('file'))
                            <span style="color:red;">
                                {{ $errors->first('file') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>


            </div>

            </form>

        </div>

    </div>
</div>


<!--CREATE FILE Modal -->
<div class="modal fade" id="fileCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('client.file.store',$client) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="row">
                        <div class="ml-3">

                            <input type="file" name="file">
                        </div>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!--UPDATE NOTE Modal -->
<div class="modal fade" id="noteEditModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Nota de cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('client.update',$client) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">
                        <label for="" class="ml-3">Nota</label>
                        <textarea name="client_note" class="form-control ml-3 mr-3">{{ $client->client_note }}</textarea>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')



<script>
    $(document).ready(function () {

        $('.select2').select2({
            theme: 'bootstrap4',
            tags: true,
        });
        $('.select2WithTags').select2({
            theme: 'bootstrap4',
            tags: true,
        });

    });

    $(function () {
        $('#contactsBySunat').on('click', function () {
            var ruc = $('#ruc').val();

            // var url = 'api/sunat';

            $.ajax({
                type: 'GET',
                url: '/sunat/contacts',
                data: 'ruc=' + ruc,
                success: function (datos) {
                    location.reload();
                }
            });
            return false;
        });
    });

</script>
@endsection
