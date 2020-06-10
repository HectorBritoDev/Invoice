@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if ($good==true)
                    <h3><strong>Agregar Bienes</strong></h3>
                    @else
                    <h3><strong>Agregar Servicios</strong></h3>

                    @endif

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
                    @if (request()->has('good'))

                    <form action="{{ route('good.store','good') }}" method="POST">
                        @else
                        <form action="{{ route('good.store') }}" method="POST">
                            @endif
                            @csrf
                            {{-- Main Info --}}
                            <div class="form-group">
                                <h5>
                                    <strong>Informacion principal</strong>
                                </h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre"
                                        value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                    <span style="color:red;">
                                        {{ $errors->first('name') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="code" id="code" placeholder="Codigo"
                                        value="{{ old('code') }}" required>
                                    @if ($errors->has('code'))
                                    <span style="color:red;">
                                        {{ $errors->first('code') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="reference" id="reference" placeholder="Referencia"
                                        value="{{ old('reference') }}" required>
                                    @if ($errors->has('reference'))
                                    <span style="color:red;">
                                        {{ $errors->first('reference') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Unidad</label>
                                    <select class="form-control select2" name="measure" required>
                                        <option value="">Seleccione uno</option>
                                        @foreach ($measure_options as $option)
                                        <option value="{{ $option->code }}">{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('measure'))
                                    <span style="color:red;">
                                        {{ $errors->first('measure') }}
                                    </span>
                                    @endif
                                </div>

                            </div>
                            {{-- Details --}}
                            {{-- <div class="form-group">
                            <h5>
                                <strong>Detalles</strong>
                            </h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">

                                <select class="form-control select2" name="measure" required>
                                    <option value="">Unidad</option>
                                    <option value="1">KILOGRAMOS</option>
                                    <option value="2">LIBRAS</option>
                                    <option value="3">TONELADAS LARGAS</option>
                                    <option value="4">TONELADAS MÉTRICAS</option>
                                    <option value="5">TONELADAS CORTAS</option>
                                    <option value="6">GRAMOS</option>
                                    <option value="7">UNIDADES</option>
                                    <option value="8">LITROS</option>
                                    <option value="9">GALONES</option>
                                    <option value="10">BARRILES</option>
                                    <option value="11">LATAS</option>
                                    <option value="12">CAJAS</option>
                                    <option value="13">MILLARES</option>
                                    <option value="14">METROS CÚBICOS</option>
                                    <option value="15">METROS</option>
                                </select>
                                @if ($errors->has('measure'))
                                <span style="color:red;">
                                    {{ $errors->first('measure') }}
                            </span>
                            @endif
                </div>
                <div class="form-group col-md-3">

                    <input type="text" class="form-control" name="brand" id="brand" placeholder="Marca" value="{{ old('brand') }}">
                    @if ($errors->has('brand'))
                    <span style="color:red;">
                        {{ $errors->first('brand') }}
                    </span>
                    @endif
                </div>

                @if($good==true)
                <div class="form-group col-md-3">

                    <input type="text" class="form-control" name="model" id="model" placeholder="Modelo" value="{{ old('model') }}">
                    @if ($errors->has('model'))
                    <span style="color:red;">
                        {{ $errors->first('model') }}
                    </span>
                    @endif
                </div>
                <div class="form-group col-md-4">

                    <input type="text" class="form-control" name="serie" id="serie" placeholder="Serie" value="{{ old('serie') }}">
                    @if ($errors->has('serie'))
                    <span style="color:red;">
                        {{ $errors->first('serie') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="badge" id="badge" placeholder="Placa" value="{{ old('badge') }}">
                    @if ($errors->has('badge'))
                    <span style="color:red;">
                        {{ $errors->first('badge') }}
                    </span>
                    @endif
                </div>
                <div class="form-group col-md-4">

                    <input type="text" class="form-control" name="color" id="color" placeholder="Color" value="{{ old('color') }}">
                    @if ($errors->has('color'))
                    <span style="color:red;">
                        {{ $errors->first('color') }}
                    </span>
                    @endif
                </div>

                <div class="form-group col-md-4">

                    <input type="text" class="form-control" name="size" id="size" placeholder="Tamaño" value="{{ old('size') }}">
                    @if ($errors->has('size'))
                    <span style="color:red;">
                        {{ $errors->first('size') }}
                    </span>
                    @endif
                </div>
                @endif
            </div> --}}


            {{-- Price --}}
            <div class="form-group">
                <h5>
                    <strong>Precio</strong>
                </h5>
            </div>
            <div class="row">
                <div class="form-group col-md-4">

                    <input type="text" class="form-control" name="wholesale_price" id="wholesale_price" value="{{ old('wholesale_price') }}"
                        placeholder="Al mayor" required>
                    @if ($errors->has('wholesale_price'))
                    <span style="color:red;">
                        {{ $errors->first('wholesale_price') }}
                    </span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="unit_price" id="unit_price" placeholder="Por menor"
                        value="{{ old('unit_price') }}" required>
                    @if ($errors->has('unit_price'))
                    <span style="color:red;">
                        {{ $errors->first('unit_price') }}
                    </span>
                    @endif
                </div>

            </div>

            @if ($good==true)


            {{-- Warehouse --}}
            <div class="form-group">
                <h5>
                    <strong>Almacen</strong>
                </h5>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="warehouse_name" id="warehouse_name" value="{{ old('warehouse_name') }}"
                        placeholder="Nombre" required>
                    @if ($errors->has('warehouse_name'))
                    <span style="color:red;">
                        {{ $errors->first('warehouse_name') }}
                    </span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="warehouse_adress" id="warehouse_adress" value="{{ old('warehouse_adress') }}"
                        placeholder="Direccion" required>
                    @if ($errors->has('warehouse_adress'))
                    <span style="color:red;">
                        {{ $errors->first('warehouse_adress') }}
                    </span>
                    @endif
                </div>
            </div>
            @endif
            <div class="form-group">
                <h5>
                    <strong>Categoria</strong>
                </h5>
            </div>
            <div class="form-group">
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Seleccione una categoria</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('tax'))
                <span style="color:red;">
                    {{ $errors->first('tax') }}
                </span>
                @endif
            </div>

            <button type="submit" class="btn btn-success">
                Nuevo
            </button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>

    <!-- /.card -->
</div>

</div>
</div>

@endsection


@section('scripts')
<script>
    $('.select2').select2({
        theme: 'bootstrap4',
        tags: true,
        widht: '100%',
    })

</script>
@endsection
