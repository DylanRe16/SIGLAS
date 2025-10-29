@extends('welcome')


@section('contenido')

    <div class="content-wrapper">

        <section class="content-header">
            <h3 >Gestor de Usuarios</h3>
        </section>

        <section class="content">
            <div class="box">

                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearUsuario"> Crear Usuario</button>
                </div>

                <div class="box-body">

                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th style="width:10px;">#</th>
                                <th style="text-align: center;">Nombre</th>
                                <th style="text-align: center;">Email</th>
                                <th style="text-align: center;">Foto</th>
                                <th style="text-align: center;">Sucursal</th>
                                <th style="text-align: center;">Rol</th>
                                <th style="text-align: center;">Estado</th>
                                <th style="text-align: center;">Ultimo login</th>
                                <th style="text-align: center;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $key => $usuario)

                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td style="text-align: center;">{{ $usuario->name }}</td>
                                    <td style="text-align: center;">{{ $usuario->email }}</td>
                                    @if($usuario->foto != '')
                                        <td style="text-align: center;"><img src="{{ url($usuario->foto) }}" class="img-thumbnail" width="40px" alt="User Image"></td>
                                    @else
                                        <td style="text-align: center;"><img src="{{ url('storage/users/anonymous.png') }}" class="img-thumbnail" width="40px" alt="User Image"></td>
                                    @endif
                                    <td style="text-align: center;">
                                        @if($usuario->rol != 'Administrador' && $usuario->sucursal)
                                            {{ $usuario->sucursal->nombre }}
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $usuario->rol }}</td>
                                    <td style="text-align: center;">

                                        @if($usuario->estado == 1)

                                            <button class="btn btn-xs btnEstadoUser btn-success" Uid="{{ $usuario->id }}" estado="0">Activado</button>

                                        @else

                                            <button class="btn btn-xs btnEstadoUser btn-danger" Uid="{{ $usuario->id }}" estado="1">Desactivado</button>

                                        @endif
                                    </td>
                                    
                                    <td style="text-align: center;">{{ $usuario->ultimo_login }}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-warning btnEditarUsuario" data-toggle="modal" data-target="#modalEditarUsuario" title="Editar" idUsuario="{{ $usuario->id }}"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger btnEliminarUsuario" title="Eliminar" idUsuario="{{ $usuario->id }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </section>

    </div>

    <div class="modal fade" id="modalCrearUsuario">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    
                    @csrf

                    <div class="modal-header" style=" background-color: #3c8dbc; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Crear Usuario</h4>
                    </div>

                    <div class="modal-body">

                    <div class="box-body">

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control input-sm" name="name" placeholder="Ingresar Nombre" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon">@</span>
                            <input type="email" class="form-control input-sm" name="email" placeholder="Ingresar Email" required>
                            </div>
                        </div>

                        @error('email')
                            <p class="alert alert-danger">El Email ya se encuentra registrado.</p>
                        @enderror 

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control input-sm" name="password" placeholder="Ingresar contraseña">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <select class="form-control input-sm selectRol" name="rol">
                                    <option value="">Seleccionar Rol</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Encargado">Encargado</option>
                                    <option value="Vendedor">Vendedor</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group selectSucursal" style="display: none;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <select class="form-control input-sm" name="id_sucursal">
                                    <option value="">Seleccionar Sucursal</option>
                                    
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>

                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-danger pull-left btn-sm" data-dismiss="modal">Salir</button>
                    <button class="btn btn-primary btn-sm" type="submit">Crear Usuario</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modalEditarUsuario">
        <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ url('actualizar-usuario')}}">
                
                @csrf
                @method('PUT');

                <div class="modal-header" style=" background-color: #ffc107; color: black;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Usuario</h4>
                </div>

                <div class="modal-body">

                    <div class="box-body">

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control input-sm" name="name" id="nameEditar" placeholder="Ingresar Nombre" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control input-sm" name="id" id="idEditar" placeholder="Ingresar Nombre" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon">@</span>
                            <input type="email" class="form-control input-sm" name="email" id="emailEditar" placeholder="Ingresar Email" required>
                            </div>
                        </div>

                        @error('email')
                            <p class="alert alert-danger">El Email ya se encuentra registrado.</p>
                        @enderror 

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control input-sm" name="password" id="passwordEditar" placeholder="Nueva contraseña">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <select class="form-control input-sm selectRol" name="rol" id="rolEditar">
                                    <option value="">Seleccionar Rol</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Encargado">Encargado</option>
                                    <option value="Vendedor">Vendedor</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group selectSucursal" style="display: none;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <select class="form-control input-sm" name="id_sucursal" id="id_sucursalEditar">
                                    <option value="">Seleccionar Sucursal</option>
                                    
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                <button class="btn btn-danger pull-left btn-sm" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-success btn-sm" type="submit">Guardar Cambios</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

