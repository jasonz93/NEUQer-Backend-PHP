<div class="ui visible top sidebar inverted menu">
    <div class="item" ng-repeat="mp in vm.mps">
        <a ng-bind="mp.nickname" ui-sref="mp({mp: mp.app_id})"></a>
    </div>
</div>

<div class="pusher">
    <!-- Sidebar -->
    <div class="ui visible sidebar inverted vertical menu">
        <a class="item" ui-sref="dashboard">总览</a>
        <a class="item" ui-sref="mp.info">公众号信息</a>
        <a class="item" ui-sref="mp.reply">自动回复设置</a>
    </div><!-- / sidebar -->

    <!-- page wrapper for angular views-->
    <div id="page-wrapper">
        <div class="pusher">
            <div class="ui container">
                <div ui-view></div>
            </div>
        </div>
    </div>
</div>
