<h1 class="ui dividing header">自动回复设置</h1>
<md-button class="md-raised md-primary" ng-click="vm.showAdd($event)">添加</md-button>
<div layout="row" layout-fill>
    <div flex="50">
        <h3>正在使用</h3>
        <div class="ui one cards" id="using">
            @include('wx3rd.manage.reply.cards', ['handlers' => 'vm.using'])
        </div>
    </div>
    <div flex="50">
        <h3>闲置</h3>
        <div class="ui one cards" id="free">
            @include('wx3rd.manage.reply.cards', ['handlers' => 'vm.free'])
        </div>
    </div>
</div>
