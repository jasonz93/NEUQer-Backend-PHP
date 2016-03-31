<md-card ng-repeat="handler in {{ $handlers }}" md-whiteframe="4">
    <md-card-title>
        <md-card-title-text>
            <span ng-bind="handler.name"></span>
        </md-card-title-text>
    </md-card-title>
    <md-card-content layout="column">
        <md-input-container>
            <label>优先级</label>
            <input type="number" ng-model="handler.priority">
        </md-input-container>
        <div layout="column" ng-if="handler.name == 'KEYWORD'">
            @include('wx3rd.manage.reply.keyword_params')
        </div>
    </md-card-content>
    <md-card-actions layout="row" layout-align="end center">
        <md-button class="md-raised" ng-click="vm.remove(handler)">删除</md-button>
        <md-button class="md-raised" ng-click="vm.save(handler)">保存</md-button>
    </md-card-actions>
</md-card>