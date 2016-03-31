
<md-toolbar md-whiteframe="4">
    <div class="md-toolbar-tools">
        <md-button ng-repeat="mp in vm.mps" ng-bind="mp.nickname" ui-sref="mp({mp: mp.app_id})"></md-button>
        <span flex></span>
        <md-button href="/wx3rd/authorize">添加</md-button>
    </div>
</md-toolbar>



<div layout="row" layout-fill>
    <md-sidenav
            class="md-sidenav-left"
            md-is-locked-open="true"
            md-whiteframe="4">
        <md-toolbar flex>
            <md-button ui-sref="mp.info">公众号信息</md-button>
            <md-button ui-sref="mp.reply">自动回复设置</md-button>
            <md-button ui-sref="mp.menu">自定义菜单</md-button>
        </md-toolbar>
    </md-sidenav>

    <md-content layout-fill ui-view>
    </md-content>


</div>
