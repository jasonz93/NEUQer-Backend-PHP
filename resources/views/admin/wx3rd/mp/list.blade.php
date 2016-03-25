@extends('admin.base')
@section('title')
    公众号列表
@endsection

@section('stylesheets')
    <style>
        .avatar {
            width: 40px;
            height: 40px;
        }
    </style>
@endsection

@section('body')
    <h1 class="ui dividing header">公众号列表</h1>
<table class="ui celled table">
    <thead>
    <tr>
        <th class="one wide center aligned">头像</th>
        <th>名称</th>
        <th>类型</th>
        <th>验证</th>
    </tr>
    </thead>
    <tbody>
    @foreach($page->items() as $mp)
        <tr @if($mp->verify_type !== 0)class="warning"@endif>
            <td class="center aligned"><img class="avatar" src="{{ $mp->avatar }}"/> </td>
            <td><a href="{{ route('admin.wx3rd.mp.info', ['mp' => $mp->app_id]) }}">{{ $mp->nickname }}</a></td>
            <td>
                @if($mp->service_type < 2)
                    订阅号
                @else
                    服务号
                @endif
            </td>
            <td>
                @if($mp->verify_type === 0)
                    已验证
                @else
                    <i class="attention icon"></i>
                    未验证
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $page->links() !!}
@endsection