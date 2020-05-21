@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="{{ asset("assets/stylesheets/mycss.css") }}" />
{{--    <link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />--}}
    <h1 style="text-align: center; margin-top: 0px; padding-bottom: 20px; color: #00adff">WORX FOOTBALL DASHBOARD</h1>
    <div class="row container-fluid">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-3">
                            <i class="fas fa-futbol fa-5x"></i>
                        </div>
                        <div class="col-9 text-right">
                            <div class="huge">{{$info['player_count']}}</div>
                            <div>Players</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.players.index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-3">
{{--                            <img src="assets/icon/noun_Football_156912.svg"></img>--}}
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-9 text-right">
                            <div class="huge">{{$info['match_count']}}</div>
                            <div>Matches</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.matches.index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-3">
                            <i class="fas fa-user-shield fa-5x"></i>
                        </div>
                        <div class="col-9 text-right">
                            <div class="huge">{{$info['user_count']}}</div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
{{--        <div class="col-lg-3 col-md-6">--}}
{{--            <div class="panel panel-red">--}}
{{--                <div class="panel-heading">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-3">--}}
{{--                            <i class="fa fa-support fa-5x"></i>--}}
{{--                        </div>--}}
{{--                        <div class="col-9 text-right">--}}
{{--                            <div class="huge">13</div>--}}
{{--                            <div>Today Match</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <a href="#">--}}
{{--                    <div class="panel-footer">--}}
{{--                        <span class="pull-left">View Details</span>--}}
{{--                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>--}}
{{--                        <div class="clearfix"></div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@stop

