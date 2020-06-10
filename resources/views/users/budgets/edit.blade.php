@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">


                        <div class="input-group col-md-3">
                            <button class="btn btn-link" id="searchBudgetIcon" data-target="#searchBudgetModal"
                                data-toggle="modal"><i class="fas fa-search"></i></button>
                            <h3><strong>Cotización {{ $budget->serie }} - {{ $budget->code }}</strong></h3>
                        </div>
                        <div class="col-md-7"></div>
                        <div class="d-flex col-md-1">
                            <div class="dropdown">
                                <button type="button" class="btn btn-link dropdown-toggle" id="dropdownMenuConfiguration"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-NewOperation="10,20">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuConfiguration">

                                    <form action="{{ route('budget.update',$budget) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="form-group">
                                                <label for="" class="ml-4">Serie</label>
                                                <input type="text" name="serie" class="form-control ml-4" value="{{ $budget->serie }}"
                                                    style="width:70%;" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="" class="ml-4">Empieza en</label>
                                                <input type="text" name="code" class="form-control ml-4" value="{{ $budgets->where('serie',$budget->serie)->min('code')}}"
                                                    style="width:70%;" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <button class="btn btn-primary ml-4">Aceptar</button>
                                        </div>
                                    </form>
                                    <br>

                                    <form action="{{ route('budget.config',$configuration) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="budget_id" id="" value="{{ $budget->id }}">

                                        <input type="checkbox" name="phone" id="" class="" @if ($configuration->phone
                                        == true) checked @endif>
                                        <label for="emission_date">Teléfono</label>
                                        <br>




                                        <input type="checkbox" name="email" id="" class="" @if ($configuration->email
                                        == true) checked @endif>
                                        <label for="email">Correo</label>
                                        <br>




                                        <input type="checkbox" name="web" id="" class="" @if ($configuration->web ==
                                        true) checked @endif>
                                        <label for="web">Web</label>
                                        <br>




                                        <input type="checkbox" name="user_description" id="" class=""
                                            @if($configuration->user_description == true)checked
                                        @endif>
                                        <label for="user_description">Descripción negocio</label>
                                        <br>



                                        <input type="checkbox" name="seller" id="" class="" @if ($configuration->seller
                                        == true)
                                        checked @endif>
                                        <label for="seller">Vendedor</label>
                                        <br>




                                        <input type="checkbox" name="price" id="" class="" @if ($configuration->price==
                                        true) checked @endif>
                                        <label for="price">Facturado</label>
                                        <br>




                                        <input type="checkbox" name="reference" id="" class="" @if ($configuration->reference==true)
                                        checked @endif>
                                        <label for="reference">Referencia</label>
                                        <br>




                                        <input type="checkbox" name="client_message" id="" class="" @if($configuration->client_message==true)
                                        checked
                                        @endif>
                                        <label for="client_message">Mensaje Cliente</label>
                                        <br>



                                        <input type="checkbox" name="internal_message" id="" class=""
                                            @if($configuration->internal_message==true)
                                        checked @endif>
                                        <label for="internal_message">Mensaje interno</label>
                                        <br>




                                        <input type="checkbox" name="detraction_account" id="" class=""
                                            @if($configuration->detraction_account==true) checked
                                        @endif>
                                        <label for="detraction_account">Cuenta detracciones</label>
                                        <br>

                                        <input type="checkbox" name="bank_account" id="" class="" @if($configuration->bank_account==true)
                                        checked
                                        @endif>
                                        <label for="bank_account">Cuenta bancaria</label>
                                        <br>


                                        <button type="submit" class="btn btn-seconday ml-2">Configurar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">

                            <a href="{{ route('sale.index') }}">
                                <button class="btn btn-primary">
                                    <i class="fas fa-times"></i>
                                </button>
                            </a>

                        </div>
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

                </div>
                <!-- /.card-header -->



                <div class="card-body">


                    <div class="row mt-4">
                        <div class="form-group  col-md-6 ">
                            <label for="client_name">Cliente</label>
                            <input type="text" name="client_name" id="ruc" class="form-control-plaintext" placeholder="RUC"
                                value="{{ $budget->client_name }}" readonly>

                        </div>
                        <div class="form-group col-md-3 form-inline">
                            @if ($budget->ruc != null)

                            <label for="ruc">Ruc</label>
                            <input type="text" name="ruc" id="ruc" class="form-control-plaintext" placeholder="RUC"
                                value="{{ $budget->ruc }}" readonly>
                            @else
                            <label for="ruc">DNI</label>
                            <input type="text" name="dni" id="dni" class="form-control-plaintext" placeholder="dni"
                                value="{{ $budget->dni }}" readonly>
                            @endif

                        </div>
                        <div class="form-group col-md-3">
                            <label for="client_email">Correo</label>
                            <input type="text" name="client_email" id="client_email" class="form-control-plaintext"
                                placeholder="Email" value="{{ $budget->client_email }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="client_main_adress">Direccion</label>
                            <input type="text" name="client_main_adress" id="client_adress" class="form-control-plaintext"
                                placeholder="Direccion" value="{{ $budget->client_main_adress }}" readonly>

                        </div>
                    </div>



                    <div class="row mt-3">
                        {{-- FECHA DE EMISION --}}
                        <div class="form-group col-md-3">
                            <label for="emission_date">Fecha de emisión</label>
                            <input type="text" name="emission_date" id="emission_date" class="form-control-plaintext"
                                placeholder="Fecha de emision" value="{{ $budget->formatted_emission_date }}" readonly>

                        </div>

                        {{-- CONDICION --}}
                        <div class=" form-group col-md-3">
                            <label for="condition">Condición</label>
                            <input type="text" name="condition" id="condition" class="form-control-plaintext"
                                placeholder="Fecha de emision" value="{{ $budget->condition }} días" readonly>

                        </div>

                        {{-- FECHA DE VENCIMIENTO --}}
                        <div class="form-group col-md-3">
                            <label for="expiration_date">Fecha de expiración</label>
                            <input type="text" name="expiration_date" id="expiration_date" class="form-control-plaintext"
                                placeholder="Fecha de emision" value="{{ $budget->formatted_expiration_date }}"
                                readonly>

                        </div>
                        <div class="form-group col-md-3">
                            <label for="coin">Moneda</label>
                            <input type="text" name="coin" id="coin" class="form-control-plaintext" placeholder="Fecha de emision"
                                value="{{ $budget->coin }}" readonly>
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
                                <td>
                                    <a href="" data-toggle="modal" data-target="#itemUpdateModal{{ $item->id }}">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>
                                    <p class="text-uppercase">{{ $item->measure }}</p>
                                </td>
                                <td>{{ $item->reference }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->discount }}</td>
                                <td>{{ $item->total }}</td>
                                <td>
                                    <form id="itemForm{{ $item->id }}" action="{{ route('budgetItem.destroy',$item) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <i class="fa fa-trash red" onclick="document.getElementById('itemForm{{ $item->id }}').submit();">
                                    </form>
                                </td>
                            </tr>
                            <!--ITEM Update Modal -->
                            <div class="modal fade" id="itemUpdateModal{{ $item->id }}" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Variantes</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('budgetItem.update',$item) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="row form-group">
                                                    <div class="col-md-5">
                                                        <select name="detail" id="detail{{ $item->id }}" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            @foreach (
                                                            App\GoodDetail::where('good_id',$item->good_id)->get()
                                                            as $detail)
                                                            <option value="{{ $detail->id }}">{{ $detail->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <select name="option" id="option{{ $item->id }}" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <button type="submit" class="form-control btn btn-primary mt-2">Aceptar</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
                            <script>
                                $('#detail{{ $item->id }}').on('change', function () {
        var id = $(this).val();
        var option_html;
        $.ajax({
            type: 'GET',
            url: '/gooodDetail/options',
            data: 'id=' + id,
            success: function (response) {
                //var data = JSON.parse(response);

                for (var i = 0; i < response.length; ++i) {
                    //MEASURE
                    option_html += '<option value="' + response[i].name +
                        '">' +
                        response[i].name + '</option>';

                    $('#option{{ $item->id }}').html(option_html);
                }


            }
        });

    });
</script>

                            @endforeach
                        </tbody>
                    </table>


                    <div class="row">
                        <div class="col-md-2">
                            <a href="" data-toggle="modal" data-target="#itemCreateModal">Agregar fila</a>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('budget.destroy.items',$budget) }}" method="POST" id="destroyAllItemsForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link">Borrar todas las filas </button>
                            </form>
                            {{-- <a href="" onclick="destroyAllItems()"></a> --}}
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
                            @if($configuration->client_message==true)
                            <a href="" data-toggle="modal" data-target="#noteModal">Agregar mensaje para cliente</a>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if($configuration->detraction_account==true)
                            <a href="" data-toggle="modal" data-target="#detractionAccountModal">Agregar cuentas de
                                detracciones</a>
                            @endif
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
                            @if($configuration->internal_message==true)
                            <a href="" data-toggle="modal" data-target="#internalMessageModal">Agregar mensaje interno</a>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if($configuration->bank_account==true)
                            <a href="" data-toggle="modal" data-target="#bankAccountModal">Agregar cuenta bancaria</a>
                            @endif
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

                            @if ($budget->file)

                            <a href="{{ asset('files/'.auth()->user()->id.'/budgets/'. $budget->file) }}">
                                Ver Archivo
                            </a>

                            - <a href="" data-toggle="modal" data-target="#fileCreateModal">Cambiar archivo</a>

                            @else

                            <a href="" data-toggle="modal" data-target="#fileCreateModal">Archivo adjunto</a>

                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-5">
                        @if ($budget->status == null && $budget->items()->count()>0 )

                        <form action="{{ route('budget.update',$budget) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="save">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </form>
                        @elseif ($budget->status == "guardada")
                        <button class="btn btn-primary" data-toggle="modal" data-target="#mailModal">
                            Enviar por correo
                        </button>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if (($budget->status == null || $budget->status == 'guardada' || $budget->status ==
                        'aprobada')
                        &&
                        $budget->items()->count() > 0)

                        @if ($budget->bank_account!=null)

                        <button type="submit" class="btn" data-target="#beforeInvoiceModal" data-toggle="modal">Facturar
                            <i class="fas fa-receipt"></i></button>

                        @else
                        <form action="{{ route('invoice.fromBudget') }}" method="POST">
                            @csrf
                            <input type="hidden" name="budget_id" id="budget_id" value="{{ $budget->id }}">
                            <button type="submit" class="btn">Facturar <i class="fas fa-receipt"></i></button>

                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>


