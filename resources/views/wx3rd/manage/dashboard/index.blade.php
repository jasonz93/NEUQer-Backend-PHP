<style>
    md-grid-tile {
        overflow: hidden;
    }

    md-grid-tile img {
        width: 100%;
        height: auto;
    }
</style>

<md-grid-list
        md-cols-xs="1" md-cols-sm="2" md-cols-md="4" md-cols-gt-md="6"
        md-row-height="2:2">
    <md-grid-tile ng-repeat="mp in vm.mps" ui-sref="mp.info({mp: mp.app_id})">
        <img ng-src="@{{ mp.avatar }}"/>
        <md-grid-tile-footer>
            <span ng-bind="mp.nickname"></span>
        </md-grid-tile-footer>
    </md-grid-tile>
    <md-grid-tile>
        <md-button class="md-raised" href="{{ route('wx3rd.authorize') }}">添加</md-button>
    </md-grid-tile>

</md-grid-list>
