@extends('member.default')

@section('title')Section Under Maintenance @Stop
@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-4">
                    <label class="control-label"><strong>Sorry, this section is under maintenance.</strong></label><br><br>
                    We are currently upgrading our system. Please come back later in a short while.<br><br>

                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        $('#basic').flagStrap({
            buttonSize: "btn-md btn-block",
            labelMargin: "10px",
            scrollable: true,
            scrollableHeight: "300px"
        });


    </script>
    @Stop