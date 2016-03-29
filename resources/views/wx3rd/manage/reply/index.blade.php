<h1 class="ui dividing header">自动回复设置</h1>
<a class="ui positive button" ng-click="vm.showAdd()">添加</a>
<div class="ui grid">
    <div class="eight wide column">
        <h3>正在使用</h3>
        <div class="ui one cards" id="using">
            @include('wx3rd.manage.reply.cards', ['handlers' => 'vm.using'])
        </div>
    </div>
    <div class="eight wide column">
        <h3>闲置</h3>
        <div class="ui one cards" id="free">
            @include('wx3rd.manage.reply.cards', ['handlers' => 'vm.free'])
        </div>
    </div>
</div>

<div class="ui modal" ng-class="{'active': vm.showAddModal}">
    <div class="header">添加自动回复
        <i class="remove circle icon" ng-click="vm.showAddModal = false"></i>
    </div>
    <div class="content" ng-init="handler = {}">
        <div>
            <select class="ui dropdown" ng-model="handler.name">
                <option value="TURING">小纽扣</option>
                <option value="KEYWORD">关键词回复</option>
            </select>
        </div>
        <div>
            <div class="ui input">
                <input id="handlerPriority" type="number" placeholder="优先级（大于等于0）" ng-model="handler.priority">
            </div>
        </div>
        <div id="handlerParams" class="ui form">
            <div ng-if="handler.name == 'KEYWORD'">
                @include('wx3rd.manage.reply.keyword_params')
            </div>
        </div>
    </div>
    <div class="footer">
        <a id="btnSave" class="ui positive button" ng-click="vm.create(handler)">保存</a>
    </div>
</div>
