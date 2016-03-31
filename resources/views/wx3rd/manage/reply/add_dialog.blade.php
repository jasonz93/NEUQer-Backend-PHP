<h3>添加自动回复</h3>

<div layout="column" ng-init="handler = {}">
    <md-input-container>
        <label>自动回复类型</label>
        <md-select ng-model="handler.name">
            <md-option value="TURING">小纽扣</md-option>
            <md-option value="KEYWORD">关键词回复</md-option>
        </md-select>
    </md-input-container>
    <md-input-container>
        <label>优先级</label>
        <input type="number" placeholder="优先级（大于等于0）" ng-model="handler.priority">
    </md-input-container>
    <div layout="column" ng-if="handler.name == 'KEYWORD'">
        @include('wx3rd.manage.reply.keyword_params')
    </div>
</div>
<md-button class="md-raised md-primary" ng-click="save(handler)">保存</md-button>