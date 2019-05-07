@extends('admin.layouts.app')
@section('content-header')
    <h1>
         Программа "{{$program->name}}"
    </h1>
     {{ Breadcrumbs::render('show-program',$program->id,$program->name) }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12 ">
           @isset($program->image)
                <div class="image_container">
                    <a href="{{asset('storage/' . $program->image)}}" target="_blank"><img src="{{asset('storage/' . $program->image)}}" class="img-responsive img-rounded" alt=""></a>
                </div>
                @endisset
                <ul class="list-group">
                    <li class="list-group-item"><p class="text-bold">Id:<span> {{$program->id}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Название:<span> {{$program->name}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Старт программы:<span> {{$program->started}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Окончание программы:<span> {{$program->finished}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Длительность:<span> {{$program->term}}</span></p></li>
                    <li class="list-group-item"><p class="text-bold">Описание:</p>
                        <textarea name="" id="summernote" cols="30" rows="10" disabled>{{htmlspecialchars_decode($program->description)}}</textarea> </li>
                    <li class="list-group-item"><p class="text-bold">Участники:
                        <ul class="list-group">
                            @foreach($program->members as $member)
                                <li class="list-group-item"><a href="">{{$member->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
         
               <form method="get" action="{{ route('edit.program',$program->id) }}"
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