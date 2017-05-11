@extends('website.default')

@section('title'){{trans('websitenew.bit_wallet')}} @Stop

@section('bitcoinwalletclass')active @Stop

@section('content')
<div role="main" class="main">


    <div class="container">

        <div class="row">

            <div class="row">
                <ul class="nav nav-pills sort-source pull-right push-bottom" data-sort-id="portfolio" data-option-key="filter">
                    <li data-option-value=".mobile" class="active"><a href="#">{{trans('websitenew.mobile')}}</a></li>
                    <li data-option-value=".desktop"><a href="#">{{trans('websitenew.desktop')}}</a></li>
                    <li data-option-value=".web"><a href="#">{{trans('websitenew.web')}}</a></li>
                    <li data-option-value=".hardware"><a href="#">{{trans('websitenew.hardware')}}</a></li>
                    <li data-option-value=".bank"><a href="#">{{trans('websitenew.bank')}}</a></li>
                    <li data-option-value="*"><a href="#">{{trans('websitenew.showall')}}</a></li>
                </ul>
            </div>

            <div class="row">

                <ul class="portfolio-list sort-destination" data-sort-id="portfolio">

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile web">
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

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://airbitz.co/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/AIRBITZ.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">AIRBITZ</span>
                                    <span class="thumb-info-type">https://airbitz.co/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile desktop">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://bither.net/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BITHER.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BITHER</span>
                                    <span class="thumb-info-type">https://bither.net/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile desktop web">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.blockchain.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BLOCKCHAIN.INFO.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BLOCKCHAIN.INFO</span>
                                    <span class="thumb-info-type">https://www.blockchain.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile web">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.blocktrail.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BLOCKTRAIL.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BLOCKTRAIL</span>
                                    <span class="thumb-info-type">https://www.blocktrail.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile">
                        <div class="portfolio-item img-thumbnail">
                            <a href="http://breadwallet.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BREADWALLET.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BREADWALLET</span>
                                    <span class="thumb-info-type">http://breadwallet.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://coinomi.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/COINOMI.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">COINOMI</span>
                                    <span class="thumb-info-type">https://coinomi.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile desktop">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://copay.io/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/COPAY.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">COPAY</span>
                                    <span class="thumb-info-type">https://copay.io/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile web">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://greenaddress.it/en/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/GREEN-ADDRESS.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">GREEN ADDRESS</span>
                                    <span class="thumb-info-type">https://greenaddress.it/en/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://luxstack.com/#!/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/LUXSTACK.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">LUXSTACK</span>
                                    <span class="thumb-info-type">https://luxstack.com/#!/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://mycelium.com/index.html" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/MYCELIUM.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">MYCELIUM</span>
                                    <span class="thumb-info-type">https://mycelium.com/index.html</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item mobile">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://github.com/schildbach" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/SCHILDBACH.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">SCHILDBACH</span>
                                    <span class="thumb-info-type">https://github.com/schildbach</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item logos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://bitcoinarmory.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/ARMORY.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">ARMORY</span>
                                    <span class="thumb-info-type">https://bitcoinarmory.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item web">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.bitgo.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BITGO.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BITGO</span>
                                    <span class="thumb-info-type">https://www.bitgo.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item desktop">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://electrum.org/#home" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/ELECTRUM.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">ELECTRUM</span>
                                    <span class="thumb-info-type">https://electrum.org/#home</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item desktop">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://ciphrex.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/MSIGNA.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">MSIGNA</span>
                                    <span class="thumb-info-type">https://ciphrex.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item desktop">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://multibit.org/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/MULTIBIT-HD.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">MULTIBIT HD</span>
                                    <span class="thumb-info-type">https://multibit.org/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item web">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://coinkite.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/COINKITE.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">COINKITE</span>
                                    <span class="thumb-info-type">https://coinkite.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item hardware">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://choosecase.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/CASE.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">CASE</span>
                                    <span class="thumb-info-type">https://choosecase.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item hardware">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.keepkey.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/KEEPKEY.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">KEEPKEY</span>
                                    <span class="thumb-info-type">https://www.keepkey.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item hardware">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.ledgerwallet.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/LEDGER.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">LEDGERNANO</span>
                                    <span class="thumb-info-type">https://www.ledgerwallet.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item hardware">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.buytrezor.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/TREZOR.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">TREZOR</span>
                                    <span class="thumb-info-type">https://www.buytrezor.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item bank">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://bitcoinxt.software/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BITCOIN-XT.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BITCOIN XT</span>
                                    <span class="thumb-info-type">https://bitcoinxt.software/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item bank">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://coinapult.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/COINAPULT.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">COINAPULT </span>
                                    <span class="thumb-info-type">https://coinapult.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item bank">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://www.coinbase.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/COINBASE.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">COINBASE </span>
                                    <span class="thumb-info-type">https://www.coinbase.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item bank">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://xapo.com/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/XAPO.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">XAPO SELLS BITCOIN, PROV </span>
                                    <span class="thumb-info-type">https://xapo.com/</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item logos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://github.com/bitpay" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BITCOIN-CORE-+-BIP101.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BITCOIN CORE + BIP101</span>
                                    <span class="thumb-info-type">https://github.com/bitpay</span>
                                </span>
                                <span class="thumb-info-action">
                                    <span class="thumb-info-action-left"><em>{{trans('websitenew.goto')}}</em></span>
                                    <span class="thumb-info-action-right"><em>{{trans('websitenew.website')}}</em></span>
                                </span>
                            </a>
                        </div>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12 isotope-item logos">
                        <div class="portfolio-item img-thumbnail">
                            <a href="https://bitcoin.org/en/bitcoin-core/" target="_blank" class="thumb-info">
                                <span class="thumb-info-image">
                                    <img alt="" class="img-responsive" src="img/btc/BITCOIN-CORE.jpg">
                                </span>
                                <span class="thumb-info-title">
                                    <span class="thumb-info-inner">BITCOIN CORE</span>
                                    <span class="thumb-info-type">https://bitcoin.org/en/bitcoin-core/</span>
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