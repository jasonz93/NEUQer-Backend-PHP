<h1>自定义菜单设置</h1>
<section layout="column">
    <div layout="row">
        <div flex="33">
            一级菜单
        </div>
        <div flex="33">
            二级菜单
        </div>
    </div>
    <div layout="row" ng-repeat="button in vm.current.button">
        <div flex="33">
            <md-button class="md-raised md-primary" ng-bind="button.name" ng-click="vm.setCurrentItem(button)"></md-button>
        </div>

        <div layout="column" flex="66">
            <div layout="row" ng-repeat="second_button in button.sub_button">
                <div flex="50">
                    <md-button class="md-raised md-primary" ng-bind="second_button.name" ng-click="vm.currentItem = second_button"></md-button>
                </div>
            </div>
            <div flex="50">
                <md-button class="md-raised" ng-if="button.type == ''" ng-click="button.sub_button.push({sub_button:[]})">添加</md-button>
            </div>
        </div>
    </div>
    <div flex="33">
        <md-button class="md-raised" ng-click="vm.current.button.push({sub_button:[]})">添加</md-button>
    </div>

</section>
<section layout="column">
    <md-input-container>
        <label>类型</label>
        <md-select ng-model="vm.currentItem.type">
            <md-option value="">子菜单</md-option>
            <md-option value="view">打开链接</md-option>
        </md-select>
    </md-input-container>
    <md-input-container>
        <label>名称</label>
        <input ng-model="vm.currentItem.name">
    </md-input-container>
    <md-input-container ng-if="vm.currentItem.type == 'view'">
        <label>链接</label>
        <input ng-model="vm.currentItem.url">
    </md-input-container>
</section>
<md-button class="md-raised" ng-click="vm.save(vm.current)">保存</md-button>