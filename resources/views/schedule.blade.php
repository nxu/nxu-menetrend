@extends('master')

@section('body')
    <div id="schedule-content">
        <div class="container">
            <h1 class="text-center">
                {{ $from }} <span class="hidden-sm hidden-md hidden-lg"><br></span><span class="hidden-xs">-</span> {{ $to }}
            </h1>
            <h4 class="text-center">{{ $when }}</h4>

            <a id="back" class="text-center" href="/">Vissza</a>

            <div id="schedule">
                <div class="row legend">
                    <div class="visible-xs">
                        <div class="col-xs-9">
                            Honnan <br> Hová
                        </div>
                        <div class="col-xs-3">
                            Indulás <br> Érkezés
                        </div>
                    </div>
                    <div class="hidden-xs">
                        <div class="col-sm-5">Honnan</div>
                        <div class="col-sm-1 text-right">Ind.</div>
                        <div class="col-sm-5">Hová</div>
                        <div class="col-sm-1 text-right">Érk.</div>
                    </div>
                </div>
                @foreach($schedule as $route)
                    <div class="row route">
                        <div class="col-xs-9 col-sm-5">
                            <span class="station">{{ $route['from'] }}</span>
                        </div>
                        <div class="col-xs-3 col-sm-1 text-right">
                            <span class="departure">{{ $route['departure'] }}</span>
                        </div>
                        <div class="col-xs-9 col-sm-5">
                            <span class="station">{{ $route['to'] }}</span>
                        </div>
                        <div class="col-xs-3 col-sm-1 text-right">
                            <span class="arrival">{{ $route['arrival'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <footer class="text-center not-fixed">
        <span class="glyphicon glyphicon-envelope"></span> <span><a href="mailto:{{ env('INFO_MAIL') }}">{{ env('INFO_MAIL') }}</a></span>
        <br>
        Az adatok forrása a <a target="_blank" href="http://www.menetrendek.hu">menetrendek.hu</a>
    </footer>
@endsection