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
                <h4>Добавить новую программу</h4>
            </div>
            <div class="col-xs-12">
                <form class="form-horizontal" method="POST" action="{{route('add.program')}}" enctype="multipart/form-data"
                      {{--:class="{error_group: startTimeError, error_group: finishTimeError}">--}}
                      :class="[startTimeError ? 'error_group' : '',finishTimeError ? 'error_group' : '']">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="image">Добавить фото:</label>
                        <div class="col-xs-6">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    @if ($errors->has('image'))
                        <div class="form-group error_group">
                            <div class="col-xs-10 col-sm-offset-2">
                                <p class="error_element">{{$errors->first('image')}}</p>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name">Имя:</label>
                                <div class="col-xs-6">
                                    <input type="text" name="name" class="form-control" placeholder="Имя">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="control-label col-sm-2" for="started">Старт программы:</label>
                                <div class="col-xs-3">
                                    <input type="date"
                                           name="started"
                                           class="form-control" placeholder="Имя"
                                           :class="{error_input: startTimeError}"
                                           @change="start(startTime)"
                                           v-model="startTime" >
                                </div>
                                <template v-if="startTimeError">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <p class="error_element">@{{errorStartTimeMessage}}</p>
                                    </div>
                                </template>
                            </div>
                            @if ($message = Session::get('started_error'))
                                <div class="form-group error_group">
                                    <div class="col-xs-10 col-sm-offset-2">
                                        <p class="error_element">{{ $message }}</p>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="finished">Окончание программы:</label>
                                        <div class="col-xs-3">
                                            <input type="date"
                                                   name="finished"
                                                   placeholder="Имя"
                                                   class="form-control"
                                                   :class="{error_input: finishTimeError}"
                                                   @change="finish(finishTime)"
                                                   v-model="finishTime">
                                        </div>
                                        <template v-if="finishTimeError">
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <p class="error_element">@{{errorFinishTimeMessage}}</p>
                                            </div>
                                        </template>
                                    </div>
                                    @if ($message = Session::get('finished_error'))
                                        <div class="form-group">
                                            <div class="col-xs-10 col-sm-offset-2">
                                                <p class="alert alert-error">{{ $message }}</p>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="description">Описание:</label>
                                                <div class="col-sm-10">
                        <textarea class="form-control" name="description" id="summernote" placeholder="Описание программы"
                                  cols="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" :class="{error_btn: finishTimeError,error_btn: startTimeError }" class="btn btn-default"
                                                            :disabled="finishTimeError||startTimeError">Добавить</button>
                                                </div>
                                            </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
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
                                <td>{{$program->name}}</td>
                                <td>{{$program->term}}</td>
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
    </section>
    <script src="{{asset('js/program.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection