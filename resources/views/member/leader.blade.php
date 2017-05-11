@extends('member.default')

@section('title')Leader @Stop

@section('passport-class')nav-active @Stop
@section('menu_setting') @Stop

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

                <!-- Page Content -->
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Passport Leader</h2>
                            <p class="panel-subtitle">&nbsp;</p>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12 form-horizontal form-bordered">

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><strong>Total Passport</strong></label>
                                    <div class="col-md-5">
                                        <label class="control-label -align-left" id="total_price">{{ $total_passport }}</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-subtitle">{{trans('passport.passport_transaction_history')}}</p>
                        </div>
                        <div class="panel-body">
                            {!! $passports->render() !!}
                            <table id="datatable-default" class="table table-bordered table-striped mb-none dataTable no-footer">
                                <thead>
                                <tr>
                                    <td>Date</td>
                                    <td>Username</td>
                                    <td>Desc</td>
                                    <td>Credit</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($passports)
                                    @foreach($passports as $passport_transaction)
                                        <tr>
                                            <td>{{ $passport_transaction->created_at }}</td>
                                            <td>{{ $passport_transaction->alias }}</td>
                                            <td>{{ $passport_transaction->description }}</td>
                                            <td>{{ $passport_transaction->debit }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                                </tr>
                            </table>
                            {!! $passports->render() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- /#page-wrapper -->
        @Stop