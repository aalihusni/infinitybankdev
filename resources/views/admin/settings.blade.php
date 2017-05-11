@extends('admin.default')

@section('title')Settings @Stop
@section('homeclass')nav-active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Settings</h1>
                <input type="checkbox" id="hierarchy" name="hierarchy" @if ($settings->fix_hierarchy == 1) Checked @endif> <label id="xhierarchy">Fix Hierarchy</label><br>
                <input type="checkbox" id="hierarchy_bank" name="hierarchy_bank" @if ($settings->fix_hierarchy_bank == 1) Checked @endif> <label id="xhierarchy_bank">Fix Hierarchy Bank</label><br>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $('#hierarchy_bank').keyup(function(){
        set_hierarchy($(this));
    });

    $('#hierarchy_bank').change(function(){
        set_hierarchy($(this));
    });

    $('#hierarchy').keyup(function(){
        set_hierarchy($(this));
    });

    $('#hierarchy').change(function(){
        set_hierarchy($(this));
    });


    function set_hierarchy($item){
        var name;
        var settings;
        var str;

        name = $item.attr('name');

        if($item.is(":checked")) {
            settings = 1;
        } else {
            settings = 0
        }

        if (name == "hierarchy") {
            $('#x' + name).html("Fix Hierarchy <i class='fa fa-refresh'></i>");
        } else {
            $('#x' + name).html("Fix Hierarchy Bank <i class='fa fa-refresh'></i>");
        }

        var loadUrl = '{{ URL::to('/') }}/admin/settings/hierarchy/fix_' + name + '/' + settings;
        $.ajax({
            url: loadUrl, success: function (result) {
                //location.reload();
                if (name == "hierarchy") {
                    $('#x' + name).html("Fix Hierarchy <i class='fa fa-check'></i>");
                } else {
                    $('#x' + name).html("Fix Hierarchy Bank <i class='fa fa-check'></i>");
                }
            }
        });
    }
</script>
@Stop