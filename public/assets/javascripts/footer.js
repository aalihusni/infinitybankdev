$(document).ready(function() {
    $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
        effect: 'fade',
        testMode: true,
        onChange: function(evt){
            $(location).attr('href','{{URL::route('set-locale')}}'+'?lang='+evt.selectedItem)
        }
    });
});

$(function() {
    var page = $('.page').attr('id');
    $("ul.menu-items li."+page).addClass("active");
    $(".icon-thumbnail."+page).addClass("bg-complete");
});