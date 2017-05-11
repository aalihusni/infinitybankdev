@extends('website.default')

@section('title'){{trans('websitenew.buysellbit')}} @Stop

@section('buysellbitcoinclass')active @Stop

@section('content')
<div role="main" class="main">


    <div class="container">

        <div class="row">

            <div class="row">
                <ul class="nav nav-pills sort-source pull-right push-bottom" data-sort-id="portfolio" data-option-key="filter">
                    <li data-option-value=".philipine" class="active"><a href="#">{{trans('websitenew.philippines')}}</a></li>
                    <li data-option-value=".ukraine"><a href="#">{{trans('websitenew.ukraine')}}</a></li>
                    <li data-option-value=".indonesia"><a href="#">{{trans('websitenew.indonesia')}}</a></li>
                    <li data-option-value=".malaysia"><a href="#">{{trans('websitenew.malaysia')}}</a></li>
                    <li data-option-value=".china"><a href="#">{{trans('websitenew.china')}}</a></li>
                    <li data-option-value=".india"><a href="#">{{trans('websitenew.india')}}</a></li>
                    <li data-option-value=".russia"><a href="#">{{trans('websitenew.russia')}}</a></li>
                    <li data-option-value=".spain"><a href="#">{{trans('websitenew.spain')}}</a></li>
                    <li data-option-value=".thailand"><a href="#">{{trans('websitenew.thailand')}}</a></li>
                    <li data-option-value="*"><a href="#">{{trans('websitenew.showall')}}</a></li>
                </ul>
            </div>

            <div class="row">

                <ul class="portfolio-list sort-destination" data-sort-id="portfolio">

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://bitx.co/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/projects/project-4.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BITX</span>
                                    <span class="thumb-info-type">https://bitx.co/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.247exchange.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/247-Exchange.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">247 Exchange</span>
                                    <span class="thumb-info-type">https://www.247exchange.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.coinwallet.eu/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Coin-wallet.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Coin-wallet</span>
                                    <span class="thumb-info-type">https://www.coinwallet.eu/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://hitbtc.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/HitBTC.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">HitBTC</span>
                                    <span class="thumb-info-type">https://hitbtc.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://anxbtc.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Anxbtc.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Anxbtc</span>
                                    <span class="thumb-info-type">https://anxbtc.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://xapo.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Xapo.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Xapo</span>
                                    <span class="thumb-info-type">https://xapo.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.quoine.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Quoine.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Quoine</span>
                                    <span class="thumb-info-type">https://www.quoine.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://paxful.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/PAXFUL.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">PAXFUL</span>
                                    <span class="thumb-info-type">https://paxful.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://localbitcoins.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Local-Bitcoins.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Local Bitcoins</span>
                                    <span class="thumb-info-type">https://localbitcoins.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://cubits.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/CUBITS.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Cubits</span>
                                    <span class="thumb-info-type">https://cubits.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://btc-e.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Btc-e.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Btc-e</span>
                                    <span class="thumb-info-type">https://btc-e.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://indacoin.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/InDA-COIN.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Indacoin</span>
                                    <span class="thumb-info-type">https://indacoin.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://lakebtc.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/LAKEBTC.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">LakeBTC</span>
                                    <span class="thumb-info-type">https://lakebtc.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.bitfinex.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Bitfinex.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Bitfinex</span>
                                    <span class="thumb-info-type">https://www.bitfinex.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.bitstamp.net/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/BITSTAMP.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Bitstamp</span>
                                    <span class="thumb-info-type">https://www.bitstamp.net/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://cex.io/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/Cex.io.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Cex.io</span>
                                    <span class="thumb-info-type">https://cex.io/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://digatrade.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/DIGATRADE.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Digatrade</span>
                                    <span class="thumb-info-type">https://digatrade.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.multisigna.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/MULTISIGNA.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Multisigna</span>
                                    <span class="thumb-info-type">https://www.multisigna.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.itbit.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/ITBIT.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">itBit</span>
                                    <span class="thumb-info-type">https://www.itbit.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://bit-x.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/BIT-X.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BIT-X</span>
                                    <span class="thumb-info-type">https://bit-x.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://bitok.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/BITOK.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Bitok</span>
                                    <span class="thumb-info-type">https://bitok.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item philipine ukraine indonesia malaysia china india russia spain thailand">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.bitnovo.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="web_content/img/buysell/BITNOVO.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">Bitnovo</span>
                                    <span class="thumb-info-type">https://www.bitnovo.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>



                </ul>
            </div>

        </div>


    </div>

</div>





</div>
@stop