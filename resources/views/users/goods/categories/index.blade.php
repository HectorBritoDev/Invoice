@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3><strong>Categorias</strong></h3>

                    <div class="card-tools">

                        <button data-toggle="modal" data-target="#categoryCreateModal" class="btn btn-success">
                            Agregar
                            <i class="fas fa-user-plus fa-fw"></i>
                        </button>


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
                    <table class="table table-hover" id="">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Bien</th>
                                <th>Servicio</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td><strong>{{ $category->name}}</strong></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="#"><i class="fas fa-eye"></i></a>
                                    /
                                    <a href="#"><i class="fa fa-edit teal"></i></a>
                                </td>
                                <td>@include('users.goods.categories.statusSwitchForm')</td>
                            </tr>

                            @foreach ($category->subCategories as $subCategory)
                            <tr>
                                <td>{{ $subCategory->name }}</td>
                                <td>@include('users.goods.subCategories.goodSwitchForm')</td>
                                <td>@include('users.goods.subCategories.serviceSwitchForm')</td>
                                <td></td>
                                <td>@include('users.goods.subCategories.statusSwitchForm')</td>

                            </tr>
                            @endforeach


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


<!--CREATE Good Modal -->
<div class="modal fade" id="goodCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Bienes y Servicios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('good.store') }}" method="POST">
                    @csrf

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
        $('#table').DataTable();

        $('.select2').select2({
            tags: true,
        });

    });

</script>
@endsection
