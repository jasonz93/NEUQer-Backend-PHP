/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app', [
            'app.core',
            'app.router',
            'app.login',
            'app.dashboard',
            'app.mp',
            'app.mpinfo',
            'app.reply',
            'app.menu',
            'app.shake'
        ]);
}());