@extends('admin.default')

@section('title')Edit News @Stop

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Blast News</h1>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="form-horizontal form-bordered">

                            <div class="form-group">
                                <label class="col-md-2 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                    <button class="btn btn-primary hidden-xs exportmemberlist">Generate Member CSV file</button>
                                    <button class="btn btn-primary btn-block btn-lg visible-xs mt-lg exportmemberlist">Download Member CSV</button>

                                    <button class="btn btn-default hidden-xs exportnonmemberlist">Generate Non-Member CSV file</button>
                                    <button class="btn btn-default btn-block btn-lg visible-xs mt-lg exportnonmemberlist">Download Non-Member CSV</button>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                    <div id="downloadlink"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">Title/Subject</label>
                                <div class="col-md-9">
                                    <input type="text" name="title" class="form-control"
                                           id="inputDefault" value="{{$news->title}}" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label"
                                       for="inputDefault">HTML</label>
                                <div class="col-md-9">
                                    <textarea name="news" rows="20" cols="50"
                                              class="form-control" required>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
</head>

<body bgcolor="#EEEEEE"; style=" margin: 0; padding: 0; line-height: 1.6; width: 100% !important; height: 100%;">
<div style="background-color:#eeeeee; background-image:url('http://s7.postimg.org/rvamfe3yj/200black.png'); background-repeat: repeat-x;">
    <table style="max-width:700px;" align="center" width="100%" cellpading="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
            <td bgcolor="black" width="90%" height="50" valign="bottom"><br><img src="http://s9.postimg.org/6eesqjzf3/logo.png" width="300" style="margin-bottom:5px;"/></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <div style="padding:30px; background-color:#FFF; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; font-size:14px; font-family: sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; color:#999;">
                    {{nl2br($news->news)}}
                    <p>Thank you.</p>
                    <p><strong>#Bitregion</strong><br/>
                        <strong style="color:#000;">www.bitregion.com</strong></p>
                    <br><br>
                    <div style="font-size:12px; color:#999; border-top:thin solid #CCC; padding-top:10px;"><br>
                        <!--<a href="#/members/manage-emails" style="text-decoration:none; color:#999; font-weight:bold;">Manage Email Notification</a>--></div>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td height="40" valign="middle" style="font-size:12px; color:#999; font-family: sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none;">
                <table width="100%">
                    <tr>
                        <td align="left">Los Angeles, CA 90069</td>
                        <td align="right"><strong>2015 &copy; BitRegion.com</strong></td>
                    </tr>
                </table>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
</body>
</html>
                                    </textarea>
                                </div>
                            </div>


                        </div>

                        </div>
                    </div>


            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">
    $('.exportmemberlist').click(function(){
        var loadUrl = "{{URL::route('import-members')}}";
        $("#downloadlink")
                .html('Generating CSV file. Please wait...')
                .load(loadUrl);
    });
    $('.exportnonmemberlist').click(function(){
        var loadUrl = "{{URL::route('import-nonmembers')}}";
        $("#downloadlink")
                .html('Generating CSV file. Please wait...')
                .load(loadUrl);
    });
</script>
@Stop