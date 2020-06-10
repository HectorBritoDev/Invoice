@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">

                    @include('layouts.salesTopButtons')

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="d-flex">
                            <div class="dropdown">
                                <button type="button" class="btn btn-warning dropdown-toggle" id="dropdownMenuNewOperation"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-NewOperation="10,20">
                                    Nuevo
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuNewOperation">
                                    <a class="dropdown-item" href="{{ route('good.create','good') }}">Bien</a>
                                    <a class="dropdown-item" href="{{ route('good.create') }}">Servicio</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Tipo</td>
                                <td>Unidad de Medida</td>
                                <td>Código</td>
                                <td>Precio al mayor</td>
                                <td>Precio al por menor</td>
                                <td>Categoria</td>
                                <td>&nbsp;</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goods as $good)
                            <tr>
                                <td>{{ $good->name }}</td>

                                <td>{{ $good->real_type }}</td>


                                <td>
                                    <p class="text-uppercase">{{ $good->measure }}</p>
                                </td>


                                <td>{{ $good->code }}</td>
                                @if ($good->prices()->count()>0)
                                <td>{{ $good->prices()->first()->wholesale_price }}</td>
                                <td>{{ $good->prices()->first()->unit_price }}</td>
                                @else
                                <td></td>
                                <td></td>
                                @endif
                                <td>{{ $good->category->name }}</td>
                                <td>
                                    <a href="
                                        {{ route('good.show',$good) }}"><i
                                            class=" fas fa-eye"></i></a>
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



@endsection

@section('scripts')


<script>
    $(document).ready(function () {
        $('#table').DataTable({

        });
    });

</script>
@endsection
