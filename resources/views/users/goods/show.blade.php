@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3><strong>{{ $good->name }}</strong></h3>
                    <h5>{{ $good->category->name }}</h5>
                    <form action="{{ route('good.destroy',$good) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Eliminar</button>
                    </form>
                    <div class="card-tools">
                        <a href="{{ route('good.index') }}">
                            <button class="btn btn-primary">
                                <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">

                    <div class="form-group">
                        <h3 class="text-center">
                            <strong>Nombres y Codigos adicionales</strong>
                        </h3>


                    </div>
                    @if ($good->names()->count()>0)

                    <table class="table table-hover" id="names">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Codigo</th>
                                <th>Referencia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($good->names()->get() as $name)
                            <tr>
                                <td>{{ $name->other_name }}</td>
                                <td>{{ $name->other_code }}</td>
                                <td>{{ $name->other_reference }}</td>
                                <td>
                                    <div class="row">
                                        <div class="form-inline">


                                            <form action="{{ route('goodName.destroy',$name->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!--EDIT Detail Modal -->
                            {{-- <div class="modal fade" id="nameEditModal{{ $name->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Nombre</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('goodName.update',$name) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="good_id" value="{{ $good->id }}">
                                            <div class="row">
                                                <div class="form-group col-md-12">

                                                    <input type="text" class="form-control" name="other_name" id="other_name"
                                                        placeholder="Nombre" value="{{ $name->other_name }}" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <input type="text" class="form-control" name="other_code" id="other_code"
                                                        placeholder="Código" value="{{ $name->other_code }}" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <input type="text" class="form-control" name="other_reference" id="other_reference"
                                                        placeholder="Referencia" value="{{ $name->other_reference }}"
                                                        required>

                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="submit" class="form-control btn btn-primary mt-2">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                </div> --}}
                @endforeach
                </tbody>
                </table>
                @endif
                <button class="btn btn-link" data-toggle="modal" data-target="#nameCreateModal">
                    Agregar mas nombres
                </button>
                <div class="form-group">
                    <h3 class="text-center">
                        <strong>Detalles</strong>
                    </h3>



                </div>
                @if ($good->details()->count()>0)

                <table class="table table-hover" id="details">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($good->details()->get() as $detail)
                        <tr>
                            <td>
                                <a href="" data-target="#detailEditModal{{ $detail->id }}" data-toggle="modal"> {{ $detail->name }}
                                </a>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="form-inline">


                                        <form action="{{ route('goodDetail.destroy',$detail->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            @foreach ($detail->options as $option)
                        <tr>

                            <td>*{{ $option->name }}</td>
                            <td>
                                <i class="fa fa-trash red" onclick="document.getElementById('deleteOptionForm{{ $option->id }}').submit()"></i>

                            </td>
                            <form action="{{ route('goodDetailOption.destroy',$option) }}" method="POST" id="deleteOptionForm{{ $option->id }}">
                                @csrf
                                @method('DELETE')

                            </form>
                        </tr>
                        @endforeach
                        </tr>
                        <!--EDIT Details Modal -->
                        <div class="modal fade" id="detailEditModal{{ $detail->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">{{ $detail->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <form action="{{ route('goodDetailOption.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="good_detail_id" value="{{ $detail->id }}">
                                            <div class="row">
                                                <div class=" form-group col-md-12">
                                                    <label for="name">Opciones (Puedes agregar mas de uno separando con
                                                        comas)</label>
                                                    <input type="text" class="form-control" name="name" id="detail_option_name">
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
                @endif
                <button class="btn btn-link" data-toggle="modal" data-target="#detailCreateModal">
                    Agregar mas detalles
                </button>

                <div class="form-group">
                    <h3 class="text-center">
                        <strong>Precios</strong>
                    </h3>



                </div>
                @if ($good->prices()->count()>0)

                <table class="table table-hover" id="prices">
                    <thead>
                        <tr>
                            <th>Precio al mayor</th>
                            <th>Precio por menor</th>
                            <th>Impuesto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($good->prices()->get() as $price)
                        <tr>
                            <td>{{ $price->wholesale_price }}</td>
                            <td>{{ $price->unit_price }}</td>
                            <td>
                                @if ($price->tax == 1)
                                18%
                                @elseif($price->tax==2)
                                Excento
                                @else
                                Infecto
                                @endif

                            </td>
                            <td>
                                <div class="row">
                                    <div class="form-inline">


                                        <form action="{{ route('goodPrice.destroy',$price->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!--EDIT Detail Modal -->
                        {{-- <div class="modal fade" id="priceEditModal{{ $price->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Precio</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <form action="{{ route('goodPrice.update',$price) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="good_id" value="{{ $good->id }}">
                                        <div class="row">
                                            <div class="form-group col-md-4">

                                                <input type="text" class="form-control" name="wholesale_price" id="wholesale_price"
                                                    placeholder="Al mayor" value="{{ $price->wholesale_price }}"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control" name="unit_price" id="unit_price"
                                                    placeholder="Por menor" value="{{ $price->unit_price }}" required>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control" name="tax" id="tax" placeholder="Impuesto"
                                                    value="{{ $price->tax }}" required>

                                            </div>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="submit" class="form-control btn btn-primary mt-2">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
            </div> --}}
            @endforeach
            </tbody>
            </table>
            @endif
            <button class="btn btn-link" data-toggle="modal" data-target="#priceCreateModal">
                Agregar mas precios
            </button>
            <div class="form-group">
                <h3 class="text-center">
                    <strong>Almacenes</strong>
                </h3>


            </div>
            @if ($good->warehouses()->count()>0)

            <table class="table table-hover" id="warehouses">
                <thead>
                    <tr>
                        <th>Almacen</th>
                        <th>Direccion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($good->warehouses()->get() as $warehouse)
                    <tr>
                        <td>{{ $warehouse->name }}</td>
                        <td>{{ $warehouse->adress }}</td>
                        <td>
                            <div class="row">
                                <div class="form-inline">


                                    <form action="{{ route('goodWarehouse.destroy',$warehouse->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-link"> <i class="fa fa-trash red"></i></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!--EDIT Warehouse Modal -->
                    {{-- <div class="modal fade" id="warehouseEditModal{{ $warehouse->id }}" tabindex="-1"
                    role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Precio</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <form action="{{ route('goodWarehouse.update',$warehouse) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="good_id" value="{{ $good->id }}">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Nombre"
                                                value="{{ $warehouse->name }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" name="adress" id="adress"
                                                placeholder="Direccion" value="{{ $warehouse->adress }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                        <button type="submit" class="form-control btn btn-primary mt-2">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        </div> --}}
        @endforeach
        </tbody>
        </table>
        @endif
        <button class="btn btn-link" data-toggle="modal" data-target="#warehouseCreateModal">
            Agregar mas almaneces
        </button>
    </div>
    <!-- /.card-body -->
</div>

<!-- /.card -->
</div>

</div>
</div>

<!--CREATE Names Modal -->
<div class="modal fade" id="nameCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Nombre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('goodName.store') }}" method="POST" class="form">
                    @csrf
                    <input type="hidden" name="good_id" value="{{ $good->id }}">
                    <div class="row">
                        <div class="form-group col-md-12">

                            <input type="text" class="form-control" name="other_name" id="other_name" placeholder="Nombre"
                                required>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" name="other_code" id="other_code" placeholder="Código"
                                required>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" name="other_reference" id="other_reference"
                                placeholder="Referencia" required>

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--CREATE Detail Modal -->
<div class="modal fade" id="detailCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('goodDetail.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="good_id" value="{{ $good->id }}">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="detail_name" placeholder="Nombre"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!--CREATE Price Modal -->
<div class="modal fade" id="priceCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Precio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('goodPrice.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="good_id" value="{{ $good->id }}">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Precio al mayor</label>

                            <input type="text" class="form-control" name="wholesale_price" id="wholesale_price"
                                placeholder="Al mayor" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Precio al por menor</label>
                            <input type="text" class="form-control" name="unit_price" id="unit_price" placeholder="Por menor"
                                required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">IGV</label>
                            <select name="tax" id="tax" class="form-control">
                                <option value="1">18%</option>
                                <option value="2">Excento</option>
                                <option value="3">Infecto</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--CREATE Warehouse Modal -->
<div class="modal fade" id="warehouseCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Almacenes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('goodWarehouse.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="good_id" value="{{ $good->id }}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nombre" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" name="adress" id="adress" placeholder="Direccion"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="form-control btn btn-primary mt-2">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    $(document).ready(function () {

    });

</script>
@endsection
