<?php header('Access-Control-Allow-Origin: *'); ?>
<!DOCTYPE html>


<html lang="en">
<head>
    <meta charset="utf 8">
    <title>Form Wizard</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.7.9/angular-sanitize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-mocks/1.7.9/angular-mocks.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ui-select@0.19.8/dist/select.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="BookingTemplateAssets/js/datetimepicker.js"></script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"/>

    <link rel="stylesheet" href="BookingTemplateAssets/css/style.css">
    <link rel="stylesheet"
          href="BookingTemplateAssets/fonts/material-design-iconic-font/css/material-design-iconic-font.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ui-select@0.19.8/dist/select.min.css">

    <style>
        .lds-container {
            position: absolute;
            top: 0;
            left: 0;

            display: flex;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            align-content: center;

            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .lds-facebook {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-facebook div {
            display: inline-block;
            position: absolute;
            left: 8px;
            width: 16px;
            background: #8eb852;
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }

        .lds-facebook div:nth-child(1) {
            left: 8px;
            animation-delay: -0.24s;
        }

        .lds-facebook div:nth-child(2) {
            left: 32px;
            animation-delay: -0.12s;
        }

        .lds-facebook div:nth-child(3) {
            left: 56px;
            animation-delay: 0;
        }

        @keyframes lds-facebook {
            0% {
                top: 8px;
                height: 64px;
            }
            50%, 100% {
                top: 24px;
                height: 32px;
            }
        }
    </style>

    <style>
        .wrapper {
            width: 826px;
            height: auto;
            padding: 63px 90px;
            background: #fff;
        }

        .hidden {
            display: none !important;
        }

        .list {
            min-height: 100px;
        }

        .list-item {
            display: block;
            margin: 20px 10px;
            padding: 10px;
            border: 1px solid #e6e6e6;
            color: #999;
        }

        .list-item:first-child {
            margin-top: 0px;
        }

        .list-item:last-child {
            margin-bottom: 0px;
        }

        .list-item.active {
            border-width: 1px;
            border-color: #8eb852;
        }

        .img > img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .service-item .img {
            display: inline-block;
            height: 48px;
            width: 48px;

            margin-right: 10px;
            background: #eee;
        }

        .service-item .text {
            display: inline-flex;
            align-items: center;
        }

        .employee-item .img {
            display: inline-block;
            height: 24px;
            width: 24px;

            margin-right: 10px;
            background: #eee;
        }

        .employee-item .text {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
        }

        .flex {
            display: flex;
            align-items: center;
        }

        .space-between {
            justify-content: space-between;
        }

        .w-10 {
            width: 10%;
        }

        .w-20 {
            width: 20%;
        }

        .w-30 {
            width: 30%;
        }

        .w-40 {
            width: 40%;
        }

        .w-50 {
            width: 50%;
        }

        .w-60 {
            width: 60%;
        }

        .w-70 {
            width: 70%;
        }

        .w-80 {
            width: 80%;
        }

        .w-90 {
            width: 90%;
        }

        .w-100 {
            width: 100%;
        }

        .flex-item {
            flex-grow: 1;
        }

        .clickable {
            cursor: pointer;
            user-select: none;
        }

        input.date-picker {
            height: 100%;
            width: 100%;

            padding: 10px;
            font-size: 12px;
            width: 88px;

            align-self: center;
        }

        input.error {
            border: 1px solid red;
        }

        .summary {
            width: 60%;
            margin: auto;
        }

        .summary th {
            padding: 11px 0;
            width: 30%;
            font-weight: bold;
            text-align: left;
            vertical-align: top;
        }

        .summary td {
            vertical-align: top;
            padding: 11px 0;
        }

        .confirm {
            width: 60%;
            margin: auto;
            margin-top: 15px;
        }

        .confirm > label {
            display: block;
            margin-bottom: 5px;
        }

        .actions > ul > li.disabled > a {
            background: #aaa;
            pointer-events: none;
        }

        ul.navigation > li.disabled > a {
            filter: grayscale(100%);
            pointer-events: none;
        }
    </style>
</head>
<body ng-app="app">
<div ng-controller="FormWizardController">
    <div class="lds-container" ng-if="false">
        <div class="lds-facebook">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="wrapper">
        <form name="templateForm" class="wizard" novalidate>
            <div class="steps clearfix">
                <ul class="navigation">
                    <li role="tab" class="first current">
                        <a ng-click="setStep(1)">
                            <span class="current-info audible">current step: </span>
                            <span class="number">1.</span>
                            <img ng-src="BookingTemplateAssets/images/step-1{{ step === 1 ? '-active' : '' }}.png"
                                 alt="">
                            <span class="step-order">Step 01</span>
                        </a>
                        <img src="BookingTemplateAssets/images/step-arrow.png" alt="" class="step-arrow">
                    </li>
                    <li role="tab" ng-class="{ disabled: step < 2 }">
                        <a ng-click="setStep(2)">
                            <span class="number">2.</span>
                            <img ng-src="BookingTemplateAssets/images/step-2{{ step === 2 ? '-active' : '' }}.png"
                                 alt="">
                            <span class="step-order">Step 02</span>
                        </a>
                        <img src="BookingTemplateAssets/images/step-arrow.png" alt="" class="step-arrow">
                    </li>
                    <li role="tab" ng-class="{ disabled: step < 3 }">
                        <a ng-click="setStep(3)">
                            <span class="number">3.</span>
                            <img ng-src="BookingTemplateAssets/images/step-3{{ step === 3 ? '-active' : '' }}.png"
                                 alt="">
                            <span class="step-order">Step 03</span>
                        </a>
                        <img src="BookingTemplateAssets/images/step-arrow.png" alt="" class="step-arrow">
                    </li>
                    <li role="tab" ng-class="{ disabled: step < 4 }">
                        <a ng-click="setStep(4)">
                            <span class="number">4.</span>
                            <img ng-src="BookingTemplateAssets/images/step-4{{ step === 4 ? '-active' : '' }}.png"
                                 alt="">
                            <span class="step-order">Step 04</span>
                        </a>
                    </li>
                    <li role="tab" class="last" ng-class="{ disabled: step < 5 }">
                        <a ng-click="setStep(5)">
                            <span class="number">5.</span>
                            <img ng-src="BookingTemplateAssets/images/step-4{{ step === 5 ? '-active' : '' }}.png"
                                 alt="">
                            <span class="step-order">Step 05</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="content" ng-switch="step">
                <section ng-switch-when="1">
                    <h4></h4>
                    <h3>Basic details</h3>
                    <div class="form-row">
                        <div class="form-holder w-100">
                            <i class="zmdi zmdi-account"></i>
                            <input type="text" class="form-control"
                                   ng-class="{ error: templateForm.name.$touched && templateForm.name.$invalid }"
                                   placeholder="Last Name" name="name" ng-model="form.info.name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder w-100">
                            <i class="zmdi zmdi-account"></i>
                            <input type="text" class="form-control"
                                   ng-class="{ error: templateForm.phone.$touched && templateForm.phone.$invalid }"
                                   placeholder="Phone Number" name="phone" ng-model="form.info.phone" required>
                        </div>
                    </div>
                </section>
                <section ng-switch-when="2">
                    <h3>Pick Service</h3>

                    <div class="list">
                        <div class="list-item service-item clickable"
                             ng-class="{ active: form.services[item.id].active }"
                             ng-repeat="(key, item) in servicesMap"
                             ng-click="form.services[item.id].active = !form.services[item.id].active">
                            <div class="img">
                                <img alt="" ng-src="{{ item.img }}"/>
                            </div>
                            <span class="text">{{ item.text }}</span>
                        </div>
                    </div>
                </section>
                <section ng-switch-when="3">
                    <h3>Pick Employee</h3>

                    <div class="list">
                        <div class="list-item flex space-between"
                             ng-repeat="(key, item) in servicesMap"
                             ng-if="form.services[item.id].active">

                            <div class="flex-item service-item w-70">
                                <div class="img">
                                    <img alt="" ng-src="{{ item.img }}"/>
                                </div>

                                <div class="text">{{ item.text }}</div>
                            </div>

                            <div class="flex-item w-30">
                                <ui-select class="w-100" ng-model="form.services[item.id].employeeId" theme="select2"
                                           title="Choose a employee" append-to-body="1">
                                    <ui-select-match placeholder="Select a employee">
                                        {{ $select.selected.name }}
                                    </ui-select-match>
                                    <ui-select-choices
                                        repeat="employee.id as employee in employees | propsFilter: { name: $select.search }">
                                        <div class="flex-item employee-item">
                                            <div class="img">
                                                <img alt="" ng-src="{{ employee.img }}"/>
                                            </div>

                                            <div class="text"
                                                 ng-bind-html="employee.name | highlight: $select.search"></div>
                                        </div>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                    </div>
                </section>
                <section ng-switch-when="4">
                    <h3>Pick Date</h3>

                    <div class="list">
                        <div class="list-item flex space-between"
                             ng-repeat="(key, item) in servicesMap"
                             ng-if="form.services[item.id].active">

                            <div class="flex flex-item service-item w-80" style="align-items: center">
                                <div class="img">
                                    <img alt="" ng-src="{{ item.img }}"/>
                                </div>

                                <div style="display: inline-flex; flex-flow: column">
                                    <span>{{ item.text }}</span>
                                    <b>
                                        <small>Employee: {{ employeesMap[form.services[item.id].employeeId].name }}
                                        </small>
                                    </b>
                                </div>
                            </div>

                            <div class="flex flex-item w-20" style="justify-content: flex-end">
                                <div class="input-group" datetimepicker
                                     ng-model="form.services[item.id].date"
                                     options="{
                                                    format: 'MM/DD/YYYY - HH A',
                                                    enabledHours: availableTimes[form.services[item.id].employeeId][form.services[item.id].date.startOf('day').valueOf()],
                                                    enabledDates: util.keys(availableTimes[form.services[item.id].employeeId]).map(util.toMoment)
                                                    }">
                                    <input class="form-control" style="width: 160px; padding: 10px;"/>
                                    <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section ng-switch-when="5">
                    <h4></h4>
                    <h3>Summary</h3>
                    <div class="summary">
                        <table cellspacing="0">
                            <tr>
                                <th>Name</th>
                                <td data-title="Subtotal">
                                    <span>{{ form.info.name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td data-title="Subtotal">
                                    <span>{{ form.info.phone }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Services</th>
                                <td>
                                    <div ng-repeat="(key, item) in servicesMap"
                                         ng-if="form.services[item.id].active"
                                         style="margin-bottom: 5px;">
                                        <div>{{ item.text }} by <b>{{
                                                employeesMap[form.services[item.id].employeeId].name }}</b></div>
                                        <div>at <b>{{ form.services[item.id].date.valueOf() | date:'medium' }}</b></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>

            <div class="confirm" ng-class="{ hidden: step !== maxStep }">
                <label><input ng-model="form.confirm.term" type="checkbox"/> I have read and understand the <a
                        href="/terms">Privacy policy</a></label>
                <label><input ng-model="form.confirm.cookie" type="checkbox"/> I have read and agree to the <a
                        href="/terms">Term Of Use</a> and <a href="">Cookies Policy</a></label>
            </div>

            <div class="actions clearfix">
                <ul role="menu" ng-class="{ 'step-4': step === maxStep }">
                    <li ng-class="{ hidden: step === maxStep }">
                        <a ng-click="prevStep()" role="menuitem">Back</a>
                    </li>
                    <li ng-class="{ hidden: validateNext(), disabled: disableNext(templateForm) }">
                        <a ng-click="nextStep()" role="menuitem">Continue</a>
                    </li>
                    <li ng-class="{ hidden: step !== maxStep, disabled: disableNext(templateForm) }">
                        <a ng-click="done()" role="menuitem">Proceed to checkout</a>
                    </li>
                </ul>
            </div>
        </form>
    </div>
</div>

<script>
    const app = angular.module('app', ['ae-datetimepicker', 'ui.select', 'ngSanitize']);

    app.filter('propsFilter', function () {
        return function (items, props) {
            var out = [];

            if (angular.isArray(items)) {
                var keys = Object.keys(props);

                items.forEach(function (item) {
                    var itemMatches = false;

                    for (var i = 0; i < keys.length; i++) {
                        var prop = keys[i];
                        var text = props[prop].toLowerCase();
                        if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                            itemMatches = true;
                            break;
                        }
                    }

                    if (itemMatches) {
                        out.push(item);
                    }
                });
            } else {
                out = items;
            }

            return out;
        };
    });

    app.factory('formWizardService', function ($http) {
        return {
            findServices: function () {
                return $http
                    .get('http://localhost:8000/api/admin/list_services')
                    .catch(err => [
                        {
                            id: 1,
                            img: 'assets/images/item-1.jpg',
                            text: 'Non diam phasellus vestibulum?',
                            active: false
                        },
                        {
                            id: 2,
                            img: 'assets/images/item-2.jpg',
                            text: 'Fermentum dui faucibus in!',
                            active: false
                        },
                        {
                            id: 3,
                            img: 'assets/images/item-1.jpg',
                            text: 'Convallis aenean et tortor?',
                            active: false
                        },
                        {
                            id: 4,
                            img: 'assets/images/item-2.jpg',
                            text: 'Tellus cras adipiscing enim?',
                            active: false
                        }
                    ]);
            },
            findEmployees: function () {
                return $http
                    .get('http://server/findEmployees')
                    .catch(err => [
                        {id: 1, name: 'Adam', img: 'assets/images/item-1.jpg'},
                        {id: 2, name: 'Amalie', img: 'assets/images/item-2.jpg'},
                        {id: 3, name: 'Estefanía', img: 'assets/images/item-1.jpg'},
                        {id: 4, name: 'Adrian', img: 'assets/images/item-2.jpg'},
                        {id: 5, name: 'Wladimir', img: 'assets/images/item-1.jpg'},
                        {id: 6, name: 'Samantha', img: 'assets/images/item-2.jpg'},
                        {id: 7, name: 'Nicole', img: 'assets/images/item-1.jpg'},
                        {id: 8, name: 'Natasha', img: 'assets/images/item-2.jpg'},
                        {id: 9, name: 'Michael', img: 'assets/images/item-1.jpg'}
                    ]);
            },
            findAvailableTimeOfEmployee: function (id) {
                return $http
                    .get('http://server/findAvailableTimeOfEmployee?id=' + id)
                    .catch(err => ({
                        [moment(new Date()).valueOf()]: [1, 3, 5],
                        [moment(new Date()).add(1, 'days').valueOf()]: [12, 20],
                    }));
            },
        };
    });

    app.controller('FormWizardController', FormWizardController);

    function FormWizardController($scope, $timeout, formWizardService) {
        $scope.loading = false;

        $scope.util = {
            keys: Object.keys,
            toInt: s => +s,
            toMoment: s => moment(+s),
        };

        $scope.step = 2;
        $scope.maxStep = 5;

        $scope.services = [];
        $scope.servicesMap = {};

        $scope.employees = [];
        $scope.employeesMap = {};

        $scope.$watch('services', function (newValue, oldValue) {
            $scope.servicesMap = newValue.reduce((result, item) => {
                return {
                    ...result,
                    [item.id]: item
                }
            }, {});
        });

        $scope.$watch('employees', function (newValue, oldValue) {
            $scope.employeesMap = newValue.reduce((result, item) => {
                return {
                    ...result,
                    [item.id]: item
                }
            }, {});
        });

        $scope.services = [
            {
                id: 1,
                img: 'assets/images/item-1.jpg',
                text: 'Non diam phasellus vestibulum?',
                active: false
            },
            {
                id: 2,
                img: 'assets/images/item-2.jpg',
                text: 'Fermentum dui faucibus in!',
                active: false
            },
            {
                id: 3,
                img: 'assets/images/item-1.jpg',
                text: 'Convallis aenean et tortor?',
                active: false
            },
            {
                id: 4,
                img: 'assets/images/item-2.jpg',
                text: 'Tellus cras adipiscing enim?',
                active: false
            }
        ];

        $scope.employees = [
            {id: 1, name: 'Adam', img: 'assets/images/item-1.jpg'},
            {id: 2, name: 'Amalie', img: 'assets/images/item-2.jpg'},
            {id: 3, name: 'Estefanía', img: 'assets/images/item-1.jpg'},
            {id: 4, name: 'Adrian', img: 'assets/images/item-2.jpg'},
            {id: 5, name: 'Wladimir', img: 'assets/images/item-1.jpg'},
            {id: 6, name: 'Samantha', img: 'assets/images/item-2.jpg'},
            {id: 7, name: 'Nicole', img: 'assets/images/item-1.jpg'},
            {id: 8, name: 'Natasha', img: 'assets/images/item-2.jpg'},
            {id: 9, name: 'Michael', img: 'assets/images/item-1.jpg'}
        ];

        $scope.availableTimes = {};

        $scope.form = {
            info: {
                name: 'Fermentum',
                phone: '0123456789'
            },
            confirm: {
                term: false,
                cookie: false
            },
            services: {}
        };

        $scope.setStep = function (step) {
            switch (step) {
                case 2: {
                    $scope.loading = true;

                    formWizardService.findServices().then(services => {
                        $scope.services = services;
                        $scope.form.services = $scope.services.reduce((result, item) => {
                            return {
                                ...result,
                                [item.id]: {
                                    active: false
                                }
                            }
                        }, {});

                        $timeout(() => {
                            $scope.loading = false;
                            $scope.step = step;
                        })
                    });
                    break;
                }

                case 3: {
                    $scope.loading = true;

                    formWizardService.findEmployees().then(employees => {
                        $scope.employees = employees;

                        $timeout(() => {
                            $scope.loading = false;
                            $scope.step = step;
                        })
                    });
                    break;
                }

                case 4: {
                    $scope.loading = true;

                    const employeeIds = Object.values($scope.form.services)
                        .filter(item => item.active)
                        .map(item => item.employeeId);

                    Promise.all(employeeIds.map(formWizardService.findAvailableTimeOfEmployee))
                        .then(availableTimes => {
                            employeeIds.forEach((id, index) => {
                                $scope.availableTimes[id] = Object.keys(availableTimes[index]).reduce((result, timestamp) => {
                                    return {
                                        ...result,
                                        [moment(+timestamp).startOf('day').valueOf()]: availableTimes[index][timestamp]
                                    };
                                }, {});
                            });

                            Object.keys($scope.form.services).forEach(serviceId => {
                                const service = $scope.form.services[serviceId];

                                service.date = moment(+Object.keys($scope.availableTimes[service.employeeId])[0]);
                            });

                            $timeout(() => {
                                $scope.loading = false;
                                $scope.step = step;
                            })
                        });

                    break;
                }
                default: {
                    $scope.loading = false;
                    $scope.step = step;
                }
            }


        };

        $scope.nextStep = function () {
            $scope.setStep(Math.min($scope.step + 1, $scope.maxStep));
        };

        $scope.prevStep = function () {
            $scope.setStep(Math.max($scope.step - 1, 1));
        };

        $scope.done = function () {
            console.log($scope.form);
        };

        $scope.validateNext = function () {
            return $scope.step === $scope.maxStep;
        };

        $scope.disableNext = function (form, step = $scope.step) {
            switch (step) {
                case 1: {
                    return !(form.name.$valid && form.phone.$valid)
                }

                case 2: {
                    return Object.values($scope.form.services).every(item => !item.active);
                }

                case 3: {
                    return Object.values($scope.form.services).filter(item => item.active).some(item => !item.employeeId);
                }

                case 4: {
                    return false;
                }

                case 5: {
                    return !($scope.form.confirm.term && $scope.form.confirm.cookie);
                }

                default: {
                    return false;
                }
            }
        }
    }
</script>
</body>
</html>
