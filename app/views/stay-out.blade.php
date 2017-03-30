@extends('master')

@section('title', 'Error')

@section('content')

<div class="row" style="margin-left: -283px; ">
    <div class="col-md-12">
        <div class="error-template">
            <h1>
                Oops!</h1>
            <h2>
                {{trans('main.Estadiaout')}}</h2>
            <div class="error-details">
                {{trans('main.Estadiaout_mgs')}}</h2>
               
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('roomers/plugins/jquery/jquery-2.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('roomers/plugins/materialize/js/bin/materialize.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('roomers/plugins/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('roomers/plugins/pickadate/lib/compressed/legacy.js')}}"></script>
    <script type="text/javascript" src="{{ asset('roomers/plugins/pickadate/lib/compressed/picker.date.js')}}"></script>
    <script type="text/javascript" src="{{ asset('roomers/plugins/pickadate/lib/compressed/picker.time.js')}}"></script>

    <script type="text/javascript" src="{{ asset('roomers/plugins/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/plugins/moment/moment.js')}}"></script>
    <script type="text/javascript" src="{{ asset('roomers/plugins/store/store.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('roomers/js/roomers.js')}}"></script>

    <script>
         store.clear();
        store.set('item_list',null);
        store.set('item_time',0);
        store.set('item_total',0);
        store.set('item_num',0);
        $('#label_numcar').text('0');
        $('#listCartsBody').html('');
        $('#datetimepicker4').val('');
        $('#datetimepicker1').val('');
    </script>
@stop
