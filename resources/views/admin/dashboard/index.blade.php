@extends('admin.layouts.app')
@section('content-header')
    <h1>
        Главная страница
    </h1>
    {{--    {{ Breadcrumbs::render('dashboard') }}--}}

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$users}}</h3>

                    <p>Пользователей</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('dashboard.users')}}" class="small-box-footer">Детали <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$programs}}</h3>

                    <p>Програм</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('dashboard.programs')}}" class="small-box-footer">Детали <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection