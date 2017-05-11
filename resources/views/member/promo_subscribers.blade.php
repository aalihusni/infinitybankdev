@extends('member.default')

@section('title')Prospect Management @Stop

@section('promosubscriber-class')nav-active @Stop
@section('promo-class')nav-expanded nav-active @Stop
@section('menu_setting') @Stop

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">New Prospect(s)</a>
                        </li>
                        <li><a class="text-primary" href="#contacted" data-toggle="tab">Contacted Prospect(s)</a>
                        </li>
                        <li><a class="text-muted" href="#kiv" data-toggle="tab">KIV</a>
                        </li>
                        <li><a class="text-danger" href="#uninterested" data-toggle="tab">Uninterested</a>
                        </li>
                        <li><a class="text-success" href="#closed" data-toggle="tab">Closed</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="home">

                            <table class="table table-hover table-bordered table-striped mb-none" id="newTables">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="hidden-xs">Email</th>
                                    <th>Mobile</th>
                                    <th class="hidden-xs">Page</th>
                                    <th class="hidden-xs">Opt-in Date</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($newsubs as $promosub)


                                <tr class="gradeX modal-basic" style="cursor:pointer;" href="#list{{$promosub->id}}">
                                    <td>{{$promosub->firstname}} {{$promosub->lastname}}</td>
                                    <td class="hidden-xs">{{$promosub->email}}</td>
                                    <td>{{$promosub->mobile}}</td>
                                    <td class="hidden-xs">{{$promosub->title}}</td>
                                    <td class="hidden-xs"><span class="text-muted">{{ App\Classes\TimeAgoClass::xTimeAgo($promosub->created_at) }}</span></td>
                                </tr>


                                <div id="list{{$promosub->id}}" class="modal-block mfp-hide">
                                    <section class="panel">
                                        <form id="subscribeform" method="post" action="{{URL::route('update-prospect')}}">
                                        <header class="panel-heading">
                                            <h2 class="panel-title">Prospect's Information</h2>
                                        </header>
                                        <div class="panel-body">

                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="pid" value="{{$promosub->id}}">

                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" value="{{$promosub->firstname}}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" value="{{$promosub->lastname}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" name="email" class="form-control" placeholder="Email" value="{{$promosub->email}}" required>
                                                            </div>
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{$promosub->mobile}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-12 form-group">
                                                                Interest Level:
                                                                <input type="range" name="interest" min="0" max="5" value="{{$promosub->interest}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label class="text-primary">
                                                                <input name="contacted" type="checkbox" @if($promosub->contacted > 0) checked @endif>
                                                                Mark as Contacted
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label class="text-info">
                                                                <input name="followup" type="checkbox" @if($promosub->followup > 0) checked @endif>
                                                                Mark as Need Follow-Up
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label class="text-muted">
                                                                <input name="kiv" type="checkbox" @if($promosub->kiv > 0) checked @endif>
                                                                Mark as KIV
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label class="text-danger">
                                                                <input name="uninterested" type="checkbox" @if($promosub->uninterested > 0) checked @endif>
                                                                Mark as Uninterested
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label class="text-success">
                                                                <input name="closed" type="checkbox" @if($promosub->closed > 0) checked @endif>
                                                                <strong>Mark as Closed</strong>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="row">
                                                <hr>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                        <textarea name="note" class="form-control" rows="6" id="textareaDefault">{{$promosub->note}}</textarea>
                                                    <br>
                                                </div>


                                        </div>
                                        <footer class="panel-footer">
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <button class="btn btn-default modal-dismiss">Cancel</button>&nbsp;
                                                    <button type="submit" class="btn btn-default btn-primary">Update & Close</button>
                                                </div>
                                            </div>
                                        </footer>
                                        </form>
                                    </section>
                                </div>

                                @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade in" id="contacted">

                            <table class="table table-hover table-bordered table-striped mb-none" id="contactedTables">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Name</th>
                                    <th class="hidden-xs">Email</th>
                                    <th>Mobile</th>
                                    <th class="hidden-xs">Interest</th>
                                    <th class="hidden-xs">Last Update</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($contactedsubs as $promosub)

                                    <tr class="gradeX modal-basic" style="cursor:pointer;" href="#list{{$promosub->id}}">
                                        <td align="center">
                                            @if($promosub->followup > 0)
                                                <span class="fa fa-refresh text-info" data-placement="bottom" data-toggle="tooltip" data-original-title="Need Follow-Up"></span>
                                            @endif
                                            &nbsp;
                                            @if($promosub->note != '')
                                                <span class="fa fa-file-text text-primary" data-placement="bottom" data-toggle="tooltip" data-original-title="{{$promosub->note}}"></span>
                                            @endif
                                        </td>
                                        <td>{{$promosub->firstname}} {{$promosub->lastname}}</td>
                                        <td class="hidden-xs">{{$promosub->email}}</td>
                                        <td>{{$promosub->mobile}}</td>
                                        <td class="hidden-xs">
                                            @for($x = 1; $x <= $promosub->interest; $x++)
                                                <span class="fa fa-star text-primary"></span>
                                            @endfor
                                        </td>
                                        <td class="hidden-xs"><span class="text-muted">{{ App\Classes\TimeAgoClass::xTimeAgo($promosub->updated_at) }}</span></td>
                                    </tr>


                                    <div id="list{{$promosub->id}}" class="modal-block mfp-hide">
                                        <section class="panel">
                                            <form id="subscribeform" method="post" action="{{URL::route('update-prospect')}}">
                                                <header class="panel-heading">
                                                    <h2 class="panel-title">Prospect's Information</h2>
                                                </header>
                                                <div class="panel-body">

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="pid" value="{{$promosub->id}}">

                                                    <div class="col-md-7">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" value="{{$promosub->firstname}}" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" value="{{$promosub->lastname}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="email" class="form-control" placeholder="Email" value="{{$promosub->email}}" required>
                                                                </div>
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{$promosub->mobile}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    Interest Level:
                                                                    <input type="range" name="interest" min="0" max="5" value="{{$promosub->interest}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-primary">
                                                                    <input name="contacted" type="checkbox" @if($promosub->contacted > 0) checked @endif>
                                                                    Mark as Contacted
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-info">
                                                                    <input name="followup" type="checkbox" @if($promosub->followup > 0) checked @endif>
                                                                    Mark as Need Follow-Up
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-muted">
                                                                    <input name="kiv" type="checkbox" @if($promosub->kiv > 0) checked @endif>
                                                                    Mark as KIV
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-danger">
                                                                    <input name="uninterested" type="checkbox" @if($promosub->uninterested > 0) checked @endif>
                                                                    Mark as Uninterested
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-success">
                                                                    <input name="closed" type="checkbox" @if($promosub->closed > 0) checked @endif>
                                                                    <strong>Mark as Closed</strong>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <textarea name="note" class="form-control" rows="6" id="textareaDefault">{{$promosub->note}}</textarea>
                                                        <br>
                                                    </div>


                                                </div>
                                                <footer class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-default modal-dismiss">Cancel</button>&nbsp;
                                                            <button type="submit" class="btn btn-default btn-primary">Update & Close</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </form>
                                        </section>
                                    </div>

                                @endforeach

                                </tbody>
                            </table>

                        </div>


                        <div class="tab-pane fade in" id="kiv">

                            <table class="table table-hover table-bordered table-striped mb-none" id="kivTables">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Name</th>
                                    <th class="hidden-xs">Email</th>
                                    <th>Mobile</th>
                                    <th class="hidden-xs">Interest</th>
                                    <th class="hidden-xs">Last Update</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($kivsubs as $promosub)

                                    <tr class="gradeX modal-basic" style="cursor:pointer;" href="#list{{$promosub->id}}">
                                        <td align="center">
                                            @if($promosub->note != '')
                                                <span class="fa fa-file-text text-primary" data-placement="bottom" data-toggle="tooltip" data-original-title="{{$promosub->note}}"></span>
                                            @endif
                                        </td>
                                        <td>{{$promosub->firstname}} {{$promosub->lastname}}</td>
                                        <td class="hidden-xs">{{$promosub->email}}</td>
                                        <td>{{$promosub->mobile}}</td>
                                        <td class="hidden-xs">
                                            @for($x = 1; $x <= $promosub->interest; $x++)
                                                <span class="fa fa-star text-primary"></span>
                                            @endfor
                                        </td>
                                        <td class="hidden-xs"><span class="text-muted">{{ App\Classes\TimeAgoClass::xTimeAgo($promosub->updated_at) }}</span></td>
                                    </tr>


                                    <div id="list{{$promosub->id}}" class="modal-block mfp-hide">
                                        <section class="panel">
                                            <form id="subscribeform" method="post" action="{{URL::route('update-prospect')}}">
                                                <header class="panel-heading">
                                                    <h2 class="panel-title">Prospect's Information</h2>
                                                </header>
                                                <div class="panel-body">

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="pid" value="{{$promosub->id}}">

                                                    <div class="col-md-7">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" value="{{$promosub->firstname}}" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" value="{{$promosub->lastname}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="email" class="form-control" placeholder="Email" value="{{$promosub->email}}" required>
                                                                </div>
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{$promosub->mobile}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    Interest Level:
                                                                    <input type="range" name="interest" min="0" max="5" value="{{$promosub->interest}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-primary">
                                                                    <input name="contacted" type="checkbox" @if($promosub->contacted > 0) checked @endif>
                                                                    Mark as Contacted
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-info">
                                                                    <input name="followup" type="checkbox" @if($promosub->followup > 0) checked @endif>
                                                                    Mark as Need Follow-Up
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-muted">
                                                                    <input name="kiv" type="checkbox" @if($promosub->kiv > 0) checked @endif>
                                                                    Mark as KIV
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-danger">
                                                                    <input name="uninterested" type="checkbox" @if($promosub->uninterested > 0) checked @endif>
                                                                    Mark as Uninterested
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-success">
                                                                    <input name="closed" type="checkbox" @if($promosub->closed > 0) checked @endif>
                                                                    <strong>Mark as Closed</strong>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <textarea name="note" class="form-control" rows="6" id="textareaDefault">{{$promosub->note}}</textarea>
                                                        <br>
                                                    </div>


                                                </div>
                                                <footer class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-default modal-dismiss">Cancel</button>&nbsp;
                                                            <button type="submit" class="btn btn-default btn-primary">Update & Close</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </form>
                                        </section>
                                    </div>

                                @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade in" id="uninterested">

                            <table class="table table-hover table-bordered table-striped mb-none" id="uninterestedTables">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="hidden-xs">Email</th>
                                    <th>Mobile</th>
                                    <th class="hidden-xs">Last Update</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($uninterestedsubs as $promosub)

                                    <tr class="gradeX modal-basic text-danger" style="cursor:pointer;" href="#list{{$promosub->id}}">
                                        <td>{{$promosub->firstname}} {{$promosub->lastname}}</td>
                                        <td class="hidden-xs">{{$promosub->email}}</td>
                                        <td>{{$promosub->mobile}}</td>
                                        <td class="hidden-xs">{{ App\Classes\TimeAgoClass::xTimeAgo($promosub->updated_at) }}</td>
                                    </tr>


                                    <div id="list{{$promosub->id}}" class="modal-block mfp-hide">
                                        <section class="panel">
                                            <form id="subscribeform" method="post" action="{{URL::route('update-prospect')}}">
                                                <header class="panel-heading">
                                                    <h2 class="panel-title">Prospect's Information</h2>
                                                </header>
                                                <div class="panel-body">

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="pid" value="{{$promosub->id}}">

                                                    <div class="col-md-7">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" value="{{$promosub->firstname}}" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" value="{{$promosub->lastname}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="email" class="form-control" placeholder="Email" value="{{$promosub->email}}" required>
                                                                </div>
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{$promosub->mobile}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    Interest Level:
                                                                    <input type="range" name="interest" min="0" max="5" value="{{$promosub->interest}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-primary">
                                                                    <input name="contacted" type="checkbox" @if($promosub->contacted > 0) checked @endif>
                                                                    Mark as Contacted
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-info">
                                                                    <input name="followup" type="checkbox" @if($promosub->followup > 0) checked @endif>
                                                                    Mark as Need Follow-Up
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-muted">
                                                                    <input name="kiv" type="checkbox" @if($promosub->kiv > 0) checked @endif>
                                                                    Mark as KIV
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-danger">
                                                                    <input name="uninterested" type="checkbox" @if($promosub->uninterested > 0) checked @endif>
                                                                    Mark as Uninterested
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-success">
                                                                    <input name="closed" type="checkbox" @if($promosub->closed > 0) checked @endif>
                                                                    <strong>Mark as Closed</strong>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <textarea name="note" class="form-control" rows="6" id="textareaDefault">{{$promosub->note}}</textarea>
                                                        <br>
                                                    </div>


                                                </div>
                                                <footer class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-default modal-dismiss">Cancel</button>&nbsp;
                                                            <button type="submit" class="btn btn-default btn-primary">Update & Close</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </form>
                                        </section>
                                    </div>

                                @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane fade in" id="closed">

                            <table class="table table-hover table-bordered table-striped mb-none" id="closedTables">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="hidden-xs">Email</th>
                                    <th>Mobile</th>
                                    <th class="hidden-xs">Last Update</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($closedsubs as $promosub)

                                    <tr class="gradeX modal-basic text-success" style="cursor:pointer;" href="#list{{$promosub->id}}">
                                        <td>{{$promosub->firstname}} {{$promosub->lastname}}</td>
                                        <td class="hidden-xs">{{$promosub->email}}</td>
                                        <td>{{$promosub->mobile}}</td>
                                        <td class="hidden-xs">{{ App\Classes\TimeAgoClass::xTimeAgo($promosub->updated_at) }}</td>
                                    </tr>


                                    <div id="list{{$promosub->id}}" class="modal-block mfp-hide">
                                        <section class="panel">
                                            <form id="subscribeform" method="post" action="{{URL::route('update-prospect')}}">
                                                <header class="panel-heading">
                                                    <h2 class="panel-title">Prospect's Information</h2>
                                                </header>
                                                <div class="panel-body">

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="pid" value="{{$promosub->id}}">

                                                    <div class="col-md-7">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" value="{{$promosub->firstname}}" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" value="{{$promosub->lastname}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="email" class="form-control" placeholder="Email" value="{{$promosub->email}}" required>
                                                                </div>
                                                                <div class="col-md-12 form-group">
                                                                    <input type="text" name="mobile" class="form-control" placeholder="Mobile" value="{{$promosub->mobile}}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-12 form-group">
                                                                    Interest Level:
                                                                    <input type="range" name="interest" min="0" max="5" value="{{$promosub->interest}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-primary">
                                                                    <input name="contacted" type="checkbox" @if($promosub->contacted > 0) checked @endif>
                                                                    Mark as Contacted
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-info">
                                                                    <input name="followup" type="checkbox" @if($promosub->followup > 0) checked @endif>
                                                                    Mark as Need Follow-Up
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-muted">
                                                                    <input name="kiv" type="checkbox" @if($promosub->kiv > 0) checked @endif>
                                                                    Mark as KIV
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-danger">
                                                                    <input name="uninterested" type="checkbox" @if($promosub->uninterested > 0) checked @endif>
                                                                    Mark as Uninterested
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label class="text-success">
                                                                    <input name="closed" type="checkbox" @if($promosub->closed > 0) checked @endif>
                                                                    <strong>Mark as Closed</strong>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <textarea name="note" class="form-control" rows="6" id="textareaDefault">{{$promosub->note}}</textarea>
                                                        <br>
                                                    </div>


                                                </div>
                                                <footer class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-default modal-dismiss">Cancel</button>&nbsp;
                                                            <button type="submit" class="btn btn-default btn-primary">Update & Close</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </form>
                                        </section>
                                    </div>

                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $('.modal-basic').magnificPopup({
        type: 'inline',
        preloader: false,
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    var datatableInit = function() {
        $('#newTables').dataTable();
        $('#contactedTables').dataTable();
        $('#kivTables').dataTable();
        $('#uninterestedTables').dataTable();
        $('#closedTables').dataTable();
    };

    $(function() {
        datatableInit();
    });
</script>
@Stop