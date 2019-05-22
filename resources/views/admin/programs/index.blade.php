@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Программы
    </h1>
     {{ Breadcrumbs::render('programs') }}
@endsection
@section('content')
    <section id="app">

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Список всех программ</h3>
                        <div class="box-body">
                                @isset($programs)
                                <table class="table table-hover table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Время проведения</th>
                                        <th>Операция</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($programs as $program)
                                        <tr>
                                            <td>{{$program->id}}</td>
                                            <td>{{$program->title}}</td>
                                            <td>{{\Carbon\CarbonInterval::second($program->duration)->cascade()->forHumans()}}</td>
                                            <td>
                                                <div class="text-center">
                                                    <a href="{{route('show.program', $program->id)}}" class="btn btn-info"> <i class="fa fa-eye"></i>  </a>
            
                                                    <form method="post" action="{{ route('delete.program') }}"
                                                          style="display: inline-block">
                                                        {!! csrf_field() !!}
                                                        {{ method_field('DELETE') }}
                                                        <input type="hidden" name="id" value="{{$program->id}}">
                                                        <button href="#" class="btn btn-danger" type="submit"><i
                                                                    class="fa fa-trash"></i></button>
                                                    </form>
            
                                                    <form method="get" action="{{ route('edit.program',$program->id) }}"
                                                          style="display: inline-block">
                                                        <button href="#" class="btn btn-success" type="submit"><i
                                                                    class="fa fa-pencil-square"></i></button>
                                                    </form>
            
            
                                                </div>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endisset
                            {{ $programs->appends(['term'])->links() }}
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </section>
    <script src="{{asset('js/program.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection