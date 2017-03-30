@extends('master')

@section('title')
 @if (Session::has('mgs'))
               {{Session::get('mgs')}}
                @endif
                 @if (Session::has('mgspass'))
               {{Session::get('mgspass')}}
                @endif
                
               <?php echo $errors->first('username'); ?>
               <?php echo $errors->first('token'); ?>
@stop()

@section('content')

<div class="row" style="margin-left: -283px; ">
    <div class="col-md-12">
        <div class="error-template">
            <h1>
                Oops!</h1>
            <h2>
                {{trans('main.error')}}
                </h2>
            <div class="error-details">
                @if (Session::has('mgs'))
                <p>{{Session::get('mgs')}}</p>
                @endif
                 @if (Session::has('mgspass'))
                <p>{{Session::get('mgspass')}}</p>
                @endif
                
               <p> <?php echo $errors->first('username'); ?></p>
               <p> <?php echo $errors->first('token'); ?></p>
                

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
