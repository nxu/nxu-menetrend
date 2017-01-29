@extends('master')


@section('body')
    <div id="main-content" class="bg-{{ $bgId }}">
        <div id="main-content-wrapper">
            <div id="search-form-container" class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1>Menetrend <span class="beta">béta</span></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-10 col-md-push-1 col-lg-6 col-lg-push-3">

                        @if (!empty($errorMessage))
                            <div class="alert alert-danger" role="alert">
                                {{ $errorMessage }}
                            </div>
                        @endif
                        @if (!empty($errors))
                            <div class="alert alert-danger" role="alert">
                                @foreach($errors->all() as $err)
                                    <p>{{ $err }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form id="search-form" action="/menetrend" method="post">
                            <div class="prefixed-input">
                                <label for="from" class="glyphicon glyphicon-home"></label>
                                <input type="text" name="from_text" autocomplete="off" autofocus class="form-control required" placeholder="Honnan?" id="from">
                                <input type="hidden" id="from_hidden" name="from">
                            </div>

                            <div class="prefixed-input">
                                <label for="to" class="glyphicon glyphicon-arrow-right"></label>
                                <input type="text" name="to_text" autocomplete="off" class="form-control required" placeholder="Hová?" id="to">
                                <input type="hidden" id="to_hidden" name="to">
                            </div>

                            <div class="prefixed-input">
                                <label for="when" class="glyphicon glyphicon-calendar"></label>
                                <input type="text" class="form-control" placeholder="Mikor?" name="when" id="when">
                            </div>

                            <button type="submit" class="search btn btn-primary">
                                <span class="glyphicon glyphicon-search"></span>
                                <span>Keresés</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <footer class="text-center">
            <span class="glyphicon glyphicon-envelope"></span> <span><a href="mailto:{{ env('INFO_MAIL') }}">{{ env('INFO_MAIL') }}</a></span>
            <br>
            Az adatok forrása a <a target="_blank" href="http://www.menetrendek.hu">menetrendek.hu</a>
        </footer>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="schedule-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span id="schedule-title"></span></h4>
                </div>
                <div class="modal-body">
                    <div id="schedule-container">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('extra-scripts')


    <script type="application/javascript">
        $(document).ready(function() {

            $("#from").easyAutocomplete({
                url: function(phrase) {
                    return "api/v1/stations/" + phrase;
                },
                cssClasses: "menetrend",
                getValue: "name",
                list: {
                    onSelectItemEvent: function() {
                        var data = $("#from").getSelectedItemData();
                        $("#from_hidden").val(data.settlement_id);
                    }
                }
            });

            $("#to").easyAutocomplete({
                url: function(phrase) {
                    return "api/v1/stations/" + phrase;
                },
                cssClasses: "menetrend",
                getValue: "name",
                list: {
                    onSelectItemEvent: function() {
                        var data = $("#to").getSelectedItemData();
                        $("#to_hidden").val(data.settlement_id);
                    }
                }
            });


            $("#when").pickadate({
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true,
                min: new Date(),
                onStart: function() {
                    this.set('select', new Date())
                }
            });


            $("#search-form").submit(function(e) {

                // Hyper simple validation
                if ($("#from").val() == '' ||
                    $("#to").val() == '' ||
                    $("#when").val() == '') {
                    e.preventDefault();
                    return false;
                }

                $("#loading-indicator").show();
            });
        });
    </script>
@endsection
