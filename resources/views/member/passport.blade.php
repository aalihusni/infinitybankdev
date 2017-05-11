@extends('member.default')

@section('title')Buy SoftKey @Stop

@section('passport-class')nav-active @Stop
@section('menu_setting') @Stop

@section('content')
 <div id="wrapper">
     <div class="main-content">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


     </div>
</div>

<script type="text/javascript">
    var myTimer = null;
    var ppTimer = null;
    var quantity = 1;
    var modal_status = false;

    var passport_price;
    var passport_percent_discount;
    var passport_discount;
    var passport_after_discount;
    var passport_total;
    var passport_total_discount;
    var passport_total_after_discount;

    $('#quantity').keyup(function(){
        quantity = $('#quantity').val();
        if (quantity > 0) {
            get_passport_price(quantity);
        } else {
            $('#total_price').html('<span class="fa fa-bitcoin"></span> ');
            $('#percent_discount').html('<strong>%</strong> ');
            $('#total_discount').html('<span class="fa fa-bitcoin"></span> ');
            $('#total_after_discount').html('<span class="fa fa-bitcoin"></span> ');
            $('#quantity_href').addClass('disabled');
        }
    });

    $('#quantity').change(function(){
        quantity = $('#quantity').val();
        if (quantity > 0) {
            get_passport_price(quantity);
        } else {
            quantity = 1;
            $('#quantity').val(quantity);
            get_passport_price(quantity);
        }
    });

    $(document).ready(function() {
        $('#quantity').val(quantity);
        if (quantity > 0) {
            get_passport_price(quantity);
        }
    });

    function check_passport_price()
    {
        if ($('#quantity_href').attr('disabled') == true) {
            clearInterval(ppTimer);
            ppTimer = setInterval(function () {
                get_passport_price(quantity);
            }, 3000);
        }
    }

    function get_passport_price(quantity){
        $('#quantity_href').attr('href', '{{ URL::to('/') }}/members/ajax-passport/' + quantity);
        $('#total_price').html('<span class="fa fa-bitcoin"></span> ');
        $('#percent_discount').html('<strong>%</strong> ');
        $('#total_discount').html('<span class="fa fa-bitcoin"></span> ');
        $('#total_after_discount').html('<span class="fa fa-bitcoin"></span> ');
        $('#quantity_href').attr('disabled', true);
        check_passport_price();

        var loadUrl = '{{ URL::to('/') }}/passport-price/' + quantity;
        $.ajax({url: loadUrl, success: function(result) {
            var obj = $.parseJSON(result);

            passport_price = obj.passport_price;
            passport_percent_discount = obj.passport_percent_discount;
            passport_discount = obj.passport_discount;
            passport_after_discount = obj.passport_after_discount;
            passport_total = obj.passport_total;
            passport_total_discount = obj.passport_total_discount;
            passport_total_after_discount = obj.passport_total_after_discount;

            $('#total_price').html('<span class="fa fa-bitcoin"></span> ' + passport_total.toFixed(8));
            $('#percent_discount').html('<strong>%</strong> ' + passport_percent_discount);
            $('#total_discount').html('<span class="fa fa-bitcoin"></span> ' + passport_total_discount.toFixed(8));
            $('#total_after_discount').html('<span class="fa fa-bitcoin"></span> ' + passport_total_after_discount.toFixed(8));
            if (passport_total_after_discount > 0) {
                $('#quantity_href').attr('disabled', false);
            } else {
                $('#quantity_href').attr('disabled', true);
            }
            clearInterval(ppTimer);

        }});
    }

    $('.modal-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        modal: true,

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                get_receiving_address();
                if($(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(window['timer_MSms_timer']);
        window = [];
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        clearInterval(window['timer_MSms_timer']);
        window = [];
    });

    (function( $ ) {

        'use strict';

        var datatableInit = function() {

            $('#datatable-default').dataTable();

        };

        $(function() {
            datatableInit();
        });

    }).apply( this, [ jQuery ]);

</script>
@Stop