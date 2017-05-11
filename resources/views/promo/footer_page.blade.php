

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                    <img src="assets/images/roundlogo.png" width="250px" style="margin-left:-20px; margin-top:-35px;">
            </div>
            <div class="col-md-3">
                <h4>{{trans('websitenew.marketingplans')}}</h4>
                <ul class="nav nav-list primary push-bottom">
                    <li><a target="_blank" href="http://bitregion.com/download/marketin_plan.pdf">{{trans('websitenew.br_mp')}}</a></li>
                    <li><a target="_blank" href="http://bitregion.com/download/simple_marketing_plan.pdf">{{trans('websitenew.br_smp')}}</a></li>
                    <li><a target="_blank" href="http://bitregion.com/download/getting_started.pdf">{{trans('websitenew.br_gs')}}</a></li>
                    <li><a target="_blank" href="http://bitregion.com/download/account_manager_guide.pdf">{{trans('websitenew.br_amg')}}</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>{{trans('websitenew.login')}}Presentation Files</h4>
                <ul class="nav nav-list primary push-bottom">
                    <li><a target="_blank" href="http://bitregion.com/download/br_keynote.key">{{trans('websitenew.br_key')}}</a></li>
                    <li><a target="_blank" href="http://bitregion.com/download/br_powerpoint.pptx">{{trans('websitenew.br_pp')}}</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>{{trans('websitenew.video')}}</h4>

                <ul class="list-unstyled recent-work">
                    <li>
                        <a href="https://www.youtube.com/watch?v=ytyWckgDt9Q" class="thumb-info popup-youtube">
                            <img class="img-responsive" src="web_content/img/projects/project-1b.jpg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/watch?v=VQ4flvFefEU" class="thumb-info popup-youtube">
                            <img class="img-responsive" src="web_content/img/projects/testi04.jpg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/watch?v=UyG7VxWX2nw" class="thumb-info popup-youtube">
                            <img class="img-responsive" src="web_content/img/projects/project-1a.jpg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/watch?v=eAVVv_r1KfA" class="thumb-info popup-youtube">
                            <img class="img-responsive" src="web_content/img/projects/testi01.jpg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/watch?v=U1GiDU3C-uo" class="thumb-info popup-youtube">
                            <img class="img-responsive" src="web_content/img/projects/testi02.jpg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/watch?v=EZxwMUGCoCs" class="thumb-info popup-youtube">
                            <img class="img-responsive" src="web_content/img/projects/testi03.jpg" alt="">
                        </a>
                    </li>
                </ul>

                <a target="_blank" href="https://www.youtube.com/channel/UC4vEtJXwWPyr0ZXF8DC9tZg" class="btn-flat pull-right btn-xs view-more-recent-work">{{trans('websitenew.view_more')}} <i class="fa fa-arrow-right"></i></a>

            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>Copyright © 2014. All Rights Reserved.</p>
                </div>
                <div class="col-md-6" style="text-align:right;">

                    <!--<div id="google_translate_element"></div><script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'de,en,es,hi,ru,th,tl,uk,vi,zh-CN', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->

                </div>
            </div>
        </div>
    </div>
</footer>
</div>


<!-- Theme Base, Components and Settings -->
<script src="{{asset('web_content/js/theme.js')}}"></script>

<!-- Specific Page Vendor and Views -->
<script src="{{asset('web_content/js/views/view.home.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('web_content/js/custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('web_content/js/theme.init.js')}}"></script>

<script type="text/javascript">
    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        var magnificPopup = $.magnificPopup.instance;
        magnificPopup.close();
    });

    $(document).on('click', '.close', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $(document).ready(function() {
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,

            fixedContentPos: false
        });
    });

</script>


<!-- Flag click handler -->
</body>
</html>