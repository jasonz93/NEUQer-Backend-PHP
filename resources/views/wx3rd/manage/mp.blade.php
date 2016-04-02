<div layout="row" layout-fill>
    <md-sidenav
            class="md-sidenav-left"
            md-is-locked-open="true"
            md-whiteframe="4">
        <md-toolbar flex>
            <div layout="column" layout-align="center center">
                <img ng-src="@{{ vm.mp.avatar }}" style="width: 120px; height: 120px;">
                <span ng-bind="vm.mp.nickname"></span>
            </div>
            <md-button ui-sref="dashboard">选择公众号</md-button>
            <md-button ui-sref="mp.info">公众号信息</md-button>
            <md-button ui-sref="mp.reply">自动回复设置</md-button>
            <md-button ui-sref="mp.menu">自定义菜单</md-button>
            <md-button ui-sref="mp.shake">摇一摇周边</md-button>
        </md-toolbar>
    </md-sidenav>

    <md-content layout-fill ui-view>
    </md-content>


</div>
