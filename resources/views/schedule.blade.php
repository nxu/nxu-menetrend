@extends('master')

@section('body')
    <div id="schedule-content">
        <div class="container">
            <h1 class="text-center">
                {{ $from }} <span class="hidden-md hidden-lg"><br></span><span class="hidden-xs hidden-sm">-</span> {{ $to }}
            </h1>
            <h4 class="text-center">{{ $when }}</h4>

            <a id="back" class="text-center" href="/">Vissza</a>

            <div id="schedule">
                <div class="row">
                    <div class="col-xs-12 col-md-8 col-md-push-2 col-lg-6 col-lg-push-3">
                        <div class="row route legend">
                            <div class="col-xs-9 col-md-10 text-left">
                                <strong>Honnan<br>Hová</strong>
                            </div>

                            <div class="col-xs-3 col-md-2 text-right">
                                <strong>Indulás<br>Érkezés</strong>
                            </div>
                        </div>

                        @foreach($schedule as $route)
                            <div class="row route @if ($route->alreadyGone()) gone @else next @endif">
                                <div class="col-xs-9 col-md-10 text-left">
                                    <span class="station">{{ $route->from }}</span>
                                    <span class="station">{{ $route->to }}</span>
                                </div>
                                <div class="col-xs-3 col-md-2 text-right">
                                    <span class="departure">{{ $route->departure->format('H:i') }}</span>
                                    <span class="arrival">{{ $route->arrival->format('H:i') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center not-fixed">
        <span class="glyphicon glyphicon-envelope"></span> <span><a href="mailto:{{ env('INFO_MAIL') }}">{{ env('INFO_MAIL') }}</a></span>
        <br>
        Az adatok forrása a <a target="_blank" href="http://www.menetrendek.hu">menetrendek.hu</a>
    </footer>
@endsection

@section('extra-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var $first = $(".route.next").first();
            $('html, body').animate({
                scrollTop: $first.offset().top - 70
            }, 500);
        });
    </script>
@endsection
