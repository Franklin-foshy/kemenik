@extends('registrados.layouts.master')
@section('title', 'Usuarios')

@section('content')
<div class="main-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">

                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <h5 class="mt-2">USUARIOS</h5>
                    </div>
                    <div class="col-auto">
                        @if(kvfj(Auth::user()->rol->permissions, 'post_users'))
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newUser">
                                <span data-bs-toggle="tooltip" data-bs-offset="0,1" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<span>Crear nuevo usuario</span>"><i class="fas fa-plus"></i></span>
                            </button>
                            @include('registrados.users.modals.add')
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table data-table table-striped">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No.</th>
                                        <th>Nombre y Apellidos</th>
                                        <th>Rol</th>
                                        <th>Correo Electrónico</th>
                                        <th>Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    @include('registrados.users.modals.edit')
                                    @include('registrados.users.modals.permissions')
                                    <tr class="align-middle">
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            @if ($user->rol->id == 1)
                                            <span class="badge bg-danger">Administrador</span>
                                            @else
                                            <span class="badge bg-primary">Usuario Final</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->status == 1)
                                            <span class="badge bg-success">Activo</span>
                                            @else
                                            <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-icon btn-sm rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if(kvfj(Auth::user()->rol->permissions, 'edit_users'))
                                                    <li>
                                                        <button class="dropdown-item pointer btn-sm" data-bs-toggle="modal" data-bs-target="#editUser{{ $user->id }}">
                                                            <i class="fas fa-edit"></i>&nbsp; Editar
                                                        </button>
                                                    </li>
                                                    @endif
                                                    @if(kvfj(Auth::user()->rol->permissions, 'permissions_users'))
                                                    <li>
                                                        <button class="dropdown-item pointer btn-sm" data-bs-toggle="modal" data-bs-target="#permissionUser{{ $user->id }}">
                                                            <i class="fas fa-key"></i>&nbsp; Permisos
                                                        </button>
                                                    </li>
                                                    @endif
                                                    @if(kvfj(Auth::user()->rol->permissions, 'delete_users'))
                                                    <li>
                                                        <form action="{{ route('user-delete', $user->id) }}" method="post" autocomplete="off" id="delete_form_{{ $user->id }}">
                                                            @csrf
                                                            <button class="dropdown-item pointer btn-sm" type="button" onclick="confirmDelete({{ $user->id }}, {{ $user->status }} ,'el usuario')">
                                                                @switch($user->status)
                                                                @case(0)
                                                                <i class="fas fa-check"></i>&nbsp; Habilitar
                                                                @break
                                                                @case(1)
                                                                <i class="fas fa-ban"></i>&nbsp; Inhabilitar
                                                                @break
                                                                @endswitch
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    @if(kvfj(Auth::user()->rol->permissions, 'recover_passwords_users'))
                                                    <li>
                                                        @if(kvfj(Auth::user()->rol->permissions, 'recover_passwords_users'))
                                                        <form action="{{ route('recover-password', $user->email) }}" method="post" autocomplete="off" id="recover_form_{{ $user->id }}">
                                                            @csrf
                                                            <button class="dropdown-item pointer btn-sm" type="button" onclick="confirmRecover({{$user->id}})">
                                                                <i class="fas fa-lock"></i> &nbsp; Recuperar Contraseña</button>
                                                        </form>
                                                        @endif
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection