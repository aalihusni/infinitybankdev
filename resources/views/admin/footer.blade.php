</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
            effect: 'fade',
            testMode: true,
            onChange: function(evt){
                $(location).attr('href','{{URL::route('set-locale')}}'+'?lang='+evt.selectedItem)
            }
        });
    });
</script>

</body>

</html>