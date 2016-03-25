@extends('admin.base')
@section('title')
    公众号信息
@endsection

@section('stylesheets')
    <style>
        .avatar {
            width: 150px;
            height: 150px;
        }
    </style>
@endsection

@section('body')
    <h1 class="ui dividing header">公众号信息</h1>
    <table class="ui definition celled table">
        <tbody>
        <tr>
            <td class="two wide">操作</td>
            <td>
                <a class="ui positive button" href="{{ route('admin.wx3rd.mp.refresh', ['mp' => $mp->app_id]) }}">刷新</a>
            </td>
        </tr>
        <tr>
            <td class="two wide">头像</td>
            <td><img class="avatar" src="{{ $mp->avatar }}"/> </td>
        </tr>
        <tr>
            <td>名称</td>
            <td>{{ $mp->nickname }}</td>
        </tr>
        <tr>
            <td>App ID</td>
            <td>{{ $mp->app_id }}</td>
        </tr>
        <tr>
            <td>类型</td>
            <td colspan="2">
                @if($mp->service_type < 2)
                    订阅号
                @else
                    服务号
                @endif
            </td>
        </tr>
        <tr>
            <td>验证状态</td>
            <td>{{ $mp->verify_type === 0 ? '已验证' : '未验证' }}</td>
        </tr>
        <tr>
            <td rowspan="15">权限集</td>
            <td style="padding: 0">
                <table style="width: 100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>授权</th>
                        <th>公众号</th>
                    </tr>
                    </thead>
                    <tr>
                        <td class="two wide">消息管理</td>
                        <td>{{ $mp->hasFunc(1) ? '是' : '否' }}</td>
                        <td>{{ $mp->canSetMenu() ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>用户管理</td>
                        <td>{{ $mp->hasFunc(2) ? '是' : '否' }}</td>
                        <td>{{ $mp->canManageUser() ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>账号服务</td>
                        <td>{{ $mp->hasFunc(3) ? '是' : '否' }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>网页服务</td>
                        <td>{{ $mp->hasFunc(4) ? '是' : '否' }}</td>
                        <td>{{ $mp->canPageAuth() ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>微信小店</td>
                        <td>{{ $mp->hasFunc(5) ? '是' : '否' }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>多客服</td>
                        <td>{{ $mp->hasFunc(6) ? '是' : '否' }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>群发与通知</td>
                        <td>{{ $mp->hasFunc(7) ? '是' : '否' }}</td>
                        <td>{{ $mp->canSendNotify() ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>卡券</td>
                        <td>{{ $mp->hasFunc(8) ? '是' : '否' }}</td>
                        <td>{{ $mp->open_card ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>扫一扫</td>
                        <td>{{ $mp->hasFunc(9) ? '是' : '否' }}</td>
                        <td>{{ $mp->open_scan ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>连Wifi</td>
                        <td>{{ $mp->hasFunc(10) ? '是' : '否' }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>素材管理</td>
                        <td>{{ $mp->hasFunc(11) ? '是' : '否' }}</td>
                        <td>{{ $mp->canManageMaterial() ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>摇一摇周边</td>
                        <td>{{ $mp->hasFunc(12) ? '是' : '否' }}</td>
                        <td>{{ $mp->open_shake ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>门店</td>
                        <td>{{ $mp->hasFunc(13) ? '是' : '否' }}</td>
                        <td>{{ $mp->open_store ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>支付</td>
                        <td>{{ $mp->hasFunc(14) ? '是' : '否' }}</td>
                        <td>{{ $mp->open_pay ? '是' : '否' }}</td>
                    </tr>
                    <tr>
                        <td>自定义菜单</td>
                        <td>{{ $mp->hasFunc(15) ? '是' : '否' }}</td>
                        <td>{{ $mp->hasFunc(15) ? '是' : '否' }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        </tbody>
    </table>
@endsection