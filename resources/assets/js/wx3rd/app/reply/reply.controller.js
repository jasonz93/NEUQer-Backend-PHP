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