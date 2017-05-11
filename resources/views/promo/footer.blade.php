

<footer id="footer">
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