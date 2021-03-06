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
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.login', [
            'app.core'
        ]);
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.dashboard', [
            'app.core'
        ]);
}());
/**
 * Created by nicholas on 16-3-30.
 */
(function () {
    'use strict';

    angular
        .module('app.menu', [
            'app.core'
        ]);
}());
/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.mp', [
            'app.core'
        ]);
}());
/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.mpinfo', [
            'app.core'
        ]);
}());
/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.reply', [
            'app.core'
        ]);
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.router', [
            'ui.router'
        ]);
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.shake', [
            'app.core'
        ]);
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.core', [
            'ui.router',
            'ngResource',
            'ngMaterial'
        ])
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.login')
        .controller('LoginController', LoginController);

    LoginController.$inject = ['$http', '$state'];

    function LoginController($http, $state) {
        var vm = this;

        vm.login = login;

        function login(user) {
            $http.post('/auth/login', user).success(function () {
                $state.go('dashboard');
            });
        }
    }
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function() {

    'use strict';

    angular
        .module('app.login')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'login',
                config: {
                    url: '/login',
                    templateUrl: '/views/wx3rd/manage/login/login',
                    controller: 'LoginController',
                    controllerAs: 'vm',
                    title: 'Login'
                }
            }
        ];
    }
})();
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.dashboard')
        .controller('DashboardController', DashboardController);

    DashboardController.$inject = ['$http'];

    function DashboardController($http) {
        var vm = this;

        getData();

        function getData() {
            $http.get('/api/wx3rd/mps').success(function (data) {
                vm.mps = data;
            });
        }
    }
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function() {

    'use strict';

    angular
        .module('app.dashboard')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'dashboard',
                config: {
                    url: '/dashboard',
                    templateUrl: '/views/wx3rd/manage/dashboard/index',
                    controller: 'DashboardController',
                    controllerAs: 'vm',
                    title: 'Dashboard'
                }
            }
        ];
    }
})();
/**
 * Created by nicholas on 16-3-30.
 */
(function () {
    'use strict';

    angular
        .module('app.menu')
        .controller('MenuController', MenuController);

    MenuController.$inject = ['$http', '$stateParams'];

    function MenuController($http, $stateParams) {
        var vm = this;

        vm.current = {
            button: []
        };

        getData();

        function getData() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/menu/current').success(function (data) {
                vm.current = data;
            });
        }

        vm.setCurrentItem = function (item) {
            vm.currentItem = item;
        };

        vm.save = function (menu) {
            $http.post('/api/wx3rd/mp/' + $stateParams.mp + '/menu', menu).success(function () {
                getData();
            });
        };
    }
}());
/**
 * Created by nicholas on 16-3-30.
 */
(function() {

    'use strict';

    angular
        .module('app.menu')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.menu',
                config: {
                    url: '/menu',
                    templateUrl: '/views/wx3rd/manage/menu/index',
                    controller: 'MenuController',
                    controllerAs: 'vm',
                    title: 'Menu'
                }
            }
        ];
    }
})();
/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.mp')
        .controller('MPController', MPController);

    MPController.$inject = ['$http', '$stateParams'];

    function MPController($http, $stateParams) {
        var vm = this;

        getData();

        function getData() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/info').success(function (data) {
                vm.mp = data;
            });
        }
    }
}());
/**
 * Created by nicholas on 16-3-29.
 */
(function() {

    'use strict';

    angular
        .module('app.mpinfo')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp',
                config: {
                    url: '/mp/:mp',
                    templateUrl: '/views/wx3rd/manage/mp',
                    controller: 'MPController',
                    controllerAs: 'vm',
                    title: 'MP'
                }
            }
        ];
    }
})();
/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.mpinfo')
        .controller('MPInfoController', MPInfoController);

    MPInfoController.$inject = ['$http', '$stateParams'];

    function MPInfoController($http, $stateParams) {
        var vm = this;

        vm.refresh = refresh;

        getData();

        function getData() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/info').success(function (data) {
                vm.mp = data;
            });
        }

        function refresh() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/refresh').success(function () {
                getData();
            });
        }
    }
}());
/**
 * Created by nicholas on 16-3-29.
 */
(function() {

    'use strict';

    angular
        .module('app.mpinfo')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.info',
                config: {
                    url: '/info',
                    templateUrl: '/views/wx3rd/manage/mpinfo/index',
                    controller: 'MPInfoController',
                    controllerAs: 'vm',
                    title: 'MPInfo'
                }
            }
        ];
    }
})();
/**
 * Created by nicholas on 16-3-29.
 */
