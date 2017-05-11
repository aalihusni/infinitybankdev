/**
 * Created by khairulazlan on 11/12/15.
 */
var conn;
var userId = $('meta[name="hexid"]').attr('content');
var token = $('meta[name="hexto"]').attr('content');
var port = "9010";
var uri = "chat.bitregion.com";
var brdelimitter = "$@$";

$(document).ready(function () {
    $('#onlinemember')
        .html('loading...')
        .load("../members/user_online", {_token: token}, function(responseText){
            pop_chat_box();
        });
});

$('.groupclass').click(function(){
    $('span.showlist',this).toggleClass("fa-minus-square-o fa-plus-square-o");
})

$(".maximize").click(function(e) {
    e.preventDefault();
    $("#wrapper, .online-status").toggleClass("toggled");
});

$(".minimize").click(function(e) {
    e.preventDefault();
    $("#wrapper, .online-status").toggleClass("toggled");
    $("#chat-wrapper").removeClass("toggled");
    clearChatUser();
});

$("a.close").click(function(e) {
    e.preventDefault();
    $("#chat-wrapper").removeClass("toggled");
    clearChatUser();
});

function scrollbottom()
{
    var wtf = $('.fixedContent');
    var height = wtf[0].scrollHeight;
    wtf.scrollTop(height);
}

function clearChatUser()
{
    $('.userinput','#chat-content').attr('user-id','');
}

function pop_chat_box()
{
    $(".online a.chat-user").click(function(e) {
        var open_user_box = $(this).attr('user-id');
        var user_name = $(this).attr('user-name');
        var user_class = $(this).attr('user-class');
        var user_pic = $(this).attr('user-pic');

        $('.name','#chat-wrapper').html(user_name);
        $('.rank','#chat-wrapper').html(user_class);
        $('.chaimg','#chat-wrapper').attr('src', user_pic);
        $('.userinput','#chat-content').attr('user-id', open_user_box);

        $('.typing','#chat-content').hide();

        $('.fixedContent')
            .html('loading...')
            .load("../members/user_chat_history", {_token: token, user_id: open_user_box, cur_page: '0', date:'0'}, function(responseText){
                scrollbottom();
            });

        e.preventDefault();

        $("#chat-wrapper").addClass("toggled");


    });
}

function RefreshChatUser(id, status)
{
    $.ajax({
        method: "POST",
        url: "../members/check_friend",
        data: { _token: token, user_id: id },
        success: function(data) {
            if(data == 'yes')
            {
                $('#onlinemember')
                    .html('loading...')
                    .load("../members/user_online", {_token: token}, function(responseText){
                        pop_chat_box();
                        PopupNotification(id, "Is now "+status);
                    });
            }
        }
    });
}

function addMessageToChatBox(type, fromid, toid, message) {

    var active_id = $('.userinput','#chat-content').attr('user-id');

    if(fromid == active_id && toid == userId && type == 'typing')
    {

        $('.typing','#chat-content').show().delay(5000).fadeOut();
    }

    if(fromid == active_id && toid == userId && type == 'message')
    {
        $('.typing','#chat-content').hide();
        $('.fixedContent').append("<div class='userwrap'><span class='messages to-me'>"+message+"<br><span class='messagetime'>"+DisplayCurrentTime()+"</span></span></div>");
        scrollbottom();

    }

    if(type == 'message' && toid == userId && fromid != active_id)
    {

        PopupNotification(fromid, message);
    }

}

function PopupNotification(fromid, message)
{
    var stack_bottomright = {"dir1": "up", "dir2": "left", "firstpos1": 45, "firstpos2": 35};

    $.ajax({
        method: "POST",
        url: "../members/user_info",
        data: { _token: token, user_id: fromid },
        success: function(data) {


            var obj = $.parseJSON(data);

            username = obj.username;
            picture = obj.picture;



            new PNotify({
                title: username,
                text: message,
                addclass: 'notification-dark stack-bottomright notifybox',
                icon: 'img_icon'+username,
                stack: stack_bottomright
            });


            $('.img_icon'+username).css('background-image','url("../profiles/'+picture+'")')
                .css('background-size','cover');

            $('.notifybox').click(function(){

                $("#wrapper, .online-status").toggleClass("toggled");
                $("#chat-wrapper").removeClass("toggled");
            })
        }
    });
}

function DisplayCurrentTime() {
    var date = new Date();
    var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
    if(hours < 12) { var M = 'AM' } else { var M = 'PM' }
    time = hours + ":" + minutes + ":" + seconds + ' ' + M;

    return time;
};

