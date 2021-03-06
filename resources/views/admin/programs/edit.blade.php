@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Изменить программу
    </h1>
    {{-- {{ Breadcrumbs::render('edit',$user->id) }} --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12 ">

            <div class="box">
                <div class="box-header">
                    <div class="box-body">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                              action="{{route('update.program',$program->id)}}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            @isset($program->image)
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">Фото:</label>
                                    <div class="image_container col-sm-10">
                                        <img src="{{asset('storage/'. $program->image)}}"
                                             class="img-rounded img-responsive" alt="">
                                    </div>
                                </div>
                            @endisset
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="image">Изменить фото:</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Имя:</label>
                                <div class="col-sm-10">
                                    <input value="{{$program->title}}" type="text" name="title" class="form-control"
                                           placeholder="Имя">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="location">Место проведения:</label>
                                <div class="col-sm-10">
                                    <input value="{{$program->location}}" type="text" name="location" class="form-control"
                                           placeholder="Место проведения">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Старт программы:</label>
                                <div class="col-sm-10">
                                    <input type="date"
                                           value="{{\Carbon\Carbon::createFromDate($program->started)->format('Y-m-d')}}"
                                           name="started" class="form-control" placeholder="Телефон">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Окончание программы:</label>
                                <div class="col-sm-10">
                                    <input type="date"
                                           value="{{\Carbon\Carbon::createFromDate($program->finished)->format('Y-m-d')}}"
                                           name="finished" class="form-control" placeholder="Телефон">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="description">Описание:</label>
                                <div class="col-sm-10">
                                  <textarea class="form-control" name="description" id="summernote"
                                            placeholder="Описание"
                                            cols="10">{{htmlspecialchars_decode($program->description)}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Изменить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote();
        });
    </script>
@endsection