<div class="modal fade" id="itemCreateModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar bien/servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (request()->has('beforeInvoice'))
                <form action="{{ route('budgetItem.store','beforeInvoice') }}" method="POST">
                    @else
                    <form action="{{ route('budgetItem.store') }}" method="POST">
                        @endif
                        @csrf
                        <input type="hidden" name="budget_id" id="budget_id" value="{{ $budget->id }}">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Producto</label>
                                <select name="good_id" id="name" class="form-control select2" style="width: 100%">
                                    <option value="">Bienes/Servicios</option>
                                    @foreach ($goods as $good)
                                    <option value="{{ $good->id }}">{{ $good->name }} [{{ $good->reference }}]</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        {{-- <div class="row">
                            <div class="form-group col-md-2">
                                <select name="measure" id="measure" class="form-control select2" style="width: 100%;">

                                    <option value="">Medida</option>
                                </select>

                            </div>
                            <div class="form-group col-md-4">
                                <select name="brand" id="brand" class="form-control select2">

                                    <option value="">Marca</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select name="model" id="model" class="form-control select2">

                                    <option value="">Modelo</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select name="serie" id="serie" class="form-control select2">

                                    <option value="">Serie</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select name="badge" id="badge" class="form-control select2">

                                    <option value="">Placa</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select name="color" id="color" class="form-control select2">

                                    <option value="">Color</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select name="size" id="size" class="form-control select2">

                                    <option value="">Talla</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="">Cantidad</label>
                                <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Cantidad">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Precio</label>
                                <select name="price" id="price" class="form-control   select2-tag" style="width:100%;">
                                    <option value="">Precio</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Descuento %</label>
                                <input type="text" name="discount" id="discount" class="form-control" placeholder="Descuento %">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Tipo de impuesto</label>
                                <select name="igv_type" id="igv_type" class="form-control" required>
                                    <option value="1">18%</option>
                                    <option value="2">Excento</option>
                                    <option value="3">Infecto</option>
                                </select>
                                @if ($errors->has('igv_type'))
                                <span style="color:red;">
                                    {{ $errors->first('igv_type') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Sub total</label>
                                <input type="number" name="sub_total" id="sub_total" class="form-control-plaintext"
                                    placeholder="Sub Total" required min="1" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="">IGV</label>
                                <input type="number" name="tax" id="tax" class="form-control-plaintext" placeholder="Impuesto"
                                    min="1" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Total</label>
                                <input type="number" name="total" id="total" class="form-control-plaintext" placeholder="Total"
                                    min="1" required readonly>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>



<!--UPDATE NOTE Modal -->
<div class="modal fade" id="noteModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Mensaje para cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('budget.update',$budget) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">
                        <textarea name="note" class="form-control ml-3 mr-3">{{ $budget->note }}</textarea>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Aceptar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!--UPDATE DETRACTION Modal -->
<div class="modal fade" id="detractionAccountModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Cuenta de detracciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('budget.update',$budget) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">
                        <input name="detraction_account" class="form-control ml-3 mr-3" value="{{ $budget->detraction_account }}">
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Aceptar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!--UPDATE INTERNAL MESSAGE Modal -->
<div class="modal fade" id="internalMessageModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Mensaje interno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('budget.update',$budget) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">

                        <textarea name="internal_message" class="form-control ml-3 mr-3">{{ $budget->internal_message }}</textarea>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Aceptar</button>
                </form>
            </div>

        </div>
    </div>
</div>




<!--UPDATE BANK ACCOUNT Modal -->
<div class="modal fade" id="bankAccountModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Cuenta bancaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('budget.update',$budget) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">
                        {{-- <textarea name="internal_message" class="form-control ml-3 mr-3">{{ $budget->internal_message }}</textarea>
                        --}}
                        <div class="form-group col-md-12">

                            <select name="bank_account" id="bank_accout" class="form-control">
                                <option value="{{ $budget->bank_account }}">{{ $budget->bank_account }}</option>
                                <option value="01020509350100025322">01020509350100025322</option>
                                <option value="5899415542476265">5899415542476265</option>
                                <option value="5401423721885299">5401423721885299</option>

                            </select>
                        </div>
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Aceptar</button>
                </form>
            </div>

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

                <form action="{{ route('budget.update',$budget) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <input type="file" name="file">
                    </div>
                    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!--COPY BUDGET Modal -->
<div class="modal fade" id="searchBudgetModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Copiar cotización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">

                        <form action="{{ route('budget.copy',$budget) }}" method="POST" id="searchOldBudgetForm">
                            @csrf
                            @method('PUT')
                            <select name="oldBudget" id="oldBudget" class="form-control select2">
                                <option value="">Cotizaciones anteriores</option>
                                @foreach ($budgets as $oldBudget)
                                @if ($oldBudget->id != $budget->id)

                                <option value="{{ $oldBudget->id }}">{{ $oldBudget->serie }}-{{ $oldBudget->code }} ,
                                    {{ $oldBudget->client_name }},
                                    {{ $oldBudget->formatted_emission_date }}</option>
                                @endif
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="copiBudget()">Copiar</button>
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

                        <a href="{{ url('mail/budget/'.$budget->id.'?withBankAccount') }}">
                            <button class="btn btn-primary">Con cuentas bancarias</button>
                        </a>

                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('budget.mail',$budget) }}">
                            <button class="
                                btn btn-secondary">Sin cuentas bancarias</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--INVOICE WITH BANK Modal -->
<div class="modal fade" id="beforeInvoiceModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">

                        <form action="{{ route('invoice.fromBudget','withBankAccounts') }}" method="POST">
                            @csrf
                            <input type="hidden" name="budget_id" id="budget_id" value="{{ $budget->id }}">
                            <button type="submit" class="btn btn-primary">Con cuentas bancarias</button>
                        </form>

                    </div>
                    <div class="col-md-5">
                        <form action="{{ route('invoice.fromBudget') }}" method="POST">
                            @csrf
                            <input type="hidden" name="budget_id" id="budget_id" value="{{ $budget->id }}">
                            <button type="submit" class="btn btn-secondary">Sin cuentas bancarias</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection




@section('scripts')

<script>
    $(function () {
        $('#name').on('change', function () {
            var id = $('#name').val();
            var measure_options;
            var brand_options;
            var model_options;
            var serie_options;
            var badge_options;
            var color_options;
            var size_options;
            var price_options = '<option value=""></option>';

            // var url = 'api/sunat';

            $.ajax({
                type: 'POST',
                url: '/api/good',
                data: 'id=' + id,
                success: function (response) {
                    var data = JSON.parse(response);

                    var nada = 'nada';
                    if (data[0] == nada) {
                        alert('no válido o no registrado');
                    } else {
                        // for (var i = 0; i < data.details.length; ++i) {

                        //     //MEASURE
                        //     measure_options += '<option value="' + data.details[i].measure +
                        //         '">' +
                        //         data.details[i].measure + '</option>';

                        //     $('#measure').html(measure_options);

                        //     if (data.details[i].brand != null) {

                        //         //BRAND
                        //         brand_options += '<option value="' + data.details[i].brand +
                        //             '">' +
                        //             data.details[i].brand + '</option>';

                        //         $('#brand').html(brand_options);
                        //     }

                        //     if (data.details[i].model != null) {
                        //         //MODEL
                        //         model_options += '<option value="' + data.details[i].model +
                        //             '">' +
                        //             data.details[i].model + '</option>';

                        //         $('#model').html(model_options);

                        //     }


                        //     if (data.details[i].serie != null) {

                        //         //SERIE
                        //         serie_options += '<option value="' + data.details[i].serie +
                        //             '">' +
                        //             data.details[i].serie + '</option>';

                        //         $('#serie').html(serie_options);
                        //     }

                        //     if (data.details[i].badge != null) {

                        //         //BADGE
                        //         badge_options += '<option value="' + data.details[i].badge +
                        //             '">' +
                        //             data.details[i].badge + '</option>';

                        //         $('#badge').html(badge_options);
                        //     }
                        //     if (data.details[i].color != null) {

                        //         //COLOR
                        //         color_options += '<option value="' + data.details[i].color +
                        //             '">' +
                        //             data.details[i].color + '</option>';

                        //         $('#color').html(color_options);
                        //     }

                        //     if (data.details[i].size != null) {

                        //         //SIZE
                        //         size_options += '<option value="' + data.details[i].size +
                        //             '">' +
                        //             data.details[i].size + '</option>';

                        //         $('#size').html(size_options);
                        //     }

                        // }

                        for (var i = 0; i < data.prices.length; ++i) {

                            price_options += '<option value="' + data.prices[i].wholesale_price +
                                '">' +
                                data.prices[i].wholesale_price + '[Por mayor]' +
                                '</option>' +
                                '<option value="' + data.prices[i].unit_price +
                                '">' +
                                data.prices[i].unit_price + '[Por menor]' +
                                '</option>';

                            $('#price').html(price_options);

                        }

                        $('#quantity').on('keyup', function () {
                            // var discount = $('#discount').val() / 100;
                            var type = $('#igv_type').val();
                            var sub_total = (parseInt($(this).val()) * parseInt($(
                                '#price').val()));

                            if (parseInt($('#discount').val()) > 0) {
                                var discount = (sub_total *
                                    parseInt(
                                        $('#discount').val())) / 100;
                                sub_total = sub_total - discount;
                            }

                            if (type == '1') {
                                var tax = sub_total * 0.18;
                            } else if (type == '2' || type == '3') {
                                var tax = 0;
                            }
                            var total = sub_total + tax;
                            //var total = (total - tax);

                            $('#tax').val(tax);
                            $('#sub_total').val(sub_total);
                            $('#total').val(total);


                        });
                        $('#discount').on('keyup', function () {
                            // var discount = $('#discount').val() / 100;
                            var type = $('#igv_type').val();
                            var sub_total = (parseInt($('#quantity').val()) *
                                parseFloat($('#price').val()));

                            var discount = sub_total * parseInt($(this).val()) /
                                100;

                            sub_total = sub_total - discount;


                            if (type == '1') {
                                var tax = sub_total * 0.18;
                            } else if (type == '2' || type == '3') {
                                var tax = 0;
                            }
                            var total = sub_total + tax;


                            $('#tax').val(tax.toFixed(2));
                            $('#sub_total').val(sub_total.toFixed(2));
                            $('#total').val(total.toFixed(2));


                        });
                        $('#price').on('change', function () {
                            var type = $('#igv_type').val();
                            discount = $('#discount').val() / 100;
                            var sub_total = (parseFloat($(this).val()) * parseInt(
                                $('#quantity').val()));

                            if (parseInt($('#discount').val()) > 0) {
                                var discount = (sub_total *
                                    parseInt($('#discount').val())) / 100;
                                sub_total = sub_total - discount;
                            }

                            if (type == '1') {
                                var tax = sub_total * 0.18;
                            } else if (type == '2' || type == '3') {
                                var tax = 0;
                            }
                            var total = sub_total + tax;

                            $('#tax').val(tax.toFixed(2));
                            $('#total').val(total.toFixed(2));
                            $('#sub_total').val(sub_total.toFixed(2));

                        });

                        $('#igv_type').on('change', function () {

                            var type = $(this).val();

                            discount = $('#discount').val() / 100;
                            var sub_total = (parseFloat($('#price').val()) *
                                parseInt(
                                    $('#quantity').val()));

                            if (parseInt($('#discount').val()) > 0) {
                                var discount = (sub_total *
                                    parseInt($('#discount').val())) / 100;
                                sub_total = sub_total - discount;
                            }
                            if (type == '1') {
                                var tax = sub_total * 0.18;
                            } else if (type == '2' || type == '3') {
                                var tax = 0;
                            }
                            var total = sub_total + tax;
                            $('#tax').val(tax.toFixed(2));
                            $('#total').val(total.toFixed(2));
                            $('#sub_total').val(sub_total.toFixed(2));

                        });

                    }
                    //$('#brand').val(data[0].brand);
                    // $('#size').val(data[0].size);
                    // $('#model').val(data[0].model);
                    // $('#color').val(data[0].color);
                    // $('#measure').val(data[0].measure);

                }

            });
            return false;
        });
    });



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

    // $('#coin').select2({
    //     theme: 'bootstrap4',

    // });
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',

    });

    $('.select2-tag').select2({
        theme: 'bootstrap4',
        tags: true,
        width: '100%',

    });

    function deleteItem() {
        document.getElementById("itemForm").submit();
    }

    function saveBudget() {
        document.getElementById("budgetForm").submit();
    }

    function destroyAllItems() {
        document.getElementById("destroyAllItemsForm").submit();
    }

    function copiBudget() {
        document.getElementById("searchOldBudgetForm").submit();
    }

</script>



@endsection
