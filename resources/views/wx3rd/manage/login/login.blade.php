<div layout="row" layout-align="center">
    <div flex="30" layout="column">
        <md-card md-whiteframe="4">
            <md-card-title>
                <md-card-title-text>
                    <span>用户登录</span>
                </md-card-title-text>
            </md-card-title>
            <md-card-content layout="column" ng-init="user={}">
                <md-input-container>
                    <label>电子邮箱</label>
                    <input type="email" ng-model="user.email">
                </md-input-container>
                <md-input-container>
                    <label>密码</label>
                    <input type="password" ng-model="user.password">
                </md-input-container>
            </md-card-content>
            <md-card-actions layout="row" layout-align="end center">
                <md-button class="md-raised" ng-click="vm.login(user)">登录</md-button>
            </md-card-actions>
        </md-card>

    </div>
</div>
