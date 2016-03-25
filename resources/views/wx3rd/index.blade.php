<a href="{{ route('wx3rd.authorize') }}">Authorize</a>
<h3>我的公众号</h3>
@foreach($mps as $mp)
    <a href="{{ route('wx3rd.mp.manage', ['mp' => $mp->app_id]) }}">{{ $mp->nickname }}</a>
@endforeach