(function () {
    'use strict';

    angular
        .module('app.reply')
        .controller('ReplyController', ReplyController);

    ReplyController.$inject = ['$http', '$stateParams', '$mdDialog'];

    function ReplyController($http, $stateParams, $mdDialog) {
        var vm = this;
        vm.save = save;
        vm.showAdd = showAdd;
        vm.create = create;
        vm.remove = remove;

        getData();

        function getData() {
            vm.free = [];
            vm.using = [];
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handlers').success(function (handlers) {
                for (var i in handlers) {
                    if (handlers[i].priority == 0) {
                        vm.free.push(handlers[i]);
                    } else {
                        vm.using.push(handlers[i]);
                    }
                }
            });
        }

        function save(handler) {
            $http.put('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handler/' + handler.id, handler).success(function () {
                getData();
            });
        }

        function create(handler) {
            $http.post('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handler', handler).success(function () {
                getData();
            });
        }

        function remove(handler) {
            $http.delete('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handler/' + handler.id).success(function () {
                getData();
            });
        }

        function showAdd(ev) {
            $mdDialog.show({
                controller: AddDialogController,
                templateUrl: '/views/wx3rd/manage/reply/add_dialog',
                parent: angular.element(document.body),
                targetEvent: ev,
                clickOutsideToClose: true
            }).then(function (handler) {
                $http.post('/api/wx3rd/mp/' + $stateParams.mp + '/reply/handler', handler).success(function () {
                    getData();
                });
            }, function () {});
        }

        AddDialogController.$inject = ['$scope', '$mdDialog'];

        function AddDialogController($scope, $mdDialog) {
            $scope.save = function (handler) {
                $mdDialog.hide(handler);
            };

            $scope.cancel = function () {
                $mdDialog.cancel();
            };
        }
    }
}());
/**
 * Created by nicholas on 16-3-29.
 */
(function() {

    'use strict';

    angular
        .module('app.reply')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.reply',
                config: {
                    url: '/reply',
                    templateUrl: '/views/wx3rd/manage/reply/index',
                    controller: 'ReplyController',
                    controllerAs: 'vm',
                    title: 'Reply'
                }
            }
        ];
    }
})();
/**
 * Created by nicholas on 16-3-28.
 */
/* Help configure the state-base ui.router */
(function() {

    'use strict';

    angular
        .module('app.router')
        .provider('routerHelper', routerHelperProvider);

    routerHelperProvider.$inject = ['$locationProvider', '$stateProvider', '$urlRouterProvider'];
    /* @ngInject */
    function routerHelperProvider($locationProvider, $stateProvider, $urlRouterProvider) {
        /* jshint validthis:true */
        var config = {
            docTitle: 'Admin',
            resolveAlways: {}
        };

        $locationProvider.html5Mode(true);

        this.configure = function(cfg) {
            angular.extend(config, cfg);
        };

        this.$get = RouterHelper;
        RouterHelper.$inject = ['$location', '$rootScope', '$state'];
        /* @ngInject */
        function RouterHelper($location, $rootScope, $state, logger) {
            var handlingStateChangeError = false;
            var hasOtherwise = false;
            var stateCounts = {
                errors: 0,
                changes: 0
            };

            var service = {
                configureStates: configureStates,
                getStates: getStates,
                stateCounts: stateCounts
            };

            init();

            return service;

            function configureStates(states, otherwisePath) {
                states.forEach(function(state) {
                    state.config.resolve =
                        angular.extend(state.config.resolve || {}, config.resolveAlways);
                    $stateProvider.state(state.state, state.config);
                });
                if (otherwisePath && !hasOtherwise) {
                    hasOtherwise = true;
                    $urlRouterProvider.otherwise(otherwisePath);
                }
            }

            function handleRoutingErrors() {
                // Route cancellation:
                // On routing error, go to the dashboard.
                // Provide an exit clause if it tries to do it twice.
                $rootScope.$on('$stateChangeError',
                    function(event, toState, toParams, fromState, fromParams, error) {
                        if (handlingStateChangeError) {
                            return;
                        }
                        stateCounts.errors++;
                        handlingStateChangeError = true;
                        var destination = (toState &&
                            (toState.title || toState.name || toState.loadedTemplateUrl)) ||
                            'unknown target';
                        var msg = 'Error routing to ' + destination + '. ' +
                            (error.data || '') + '. <br/>' + (error.statusText || '') +
                            ': ' + (error.status || '');
                        logger.warning(msg, [toState]);
                        $location.path('/');
                    }
                );
            }

            function init() {
                handleRoutingErrors();
                updateDocTitle();
            }

            function getStates() { return $state.get(); }

            function updateDocTitle() {
                $rootScope.$on('$stateChangeSuccess',
                    function(event, toState, toParams, fromState, fromParams) {
                        stateCounts.changes++;
                        handlingStateChangeError = false;
                        var title = (toState.title || '') + ' · ' + config.docTitle;
                        $rootScope.mainUrl = $state.current.url.split('/')[2];
                        $rootScope.title = title; // data bind to <title>
                    }
                );
            }
        }
    }

})();
/**
 * Created by nicholas on 16-3-28.
 */
(function () {
    'use strict';

    angular
        .module('app.shake')
        .controller('ShakeController', ShakeController);

    ShakeController.$inject = ['$http', '$stateParams'];

    function ShakeController($http, $stateParams) {
        var vm = this;

        vm.getStatus = getStatus;

        getStatus();

        function getStatus() {
            $http.get('/api/wx3rd/mp/' + $stateParams.mp + '/shake/audit').success(function (data) {
                console.log(data);
                vm.audit = data.data;
            });
        }
    }
}());
/**
 * Created by nicholas on 16-3-28.
 */
(function() {

    'use strict';

    angular
        .module('app.shake')
        .run(appRun);

    appRun.$inject = ['routerHelper'];
    /* @ngInject */
    function appRun(routerHelper) {
        routerHelper.configureStates(getStates());
    }

    function getStates() {
        return [
            {
                state: 'mp.shake',
                config: {
                    url: '/shake',
                    templateUrl: '/views/wx3rd/manage/shake/index',
                    controller: 'ShakeController',
                    controllerAs: 'vm',
                    title: 'Shake'
                }
            }
        ];
    }
})();