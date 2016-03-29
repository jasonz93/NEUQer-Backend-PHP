<div class="card" ng-repeat="handler in {{ $handlers }}">
    <div class="content">
        <div class="header">
            <span ng-bind="handler.name"></span>
        </div>
    </div>
    <div class="content">
        <div class="ui labeled input">
            <div class="ui label text">优先级</div>
            <input type="number" ng-model="handler.priority">
        </div>
    </div>
    <div class="content" ng-if="handler.name == 'KEYWORD'">
        @include('wx3rd.manage.reply.keyword_params')
    </div>
    <div class="content">
        <a class="ui primary button" ng-click="vm.save(handler)">保存</a>
    </div>
</div>