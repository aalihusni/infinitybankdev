@extends('member.default')

@section('title'){{trans('member.menu_lang_trans_request')}} @Stop

@section('lang-class')nav-active @Stop

@section('content')

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">{!!trans('general.text_lang_trans')!!}</h2>
                        <p class="panel-subtitle hide">{{trans('pairing.info_about_pairing')}}</p>
                    </div>
                    
                </div>

                <div class="panel panel-default">
                    
                    <div class="panel-body">
                        
                        <table id="datatable-default" class="table table-bordered table-striped mb-none dataTable no-footer">
                            <thead>
                            <tr>
                            	<td>File Name</td>
                            	<td>Language</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach($fileList as $flist)
                              <tr>
                              <td>File - {{$flist->snnumber}}</td>
                              <td><a href="{{URL::route('member-lang-trans-filedata',[Crypt::encrypt(''.$flist->filename.''),$flist->id])}}">
                              Translate English To {{$flist->languagetitle}}</a></td>
                              <td><span class="badge badge-{{$flist->cssname}}">{{ $flist->translationStatus }}</span></td>
                               <td>
                              <a href="{{URL::route('member-lang-trans-filedata',[Crypt::encrypt(''.$flist->filename.''),$flist->id])}}">
								<span style="font-size: 11px;margin: 0 4px 0 0;">
								</span><img src="{{ asset('img/flags/gb.png') }}" />
								To
								<span style="font-size: 11px;margin: 0 4px 0 0;">
								</span><img src="{{ asset('img/flags/'.$flist->image.'') }}" />
								</a>&nbsp;&nbsp;
                                   </td>
                               </tr>
                               @endforeach    
                            </tbody>
                        </table>
                        
                        
                    </div>
                </div>
            </div>

            
        </div>
    </div>
<script type="text/javascript">

</script>
@Stop