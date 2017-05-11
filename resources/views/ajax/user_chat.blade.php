<?php

$curpage = $chats[0]['message'];
$totalpage = $chats[0]['to_id'];
//echo $curpage." of ".count($chats)." pages= ".$chats[0]['to_id'];

array_splice($chats, 0, 1);
?>

@if($curpage < $totalpage)
<div class="loadmoreline_{{$curpage}}">
    <a href="#" class="loadmorebutton">Load Previous</a>
</div>
@endif

<?php
$now = date("l jS \of F Y", strtotime($chats[0]['created_at']));
?>
@foreach(array_reverse($chats) as $chat)
<?php

    if($chat['to_id'] == Auth::user()->id)
    {
        $style = "to-me";
    }
    else
    {
        $style = "from-me";
    }
    $date = date("l jS \of F Y", strtotime($chat['created_at']));
    $time = date("h:i:s A", strtotime($chat['created_at']));


?>

@if($date != $now || $now < '1')
<div class="chatdate"><strong>{{$date}}</strong></div>
@endif

<div class='userwrap'>
    <span class='messages {{$style}}'>{{$chat['message']}}<br>
    <span class="messagetime">{{$time}}</span>
    </span>
</div>

<?php
$now = $date;
$userid = $chats[0]['to_id'];
?>
@endforeach

<script>
$('.loadmorebutton').click(function(){
    $('.loadmoreline_{{$curpage}}')
            .html('loading...')
            .load("{{URL::route('user-chat-history')}}", {_token: '<?php echo csrf_token(); ?>', user_id: '{{$userid}}', cur_page: '{{$curpage}}', date:'{{urlencode($now)}}' });
});

</script>