$(window).load(function(){
    var toggle = false;
    var user="";
    var searchBoxText= "Type here...";
    var fixIntv;
    var fixedBoxsize = $('#fixed').outerHeight()+'px';
    var Parent = $("#fixed"); // cache parent div
    var Header = $(".fixedHeader"); // cache header div
    var Chatbox = $(".userinput"); // cache header div
    Parent.css('height', '40px');

    Header.click(function(){
        toggle = (!toggle) ? true : false;
        if(toggle)
        {
            Parent.animate({'height' : fixedBoxsize}, 300);
        }
        else
        {
            Parent.animate({'height' : '40px'}, 300);
        }

    });

    Chatbox.focus(function(){
        $(this).val(($(this).val()===searchBoxText)? '' : $(this).val());
    }).blur(function(){
        $(this).val(($(this).val()==='')? searchBoxText : $(this).val());
    }).keyup(function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        var user_id = $(this).attr('user-id')
        if(code===13){

            if($(this).val() != '') {
                $('.fixedContent').append("<div class='userwrap'><span class='messages from-me'>" + $(this).val() + "<br><span class='messagetime'>" + DisplayCurrentTime() + "</span></span></div>");
                conn.send('message' + brdelimitter + userId + brdelimitter + user_id + brdelimitter + $(this).val());
                event.preventDefault();
                scrollbottom();
                $(this).val('');
            }
        }
        else
        {
            conn.send('typing'+ brdelimitter + userId + brdelimitter + user_id + brdelimitter + "is typing a message.");
        }

    });
});

// ================== do not change below unless needed ============================ //
$(document).ready(function () {
    conn = new WebSocket('ws://' + uri + ':' + port);

    conn.onerror = function (event) {}

    conn.onclose = function (event) {
        var reason;

        if (event.code == 1000)
            reason = "Normal closure, meaning that the purpose for which the connection was established has been fulfilled.";
        else if (event.code == 1001)
            reason = "An endpoint is \"going away\", such as a server going down or a browser having navigated away from a page.";
        else if (event.code == 1002)
            reason = "An endpoint is terminating the connection due to a protocol error";
        else if (event.code == 1003)
            reason = "An endpoint is terminating the connection because it has received a type of data it cannot accept (e.g., an endpoint that understands only text data MAY send this if it receives a binary message).";
        else if (event.code == 1004)
            reason = "Reserved. The specific meaning might be defined in the future.";
        else if (event.code == 1005)
            reason = "No status code was actually present.";
        else if (event.code == 1006)
            reason = "Abnormal error, e.g., without sending or receiving a Close control frame";
        else if (event.code == 1007)
            reason = "An endpoint is terminating the connection because it has received data within a message that was not consistent with the type of the message (e.g., non-UTF-8 [http://tools.ietf.org/html/rfc3629] data within a text message).";
        else if (event.code == 1008)
            reason = "An endpoint is terminating the connection because it has received a message that \"violates its policy\". This reason is given either if there is no other sutible reason, or if there is a need to hide specific details about the policy.";
        else if (event.code == 1009)
            reason = "An endpoint is terminating the connection because it has received a message that is too big for it to process.";
        else if (event.code == 1010) // Note that this status code is not used by the server, because it can fail the WebSocket handshake instead.
            reason = "An endpoint (client) is terminating the connection because it has expected the server to negotiate one or more extension, but the server didn't return them in the response message of the WebSocket handshake. <br /> Specifically, the extensions that are needed are: " + event.reason;
        else if (event.code == 1011)
            reason = "A server is terminating the connection because it encountered an unexpected condition that prevented it from fulfilling the request.";
        else if (event.code == 1015)
            reason = "The connection was closed due to a failure to perform a TLS handshake (e.g., the server certificate can't be verified).";
        else
            reason = "Unknown reason";
    };

    conn.onopen = function (e) {

        $.ajax({
            method: "POST",
            url: "../members/user_info",
            data: { _token: token, user_id: userId },
            success: function(data) {

                var obj = $.parseJSON(data);

                hierarchy = obj.hierarchy;
                global_level = obj.global_level;
                hierarchy_bank = obj.hierarchy_bank;
                global_level_bank = obj.global_level_bank;
                upline_user_id = obj.upline_user_id;
                referral_user_id = obj.referral_user_id;

                conn.send('online'+brdelimitter+userId+brdelimitter+ hierarchy +brdelimitter+ global_level +brdelimitter+ hierarchy_bank +brdelimitter+ global_level_bank +brdelimitter+ upline_user_id +brdelimitter+ referral_user_id);

            }
        });
    };

    conn.onmessage = function (e) {
        if (e.data.indexOf("user_connected") > -1) {
            var r_conn_chatid = e.data.split(brdelimitter)[0];
            var r_userid = e.data.split(brdelimitter)[2];
            updateChatid(r_conn_chatid);

        } else if (e.data.indexOf("user_disconnected") > -1) {
            var r_disconn_chatid = e.data.split(brdelimitter)[0];
            var r_userid = e.data.split(brdelimitter)[2];

            removeUsersOffline(r_disconn_chatid);
        } else {
            var type = e.data.split(brdelimitter)[0];
            var fromid = e.data.split(brdelimitter)[1];
            var toid = e.data.split(brdelimitter)[2];
            var themsg = e.data.split(brdelimitter)[3];

            if(type == 'typing' || type == 'message')
            {
                addMessageToChatBox(type, fromid, toid, themsg);
            }

            if(type == 'online')
            {
                RefreshChatUser(fromid,"online");
            }

            if(type == 'offline')
            {
                RefreshChatUser(fromid,"offline");
            }

        }
    };

});
// ================== EOF do not change below unless needed ============================ //