<?php $onlineuser = 0; ?>
@if(!empty($online_user))
    @if(count($online_user))
        @foreach($online_user as $oluser)
            <li class="online">
                <span class="profile-thumb">
                    <img src="../profiles/{{$oluser['profile_pic']}}" alt="" width="32" height="32">
                </span>
                <a href="#" class="chat-user" user-id="{{$oluser['id']}}" user-name="{{$oluser['alias']}}" user-class="{{$oluser['user_class_name']}}" user-pic="../profiles/{{$oluser['profile_pic']}}">
                    <span class="name">{{$oluser['alias']}}</span><br/>
                    <span class="rank">{{$oluser['user_class_name']}}</span>
                    <span class="status">
                        <i class="fa fa-circle fs-12"></i>
                    </span>
                </a>
            </li>
            <?php $onlineuser ++; ?>
        @endforeach
    @endif
@endif
<script>
    $('.onlinecount').html('{{$onlineuser}}');
</script>