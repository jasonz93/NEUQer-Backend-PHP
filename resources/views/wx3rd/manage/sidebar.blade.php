<div class="ui visible sidebar inverted vertical menu">
    <a class="item" href="{{ route('wx3rd.mp.manage', ['mp' => $mp->app_id]) }}">公众号信息</a>
    <a class="item" href="{{ route('wx3rd.mp.manage.reply', ['mp' => $mp->app_id]) }}">自动回复设置</a>
</div>