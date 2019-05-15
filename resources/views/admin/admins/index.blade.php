@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Администраторы
    </h1>
    {{ Breadcrumbs::render('admins') }}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h3>Добавить нового администратора:</h3>
            <form method="POST" class="form-inline {{ $errors->has('email') ? 'error_group' :'' }}" action="{{route('admin.register.store')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'error_input' :'' }}" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-default">Добавить</button>
            </form>
            @if ($errors->any())
                <div class="form-group error_group">
                    <div class="col-xs-10">
                        <p class="error_element">{{$errors->first('email')}}</p>
                    </div>
                    @endif
                </div>
        </div>
        <div class="col-xs-12">
            @isset($admins)
                <table class="table table-hover table-striped  text-center">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>E-mail</th>
                        <th>Роль</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{$admin->id}}</td>
                            <td>{{$admin->name}}</td>
                            <td>{{$admin->email}}</td>
                            <td>
                                @foreach($admin->roles as $role)
                                    <span style="padding: 5px; background: #0d6aad;border-radius: 3px; color: #fff">{{$role->name}}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class=" text-center">
                                    <a href="{{route('admin.admins.show', $admin->id)}}" class="btn btn-info"> <i
                                                class="fa fa-eye"></i> </a>

                                    <form method="post" action="{{ route('admin.admins.delete', $admin->id) }}"
                                          style="display: inline-block">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="id" value="{{$admin->id}}">
                                        <button href="#" class="btn btn-danger" type="submit"><i
                                                    class="fa fa-trash"></i></button>
                                    </form>

                                    <form method="get" action="{{ route('admin.admins.edit',$admin->id) }}"
                                          style="display: inline-block">
                                        <button href="#" class="btn btn-success" type="submit"><i
                                                    class="fa fa-pencil-square"></i></button>
                                    </form>

                                </div>
                    @endforeach
                    </tbody>
                </table>
            @endisset
            {{ $admins->links() }}
        </div>
    </div>
@endsection