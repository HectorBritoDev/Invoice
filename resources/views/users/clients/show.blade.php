@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $client->client_name }}</h3>
                    <form id="delete-form" action="{{ route('client.destroy',$client->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"> Eliminar</button>
                    </form>

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
                            <div class="form-group col-md-6">
                                <!-- RUC -->
                                <input readonly type="text" name="ruc" placeholder="RUC o DNI" class="form-control"
                                    value="{{ old('ruc',$client->ruc) }}">
                                @if ($errors->has('ruc'))
                                <span style="color:red;">
                                    {{ $errors->first('ruc') }}
                                </span>
                                @endif
                            </div>

                            <!-- SITUACION SUNAT -->
                            <div class="form-group col-md-6">
                                <input readonly type="text" name="sunat_situation" placeholder="Situacion con el Sunat"
                                    class="form-control" value="{{ old('sunat_situation',$client->sunat_situation) }}">
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
                                <input readonly type="text" value="{{ old('name',$client->client_name) }}" name="name"
                                    placeholder="Nombre" class="form-control">
                                @if ($errors->has('name'))
                                <span style="color:red;">
                                    {{ $errors->first('name') }}
                                </span>
                                @endif
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group col-md-4">
                                <input readonly type="email" value="{{ old('email',$client->client_email) }}" name="email"
                                    placeholder="Email de registro" class="form-control">
                                @if ($errors->has('email'))
                                <span style="color:red;">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif </div>
                        </div>

                        <div class="form-group">
                            <h3 class="text-center">
                                <strong>Direccion fiscal</strong>
                            </h3>
                        </div>

                        <table class="table table-hover text-center" id="adresses">
                            <thead>
                                <tr>
                                    <td>Direcciones</td>

                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->adresses()->get() as $adress)
                                <tr>
                                    <td>{{ $adress->client_adress }}</td>

                                    <td>

                                        <button class="btn btn-link">

                                            <i class="fa fa-edit blue" data-toggle="modal" data-target="#adressEditModal{{ $adress->id }}"></i>
                                        </button>
                                        /
                                        <form action="{{ route('adress.destroy',$adress->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- EDIT ADRESS Modal -->
                                <div class="modal fade" id="adressEditModal{{ $adress->id }}" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Editar Domicilio</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('adress.update',$adress->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <input type="hidden" name="client_id" value="{{ $client->id }}"
                                                            required>
                                                        <input type="text" name="client_adress" value="{{ $adress->client_adress }}"
                                                            id="client_adress" placeholder="Dirección" class="form-control"
                                                            required>
                                                        @if ($errors->has('client_id'))
                                                        <span style="color:red;">
                                                            {{ $errors->first('client_id') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <button type="submit" class="form-control btn btn-primary mt-2">Modificar</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group ml-4">
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
                                        <td>Nombre</td>
                                        <td>Telefono</td>
                                        <td>Email</td>
                                        <td>Cargo</td>
                                        <td>Responsable por</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->contacts()->get() as $contact)
                                    <tr>
                                        <td>{{ $contact->client_contact_name }}</td>
                                        <td>{{ $contact->client_contact_phone }}</td>
                                        <td>{{ $contact->client_contact_email }}</td>
                                        <td>{{ $contact->client_contact_charge }}</td>
                                        <td>{{ $contact->client_contact_responsableFor }}</td>
                                        <td>

                                            <button class="btn btn-link">
                                                <i class="fa fa-edit blue" data-toggle="modal" data-target="#contactEditModal{{ $contact->id }}"></i>
                                            </button>
                                            /
                                            <form action="{{ route('contact.destroy',$contact->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                            </form>

                                        </td>

                                    </tr>
                                    <!--EDIT CONTACT Modal -->
                                    <div class="modal fade" id="contactEditModal{{ $contact->id }}" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">{{
                                                        $contact->client_contact_name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <form action="{{ route('contact.update',$contact->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                                                        <div class="row">
                                                            <!-- CONTACTO - NOMBRE -->
                                                            <div class="form-group col-md-3">
                                                                <input type="text" value="{{ old('client_contact_name',$contact->client_contact_name) }}"
                                                                    name="client_contact_name" placeholder="Nombre y Apellido"
                                                                    class="form-control" required>
                                                                @if ($errors->has('client_contact_name'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('client_contact_name') }}
                                                                </span>
                                                                @endif
                                                            </div>

                                                            <!-- CONTACTO - CELULAR -->
                                                            <div class="form-group col-md-3">
                                                                <input required type="text" value="{{ old('client_contact_cellphone',$contact->client_contact_cellphone) }}"
                                                                    name="client_contact_cellphone" placeholder="Celular"
                                                                    class="form-control">
                                                                @if ($errors->has('client_contact_cellphone'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('client_contact_cellphone') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                            <!-- CONTACTO - TELEFONO -->
                                                            <div class="form-group col-md-3">
                                                                <input required type="text" value="{{ old('client_contact_phone',$contact->client_contact_phone) }}"
                                                                    name="client_contact_phone" placeholder="Telefono"
                                                                    class="form-control">
                                                                @if ($errors->has('client_contact_phone'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('client_contact_phone') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                            <!-- CONTACTO - ANEXO -->
                                                            <div class="form-group col-md-3">
                                                                <input required type="text" value="{{ old('client_contact_anexo' ,$contact->client_contact_anexo) }}"
                                                                    name="client_contact_anexo" placeholder="Anexo"
                                                                    class="form-control">
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
                                                                <input required type="text" value="{{ old('client_contact_email',$contact->client_contact_email) }}"
                                                                    name="client_contact_email" placeholder="Correo"
                                                                    class="form-control">
                                                                @if ($errors->has('client_contact_name'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('client_contact_name') }}
                                                                </span>
                                                                @endif </div>
                                                            <!-- CONTACTO - CARGO -->
                                                            <div class="form-group col-md-3">
                                                                <input required type="text" value="{{ old('client_contact_charge',$contact->client_contact_charge) }}"
                                                                    name="client_contact_charge" placeholder="Cargo"
                                                                    class="form-control">
                                                                @if ($errors->has('client_contact_charge'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('client_contact_charge') }}
                                                                </span>
                                                                @endif </div>
                                                            <!-- CONTACTO - CUMPLEAÑOS -->
                                                            <div class="form-group col-md-3">

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
                                                                <input required type="text" value="{{ old('client_contact_responsableFor',$contact->client_contact_responsableFor) }}"
                                                                    name="client_contact_responsableFor" placeholder="Responsable Por"
                                                                    class="form-control">

                                                                @if ($errors->has('client_contact_responsableFor'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('client_contact_responsableFor')
                                                                    }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="form-control btn btn-primary mt-2">Modificar</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">


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
                                        <td>Codiciones de pago</td>
                                        <td>Linea de crédito aprobada</td>
                                        <td>Medio de pago</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->agreements()->get() as $agreement)
                                    <tr>
                                        <td>{{ $agreement->conditions }}</td>
                                        <td>{{ $agreement->credit_line }}</td>
                                        <td>{{ $agreement->pay_method }}</td>
                                        <td>

                                            <button class="btn btn-link">
                                                <i class="fa fa-edit blue" data-toggle="modal" data-target="#agreementEditModal{{ $agreement->id }}"></i>
                                            </button>
                                            /
                                            <form action="{{ route('agreement.destroy',$agreement->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                            </form>

                                        </td>

                                    </tr>

                                    <!-- EDIT AGREEMENT Modal -->
                                    <div class="modal fade" id="agreementEditModal{{ $agreement->id }}" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar acuerdo
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('agreement.update',$agreement->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <input type="hidden" name="client_id" value="{{ $client->id }}"
                                                                required>

                                                        </div>
                                                        <div class="row">
                                                            <!-- ACUERDOS - CONDICIONES DE PAGO -->
                                                            <div class="form-group col-md-12">
                                                                <select name="conditions" id="conditions_edit" class="form-control select2"
                                                                    style="width:100%;">
                                                                    <option value>Condiciones de pago</option>
                                                                    <option value="1" @if ($agreement->conditions == 1)
                                                                        selected
                                                                        @endif>[1] Factura</option>
                                                                    <option value="2" @if ($agreement->conditions == 2)
                                                                        selected
                                                                        @endif>[2] Recibo por Honorarios</option>
                                                                    <option value="3" @if ($agreement->conditions == 3)
                                                                        selected
                                                                        @endif>[3] Boleta de Venta</option>
                                                                    <option value="4" @if ($agreement->conditions == 4)
                                                                        selected
                                                                        @endif>[4] Liquidación de compra</option>
                                                                    <option value="5" @if ($agreement->conditions == 5)
                                                                        selected
                                                                        @endif>[5] Boleto de compañía de
                                                                        aviación comercial por el servicio de
                                                                        transporte aéreo de pasajeros</option>
                                                                    <option value="6" @if ($agreement->conditions == 6)
                                                                        selected
                                                                        @endif>[6] Carta de porte aéreo por el
                                                                        servicio de transporte de carga aérea</option>
                                                                    <option value="7" @if ($agreement->conditions == 7)
                                                                        selected
                                                                        @endif>[7] Nota de crédito</option>
                                                                    <option value="8" @if ($agreement->conditions == 8)
                                                                        selected
                                                                        @endif>[8] Nota de débito</option>
                                                                    <option value="9" @if ($agreement->conditions == 9)
                                                                        selected
                                                                        @endif>[9] Guía de remisión - remisión</option>
                                                                    <option value="10" @if ($agreement->conditions ==
                                                                        10)
                                                                        selected
                                                                        @endif>[10] Recibo por Arrendamiento</option>
                                                                    <option value="11" @if ($agreement->conditions ==
                                                                        11)
                                                                        selected
                                                                        @endif>[11] Póliza emitida por las
                                                                        Bolsas de Valores, Bolsas de Productos o
                                                                        Agentes de Intermediación por operaciones
                                                                        realizadas en las Bolsas de Valores o Productos
                                                                        o fuera de las mismas, autorizadas por CONASEV</option>
                                                                    <option value="12" @if ($agreement->conditions ==
                                                                        12)
                                                                        selected
                                                                        @endif>[12] Ticket o cinta emitido por
                                                                        máquina registradora</option>
                                                                    <option value="13" @if ($agreement->conditions ==
                                                                        13)
                                                                        selected
                                                                        @endif>[13] Documento emitido por
                                                                        bancos, instituciones financieras, crediticias
                                                                        y de seguros que se encuentren bajo el control
                                                                        de la Superintendencia de Banca y Seguros</option>
                                                                    <option value="14" @if ($agreement->conditions ==
                                                                        14)
                                                                        selected
                                                                        @endif>[14] Recibo por servicios
                                                                        públicos de suministro de energía eléctrica,
                                                                        agua, teléfono, telex y telegráficos y otros
                                                                        servicios complementarios que se incluyan en el
                                                                        recibo de servicio público</option>
                                                                    <option value="15" @if ($agreement->conditions ==
                                                                        15)
                                                                        selected
                                                                        @endif>[15] Boleto emitido por las
                                                                        empresas de transporte público urbano de
                                                                        pasajeros</option>
                                                                    <option value="16" @if ($agreement->conditions ==
                                                                        16)
                                                                        selected
                                                                        @endif>[16] Boleto de viaje emitido por
                                                                        las empresas de transporte público
                                                                        interprovincial de pasajeros dentro del país</option>
                                                                    <option value="17" @if ($agreement->conditions ==
                                                                        17)
                                                                        selected
                                                                        @endif>[17] Documento emitido por la
                                                                        Iglesia Católica por el arrendamiento de bienes
                                                                        inmuebles</option>
                                                                    <option value="18" @if ($agreement->conditions ==
                                                                        18)
                                                                        selected
                                                                        @endif>[18] Documento emitido por las
                                                                        Administradoras Privadas de Fondo de Pensiones
                                                                        que se encuentran bajo la supervisión de la
                                                                        Superintendencia de Administradoras Privadas de
                                                                        Fondos de Pensiones</option>
                                                                    <option value="19" @if ($agreement->conditions ==
                                                                        19)
                                                                        selected
                                                                        @endif>[19] Boleto o entrada por
                                                                        atracciones y espectáculos públicos</option>
                                                                    <option value="20" @if ($agreement->conditions ==
                                                                        20)
                                                                        selected
                                                                        @endif>[20] Comprobante de Retención</option>
                                                                    <option value="21" @if ($agreement->conditions ==
                                                                        21)
                                                                        selected
                                                                        @endif>[21] Conocimiento de embarque
                                                                        por el servicio de transporte de carga marítima</option>
                                                                    <option value="22" @if ($agreement->conditions ==
                                                                        22)
                                                                        selected
                                                                        @endif>[22] Comprobante por Operaciones
                                                                        No Habituales</option>
                                                                    <option value="23" @if ($agreement->conditions ==
                                                                        23)
                                                                        selected
                                                                        @endif>[23] Pólizas de Adjudicación
                                                                        emitidas con ocasión del remate o adjudicación
                                                                        de bienes por venta forzada, por los
                                                                        martilleros o las entidades que rematen o
                                                                        subasten bienes por cuenta de terceros</option>
                                                                    <option value="24" @if ($agreement->conditions ==
                                                                        24)
                                                                        selected
                                                                        @endif>[24] Certificado de pago de
                                                                        regalías emitidas por PERUPETRO S.A</option>
                                                                    <option value="25" @if ($agreement->conditions ==
                                                                        25)
                                                                        selected
                                                                        @endif>[25] Documento de Atribución
                                                                        (Ley del Impuesto General a las Ventas e
                                                                        Impuesto Selectivo al Consumo, Art. 19º, último
                                                                        párrafo, R.S. N° 022-98-SUNAT).</option>
                                                                    <option value="26" @if ($agreement->conditions ==
                                                                        26)
                                                                        selected
                                                                        @endif>[26] Recibo por el Pago de la
                                                                        Tarifa por Uso de Agua Superficial con fines
                                                                        agrarios y por el pago de la Cuota para la
                                                                        ejecución de una determinada obra o actividad
                                                                        acordada por la Asamblea General de la Comisión
                                                                        de Regantes o Resolución expedida por el Jefe
                                                                        de la Unidad de Aguas y de Riego (Decreto
                                                                        Supremo N° 003-90-AG, Arts. 28 y 48)</option>
                                                                    <option value="27" @if ($agreement->conditions ==
                                                                        28)
                                                                        selected
                                                                        @endif>[27] Seguro Complementario de
                                                                        Trabajo de Riesgo</option>
                                                                    <option value="28" @if ($agreement->conditions ==
                                                                        29)
                                                                        selected
                                                                        @endif>[28] Tarifa Unificada de Uso de
                                                                        Aeropuerto</option>
                                                                    <option value="29" @if ($agreement->conditions ==
                                                                        29)
                                                                        selected
                                                                        @endif>[29] Documentos emitidos por la
                                                                        COFOPRI en calidad de oferta de venta de
                                                                        terrenos, los correspondientes a las subastas
                                                                        públicas y a la retribución de los servicios
                                                                        que presta</option>
                                                                    <option value="30" @if ($agreement->conditions ==
                                                                        30)
                                                                        selected
                                                                        @endif>[30] Documentos emitidos por las
                                                                        empresas que desempeñan el rol adquirente en
                                                                        los sistemas de pago mediante tarjetas de
                                                                        crédito y débito</option>
                                                                    <option value="31" @if ($agreement->conditions ==
                                                                        31)
                                                                        selected
                                                                        @endif>[31] Guía de Remisión -
                                                                        Transportista</option>
                                                                    <option value="32" @if ($agreement->conditions ==
                                                                        32)
                                                                        selected
                                                                        @endif>[32] Documentos emitidos por las
                                                                        empresas recaudadoras de la denominada Garantía
                                                                        de Red Principal a la que hace referencia el
                                                                        numeral 7.6 del artículo 7° de la Ley N° 27133
                                                                        – Ley de Promoción del Desarrollo de la
                                                                        Industria del Gas Natural</option>
                                                                    <option value="34" @if ($agreement->conditions ==
                                                                        34)
                                                                        selected
                                                                        @endif>[34] Documento del Operador</option>
                                                                    <option value="35" @if ($agreement->conditions ==
                                                                        35)
                                                                        selected
                                                                        @endif>[35] Documento del Partíciper</option>
                                                                    <option value="36" @if ($agreement->conditions ==
                                                                        36)
                                                                        selected
                                                                        @endif>[36] Recibo de Distribución de
                                                                        Gas Natural</option>
                                                                    <option value="37" @if ($agreement->conditions ==
                                                                        37)
                                                                        selected
                                                                        @endif>[37] Documentos que emitan los
                                                                        concesionarios del servicio de revisiones
                                                                        técnicas vehiculares, por la prestación de
                                                                        dicho servicio</option>
                                                                    <option value="50" @if ($agreement->conditions ==
                                                                        50)
                                                                        selected
                                                                        @endif>[50] Declaración Única de
                                                                        Aduanas - Importación definitiva</option>
                                                                    <option value="52" @if ($agreement->conditions ==
                                                                        52)
                                                                        selected
                                                                        @endif>[52] Despacho Simplificado -
                                                                        Importación Simplificada</option>
                                                                    <option value="53" @if ($agreement->conditions ==
                                                                        53)
                                                                        selected
                                                                        @endif>[53] Declaración de Mensajería o
                                                                        Courier</option>
                                                                    <option value="54" @if ($agreement->conditions ==
                                                                        54)
                                                                        selected
                                                                        @endif>[54] Liquidación de Cobranza</option>
                                                                    <option value="87" @if ($agreement->conditions ==
                                                                        87)
                                                                        selected
                                                                        @endif>[87] Nota de Crédito Especial</option>
                                                                    <option value="88" @if ($agreement->conditions ==
                                                                        88)
                                                                        selected
                                                                        @endif>[87] Nota de Débito Especial</option>
                                                                    <option value="91" @if ($agreement->conditions ==
                                                                        91)
                                                                        selected
                                                                        @endif>[91] Comprobante de No
                                                                        Domiciliado</option>
                                                                    <option value="96" @if ($agreement->conditions ==
                                                                        96)
                                                                        selected
                                                                        @endif>[96] Exceso de crédito fiscal
                                                                        por retiro de bienes</option>
                                                                    <option value="97" @if ($agreement->conditions ==
                                                                        97)
                                                                        selected
                                                                        @endif>[97] Nota de Crédito - No
                                                                        Domiciliado</option>
                                                                    <option value="98" @if ($agreement->conditions ==
                                                                        98)
                                                                        selected
                                                                        @endif>[98] Nota de Débito - No
                                                                        Domiciliado</option>
                                                                    <option value="99" @if ($agreement->conditions ==
                                                                        99)
                                                                        selected
                                                                        @endif>[99] Otros -Consolidado de
                                                                        Boletas de Venta</option>
                                                                    <option value="00" @if ($agreement->conditions ==
                                                                        00)
                                                                        selected
                                                                        @endif>[00] Otros (especificar)</option>
                                                                </select>
                                                                @if ($errors->has('conditions'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('conditions') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- ACUERDOS - LINEA DE CREDITO -->
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <select name="credit_line" id="credit_line_edit" class="form-control">
                                                                    <option value>Linea de credito</option>
                                                                    <option value="1" @if($agreement->credit_line==
                                                                        '10') selected @endif>10 días</option>
                                                                    <option value="2" @if($agreement->credit_line==
                                                                        '15') selected @endif>15 días</option>
                                                                    <option value="30" @if($agreement->credit_line==
                                                                        '30') selected @endif>30 días</option>
                                                                    <option value="60" @if($agreement->credit_line==
                                                                        '60') selected @endif>60 días</option>
                                                                    <option value="90" @if($agreement->credit_line==
                                                                        '90') selected @endif>90 días</option>
                                                                </select>
                                                                @if ($errors->has('credit_line'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('credit_line') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- ACUERDOS - MEDIO DE PAGO PREFERIDO -->
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <select name="pay_method" id="pay_method_edit" class="form-control select2"
                                                                    style="width:100%">
                                                                    <option value>Metodo de pago</option>
                                                                    <option value="1" @if ($agreement->pay_method == 1)
                                                                        selected
                                                                        @endif>[1] DEPÓSITO EN CUENTA</option>
                                                                    <option value="2" @if ($agreement->pay_method == 2)
                                                                        selected
                                                                        @endif>[2] GIRO</option>
                                                                    <option value="3" @if ($agreement->pay_method == 3)
                                                                        selected
                                                                        @endif>[3] TRANSFERENCIA DE FONDOS</option>
                                                                    <option value="4" @if ($agreement->pay_method == 4)
                                                                        selected
                                                                        @endif>[4] ORDEN DE PAGO</option>
                                                                    <option value="5" @if ($agreement->pay_method == 5)
                                                                        selected
                                                                        @endif>[5] TARJETA DE DÉBITO</option>
                                                                    <option value="6" @if ($agreement->pay_method == 6)
                                                                        selected
                                                                        @endif>[6] TARJETA DE CRÉDITO</option>
                                                                    <option value="7" @if ($agreement->pay_method == 7)
                                                                        selected
                                                                        @endif>[7] CHEQUES CON LA CLÁUSULA DE "NO
                                                                        NEGOCIABLE", "INTRANSFERIBLES", "NO A LA ORDEN"
                                                                        U OTRA EQUIVALENTE, A
                                                                        QUE SE REFIERE EL INCISO F) DEL ARTICULO 5° DEL
                                                                        DECRETO LEGISLATIVO.</option>
                                                                    <option value="8" @if ($agreement->pay_method == 8)
                                                                        selected
                                                                        @endif>[8]EFECTIVO, POR OPERACIONES EN LAS
                                                                        QUE NO EXISTE OBLIGACIÓN DE UTILIZAR MEDIOS DE
                                                                        PAGO</option>
                                                                    <option value="9" @if ($agreement->pay_method == 9)
                                                                        selected
                                                                        @endif>[9]EFECTIVO, EN LOS DEMÁS CASOS</option>
                                                                    <option value="10" @if ($agreement->pay_method ==
                                                                        10)
                                                                        selected
                                                                        @endif>[10]MEDIOS DE PAGO DE COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="11" @if ($agreement->pay_method ==
                                                                        11)
                                                                        selected
                                                                        @endif>[11]LETRAS DE CAMBIO</option>
                                                                    <option value="101" @if ($agreement->pay_method ==
                                                                        101)
                                                                        selected
                                                                        @endif>[101]TRANSFERENCIAS - COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="102" @if ($agreement->pay_method ==
                                                                        102)
                                                                        selected
                                                                        @endif>[102] CHEQUES BANCARIOS - COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="103" @if ($agreement->pay_method ==
                                                                        103)
                                                                        selected
                                                                        @endif>[103] ORDEN DE PAGO SIMPLE - COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="104" @if ($agreement->pay_method ==
                                                                        104)
                                                                        selected
                                                                        @endif>[104] ORDEN DE PAGO DOCUMENTARIO -
                                                                        COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="105" @if ($agreement->pay_method ==
                                                                        105)
                                                                        selected
                                                                        @endif>[105] REMESA SIMPLE - COMERCIO EXTERIOR</option>
                                                                    <option value="106" @if ($agreement->pay_method ==
                                                                        106)
                                                                        selected
                                                                        @endif>[106] REMESA DOCUMENTARIA - COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="107" @if ($agreement->pay_method ==
                                                                        107)
                                                                        selected
                                                                        @endif>[107] REMESA DOCUMENTARIA - COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="108" @if ($agreement->pay_method ==
                                                                        108)
                                                                        selected
                                                                        @endif>[108]CARTA DE CRÉDITO DOCUMENTARIO -
                                                                        COMERCIO
                                                                        EXTERIOR</option>
                                                                    <option value="999">[999] OTROS MEDIOS DE PAGO
                                                                        (ESPECIFICAR)</option>
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
                                        <td>Tipo de documento</td>
                                        <td>Numero documento</td>
                                        <td>Fecha de Emision</td>
                                        <td>Fecha de Vencimiento</td>
                                        <td>Deuda</td>
                                        <td></td>
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
                                        <td>
                                            <button class="btn btn-link">
                                                <i class="fa fa-edit blue" data-toggle="modal" data-target="#debtEditModal{{ $debt->id }}"></i>
                                            </button>
                                            /
                                            <form action="{{ route('debt.destroy',$debt->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- EDIT DEBT Modal -->
                                    <div class="modal fade" id="debtEditModal{{ $debt->id }}" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar deuda
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('debt.update',$debt->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <input type="hidden" name="client_id" value="{{ $client->id }}"
                                                                required>

                                                        </div>
                                                        <div class="row">
                                                            <!-- DEUDA - TIPO DE DOCUMENTO -->
                                                            <div class="form-group col-md-12">
                                                                <select class="form-control select2" name="document_type"
                                                                    id="document_type" style="width: 100%">
                                                                    <option value="">Tipo de documento</option>
                                                                    <option value="1" @if ($debt->document_type == 1)
                                                                        selected
                                                                        @endif>[1] Factura</option>
                                                                    <option value="2" @if ($debt->document_type == 2)
                                                                        selected
                                                                        @endif>[2] Recibo por Honorarios</option>
                                                                    <option value="3" @if ($debt->document_type == 3)
                                                                        selected
                                                                        @endif>[3] Boleta de Venta</option>
                                                                    <option value="4" @if ($debt->document_type == 4)
                                                                        selected
                                                                        @endif>[4] Liquidación de compra</option>
                                                                    <option value="5" @if ($debt->document_type == 5)
                                                                        selected
                                                                        @endif>[5] Boleto de compañía de aviación
                                                                        comercial por el servicio de transporte aéreo
                                                                        de pasajeros</option>
                                                                    <option value="6" @if ($debt->document_type == 6)
                                                                        selected
                                                                        @endif>[6] Carta de porte aéreo por el servicio
                                                                        de transporte de carga aérea</option>
                                                                    <option value="7" @if ($debt->document_type == 7)
                                                                        selected
                                                                        @endif>[7] Nota de crédito</option>
                                                                    <option value="8" @if ($debt->document_type == 8)
                                                                        selected
                                                                        @endif>[8] Nota de débito</option>
                                                                    <option value="9" @if ($debt->document_type == 9)
                                                                        selected
                                                                        @endif>[9] Guía de remisión - remisión</option>
                                                                    <option value="10" @if ($debt->document_type == 10)
                                                                        selected
                                                                        @endif>[10] Recibo por Arrendamiento</option>
                                                                    <option value="11" @if ($debt->document_type == 11)
                                                                        selected
                                                                        @endif>[11] Póliza emitida por las Bolsas de
                                                                        Valores, Bolsas de Productos o Agentes de
                                                                        Intermediación por operaciones
                                                                        realizadas en las Bolsas de Valores o Productos
                                                                        o fuera de las mismas, autorizadas por CONASEV
                                                                    </option>
                                                                    <option value="12" @if ($debt->document_type == 12)
                                                                        selected
                                                                        @endif>[12] Ticket o cinta emitido por máquina
                                                                        registradora</option>
                                                                    <option value="13" @if ($debt->document_type == 13)
                                                                        selected
                                                                        @endif>[13] Documento emitido por bancos,
                                                                        instituciones financieras, crediticias y de
                                                                        seguros que se encuentren bajo el
                                                                        control de la Superintendencia de Banca y
                                                                        Seguros</option>
                                                                    <option value="14" @if ($debt->document_type == 14)
                                                                        selected
                                                                        @endif>[14] Recibo por servicios públicos de
                                                                        suministro de energía eléctrica, agua,
                                                                        teléfono, telex y telegráficos y
                                                                        otros servicios complementarios que se incluyan
                                                                        en el recibo de servicio público</option>
                                                                    <option value="15" @if ($debt->document_type == 15)
                                                                        selected
                                                                        @endif>[15] Boleto emitido por las empresas de
                                                                        transporte público urbano de pasajeros</option>
                                                                    <option value="16" @if ($debt->document_type == 16)
                                                                        selected
                                                                        @endif>[16] Boleto de viaje emitido por las
                                                                        empresas de transporte público interprovincial
                                                                        de pasajeros dentro del país</option>
                                                                    <option value="17" @if ($debt->document_type == 17)
                                                                        selected
                                                                        @endif>[17] Documento emitido por la Iglesia
                                                                        Católica por el arrendamiento de bienes
                                                                        inmuebles</option>
                                                                    <option value="18" @if ($debt->document_type == 18)
                                                                        selected
                                                                        @endif>[18] Documento emitido por las
                                                                        Administradoras Privadas de Fondo de Pensiones
                                                                        que se encuentran bajo la
                                                                        supervisión de la Superintendencia de
                                                                        Administradoras Privadas de Fondos de Pensiones</option>
                                                                    <option value="19" @if ($debt->document_type == 19)
                                                                        selected
                                                                        @endif>[19] Boleto o entrada por atracciones y
                                                                        espectáculos públicos</option>
                                                                    <option value="20" @if ($debt->document_type == 20)
                                                                        selected
                                                                        @endif>[20] Comprobante de Retención</option>
                                                                    <option value="21" @if ($debt->document_type == 21)
                                                                        selected
                                                                        @endif>[21] Conocimiento de embarque por el
                                                                        servicio de transporte de carga marítima</option>
                                                                    <option value="22" @if ($debt->document_type == 22)
                                                                        selected
                                                                        @endif>[22] Comprobante por Operaciones No
                                                                        Habituales</option>
                                                                    <option value="23" @if ($debt->document_type == 23)
                                                                        selected
                                                                        @endif>[23] Pólizas de Adjudicación emitidas
                                                                        con ocasión del remate o adjudicación de bienes
                                                                        por venta forzada, por los
                                                                        martilleros o las entidades que rematen o
                                                                        subasten bienes por cuenta de terceros</option>
                                                                    <option value="24" @if ($debt->document_type == 24)
                                                                        selected
                                                                        @endif>[24] Certificado de pago de regalías
                                                                        emitidas por PERUPETRO S.A</option>
                                                                    <option value="25" @if ($debt->document_type == 25)
                                                                        selected
                                                                        @endif>[25] Documento de Atribución (Ley del
                                                                        Impuesto General a las Ventas e Impuesto
                                                                        Selectivo al Consumo, Art.
                                                                        19º,último párrafo, R.S. N° 022-98-SUNAT).</option>
                                                                    <option value="26" @if ($debt->document_type == 26)
                                                                        selected
                                                                        @endif>[26] Recibo por el Pago de la Tarifa por
                                                                        Uso de Agua Superficial con fines agrarios y
                                                                        por el pago de la Cuota
                                                                        para la ejecución de una determinada obra o
                                                                        actividad acordada por la Asamblea General de
                                                                        la Comisión de Regantes o
                                                                        Resolución expedida por el Jefe de la Unidad de
                                                                        Aguas y de Riego (Decreto Supremo N° 003-90-AG,
                                                                        Arts. 28 y 48).</option>
                                                                    <option value="27" @if ($debt->document_type == 27)
                                                                        selected
                                                                        @endif>[27] Seguro Complementario de Trabajo de
                                                                        Riesgo</option>
                                                                    <option value="28" @if ($debt->document_type == 28)
                                                                        selected
                                                                        @endif>[28] Tarifa Unificada de Uso de
                                                                        Aeropuerto</option>
                                                                    <option value="29" @if ($debt->document_type == 29)
                                                                        selected
                                                                        @endif>[29] Documentos emitidos por la COFOPRI
                                                                        en calidad de oferta de venta de terrenos, los
                                                                        correspondientes a las subastas públicas y a la
                                                                        retribución de los servicios que presta</option>
                                                                    <option value="30" @if ($debt->document_type == 30)
                                                                        selected
                                                                        @endif>[30] Documentos emitidos por las
                                                                        empresas que desempeñan el rol adquirente en
                                                                        los sistemas de pago mediante tarjetas de
                                                                        crédito y débito</option>
                                                                    <option value="31" @if ($debt->document_type == 31)
                                                                        selected
                                                                        @endif>[31] Guía de Remisión - Transportista</option>
                                                                    <option value="32" @if ($debt->document_type == 32)
                                                                        selected
                                                                        @endif>[32] Documentos emitidos por las
                                                                        empresas recaudadoras de la denominada Garantía
                                                                        de Red Principal a la que hace
                                                                        referencia el numeral 7.6 del artículo 7° de la
                                                                        Ley N° 27133 – Ley de Promoción del Desarrollo
                                                                        de la Industria del Gas
                                                                        Natural</option>
                                                                    <option value="34" @if ($debt->document_type == 34)
                                                                        selected
                                                                        @endif>[34] Documento del Operador</option>
                                                                    <option value="35" @if ($debt->document_type == 35)
                                                                        selected
                                                                        @endif>[35] Documento del Partícipe</option>
                                                                    <option value="36" @if ($debt->document_type == 36)
                                                                        selected
                                                                        @endif>[36] Recibo de Distribución de Gas
                                                                        Natural</option>
                                                                    <option value="37" @if ($debt->document_type == 37)
                                                                        selected
                                                                        @endif>[37] Documentos que emitan los
                                                                        concesionarios del servicio de revisiones
                                                                        técnicas vehiculares, por la prestación de
                                                                        dicho servicio</option>
                                                                    <option value="50" @if ($debt->document_type == 50)
                                                                        selected
                                                                        @endif>[50] Declaración Única de Aduanas -
                                                                        Importación definitiva </option>
                                                                    <option value="52" @if ($debt->document_type == 52)
                                                                        selected
                                                                        @endif>[52] Despacho Simplificado - Importación
                                                                        Simplificada </option>
                                                                    <option value="53" @if ($debt->document_type == 53)
                                                                        selected
                                                                        @endif>[53] Declaración de Mensajería o Courier
                                                                    </option>
                                                                    <option value="54" @if ($debt->document_type == 54)
                                                                        selected
                                                                        @endif>[54] Liquidación de Cobranza</option>
                                                                    <option value="87" @if ($debt->document_type == 87)
                                                                        selected
                                                                        @endif>[87] Nota de Crédito Especial</option>
                                                                    <option value="88" @if ($debt->document_type == 88)
                                                                        selected
                                                                        @endif>[88] Nota de Débito Especial</option>
                                                                    <option value="91" @if ($debt->document_type == 91)
                                                                        selected
                                                                        @endif>[91] Comprobante de No Domiciliado</option>
                                                                    <option value="96" @if ($debt->document_type == 96)
                                                                        selected
                                                                        @endif>[96] Exceso de crédito fiscal por retiro
                                                                        de bienes </option>
                                                                    <option value="97" @if ($debt->document_type == 97)
                                                                        selected
                                                                        @endif>[97] Nota de Crédito - No Domiciliado</option>
                                                                    <option value="98" @if ($debt->document_type == 98)
                                                                        selected
                                                                        @endif>[98] Nota de Débito - No Domiciliado</option>
                                                                    <option value="99" @if ($debt->document_type == 99)
                                                                        selected
                                                                        @endif>[99] Otros -Consolidado de Boletas de
                                                                        Venta</option>
                                                                    <option value="00" @if ($debt->document_type == 00)
                                                                        selected
                                                                        @endif>[00] Otros (especificar)</option>



                                                                </select>
                                                                @if ($errors->has('document_type'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('document_type') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- DEUDA - TIPO DE DOCUMENTO -->
                                                        <div class="row">

                                                            <div class="form-group col-md-6">
                                                                <input required type="text" value="{{ old('document_number',$debt->document_number) }}"
                                                                    name="document_number" placeholder="Nro. Documento"
                                                                    class="form-control">
                                                                @if ($errors->has('document_number'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('document_number') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                            <!-- DEUDA - FECHA EMISION -->
                                                            <div class="form-group col-md-4">
                                                                <input required type="date" value="{{ old('document_emission',$debt->document_emission) }}"
                                                                    name="document_emission" class="form-control">
                                                                @if ($errors->has('document_emission'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('document_emission') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class='row'>
                                                            <!-- DEUDA - FECHA VENCIMIENTO -->
                                                            <div class="form-group col-md-4">
                                                                <input required type="date" value="{{ old('document_expiration',$debt->document_expiration) }}"
                                                                    name="document_expiration" class="form-control">

                                                                @if ($errors->has('document_expiration'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('document_expiration') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                            <!-- DEUDA - SALDO DEUDA -->
                                                            <div class="form-group col-md-4">
                                                                <input required type="text" value="{{ old('debt',$debt->debt) }}"
                                                                    name="debt" placeholder="Saldo deuda" class="form-control">
                                                                @if ($errors->has('debt'))
                                                                <span style="color:red;">
                                                                    {{ $errors->first('debt') }}
                                                                </span>
                                                                @endif
                                                            </div>
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
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

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
                            <input type="text" value="{{ old('client_contact_name') }}" name="client_contact_name"
                                placeholder="Nombre y Apellido" class="form-control" required>
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif
                        </div>

                        <!-- CONTACTO - CELULAR -->
                        <div class="form-group col-md-3">
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
                            <input required type="text" value="{{ old('client_contact_phone') }}" name="client_contact_phone"
                                placeholder="Telefono" class="form-control">
                            @if ($errors->has('client_contact_phone'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_phone') }}
                            </span>
                            @endif
                        </div>
                        <!-- CONTACTO - ANEXO -->
                        <div class="form-group col-md-3">
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
                            <input required type="text" value="{{ old('client_contact_email') }}" name="client_contact_email"
                                placeholder="Correo" class="form-control">
                            @if ($errors->has('client_contact_name'))
                            <span style="color:red;">
                                {{ $errors->first('client_contact_name') }}
                            </span>
                            @endif </div>
                        <!-- CONTACTO - CARGO -->
                        <div class="form-group col-md-3">
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

                <form action="{{ route('debt.store') }}" method='POST'>
                    @csrf
                    <input required type="hidden" name='client_id' value='{{ $client->id }}'>
                    <div class="row">
                        <!-- DEUDA - TIPO DE DOCUMENTO -->
                        <div class="form-group col-md-6">
                            <input required type="text" value="{{ old('document_type') }}" name="document_type"
                                placeholder="Tipo de documento" class="form-control">

                            @if ($errors->has('document_type'))
                            <span style="color:red;">
                                {{ $errors->first('document_type') }}
                            </span>
                            @endif
                        </div>
                        <!-- DEUDA - NUMERO DE DOCUMENTO -->
                        <div class="form-group col-md-6">
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
                            <input required type="text" value="{{ old('debt') }}" name="debt" placeholder="Saldo deuda"
                                class="form-control">
                            @if ($errors->has('debt'))
                            <span style="color:red;">
                                {{ $errors->first('debt') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>


            </div>

            </form>

        </div>
        <div class="modal-footer">


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
                        <input type="file" name="file">
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
                </form>
            </div>
            <div class="modal-footer">


            </div>
        </div>
    </div>
</div>

<!--UPDATE NOTE Modal -->
<div class="modal fade" id="noteEditModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('client.update',$client) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">
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
        $('#adresses').DataTable();
        $('#contacts').DataTable();
        $('#agreements').DataTable();
        $('#debts').DataTable();
        $('.select2').select2({
            tags: true,
        });

    });

</script>
@endsection
