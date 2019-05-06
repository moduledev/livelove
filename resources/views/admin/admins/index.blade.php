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
            <form method="POST" class="form-inline" action="{{route('admin.register.store')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-default">Добавить</button>
            </form>
        </div>
        <div class="col-xs-12">
            @isset($admins)
                <table class="table table-hover">
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
                            <td></td>
                            <td>
                                <div >
                                    <a href="{{route('admin.admins.show', $admin->id)}}" class="btn btn-info"> <i class="fa fa-eye"></i> </a>

                                    <form method="post" action="{{ route('admin.admins.delete', $admin->id) }}" style="display: inline-block">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="id" value="{{$admin->id}}">
                                        <button href="#" class="btn btn-danger" type="submit"> <i class="fa fa-trash"></i> </button>
                                    </form>

                                    <form method="get" action="{{ route('admin.admins.edit',$admin->id) }}" style="display: inline-block">
                                        <button href="#" class="btn btn-success" type="submit"> <i class="fa fa-pencil-square"></i> </button>
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