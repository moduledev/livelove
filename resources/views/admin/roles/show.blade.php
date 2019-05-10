@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Роль "{{$role->name}}"
    </h1>
    {{ Breadcrumbs::render('show-role',$role->id,$role->name) }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12 ">
            <ul class="list-group">
                <li class="list-group-item"><p class="text-bold">Id:<span> {{$role->id}}</span></p></li>
                <li class="list-group-item"><p class="text-bold">Название:<span> {{$role->name}}</span></p></li>
                <li class="list-group-item"><p class="text-bold">Permissions:
                    <ul class="list-group">
                        @foreach($permissions as $permission)
                            <li class="list-group-item">{{$permission->name}}</li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <form method="get" action="{{ route('admin.role.edit',$role->id) }}"
                  style="display: inline-block">
                <button href="#" class="btn btn-success" type="submit"><i
                            class="fa fa-pencil-square"></i></button>
            </form>
        </div>
    </div>

@endsection