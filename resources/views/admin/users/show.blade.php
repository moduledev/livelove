@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Пользователь "{{$user->name}}"
    </h1>
    {{ Breadcrumbs::render('show-user',$user->id,$user->name) }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12 ">
            @isset($user->image)
                <div class="image_container">
                    <a href="{{asset('storage/' . $user->image)}}" target="_blank"><img src="{{asset('storage/' . $user->image)}}" class="img-responsive img-rounded" alt=""></a>
                </div>
            @endisset
                <ul class="list-group">
                    <li class="list-group-item"><p class="text-bold">Id:<span> {{$user->id}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Имя:<span> {{$user->name}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Телефон:<span> {{$user->phone}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Должность:<span> {{$user->position}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Биография:</p>
                        <textarea name="" id="summernote" cols="30" rows="10" disabled>{{htmlspecialchars_decode($user->biography)}}</textarea> </li>
                    <li class="list-group-item"><p class="text-bold">Программы:
                        <ul class="list-group">
                            @foreach($user->programs as $program)
                                <li class="list-group-item"><a href="{{route('show.program',$program->id)}}">{{$program->title}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>

            <form method="get" action="{{ route('admin.user.edit',$user->id) }}"
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