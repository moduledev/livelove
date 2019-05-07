@extends('admin.layouts.app')
@section('content-header')
    <h1>
     "{{$admin->name}}"
    </h1>
    {{ Breadcrumbs::render('show-admin',$admin->id,$admin->name) }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12 ">
            @isset($admin->image)
                <div class="image_container">
                    <a href="{{asset('storage/' . $admin->image)}}" target="_blank"><img src="{{asset('storage/' . $admin->image)}}" class="img-responsive img-rounded" alt=""></a>
                </div>
            @endisset
                <ul class="list-group">
                    <li class="list-group-item"><p class="text-bold">Id:<span> {{$admin->id}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Имя:<span> {{$admin->name}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Email:<span> {{$admin->email}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Роли:
                        <ul class="list-group">
                            @foreach($adminsDermissions as $role)
                                <li class="list-group-item"><span>{{$role->name}}</span></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>

            <form method="get" action="{{ route('admin.admins.edit',$admin->id) }}"
                  style="display: inline-block">
                <button href="#" class="btn btn-success" type="submit"><i
                            class="fa fa-pencil-square"></i></button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote('disable');
        });
    </script>
@endsection