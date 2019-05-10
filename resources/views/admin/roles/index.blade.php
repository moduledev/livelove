@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Управление ролями
    </h1>

    <div class="row">
        <div class="col-xs-12">
            <h3>Добавить роль:</h3>
            <form method="POST" class="form-inline" action="{{route('add.role')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Название:</label>
                    <input id="name" type="text" class="form-control" name="role">
                </div>
                <button type="submit" class="btn btn-default">Добавить</button>
            </form>
        </div>
    </div>



    <table class="table table-hover table-striped text-center">
        <tr>
            <th>Id</th>
            <th>Название</th>
            <th>Операции</th>
        </tr>
        @foreach ($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>
                    <a href="" class="btn btn-info"> <i class="fa fa-eye"></i>  </a>

                    <form method="post" action=""
                          style="display: inline-block">
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" value="{{$role->id}}">
                        <button href="#" class="btn btn-danger" type="submit"><i
                                    class="fa fa-trash"></i></button>
                    </form>

                    <form method="get" action="{{route('admin.role.edit', $role->id)}}"
                          style="display: inline-block">
                        <button href="#" class="btn btn-success" type="submit"><i
                                    class="fa fa-pencil-square"></i></button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>


    {!! $roles->render() !!}
@endsection
@section('content')

@endsection