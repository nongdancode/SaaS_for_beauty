<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf 8">
        <title>Booking Form</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.7.9/angular-sanitize.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/ui-select@0.19.8/dist/select.min.js"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/angular-daterangepicker@0.2.3-alpha1/js/angular-daterangepicker.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="booking_template_asset/assets/css/style.css">
	<link rel="stylesheet" href="booking_template_asset/assets/fonts/material-design-iconic-font/css/material-design-iconic-font.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ui-select@0.19.8/dist/select.min.css">

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
             overflow-y: auto;
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
             width:100%;
             height:100%;
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

         input[date-range-picker] {
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
            <div class="wrapper">
                <form name="templateForm" class="wizard" novalidate>
                    <div class="steps clearfix">
                        <ul class="navigation">
                            <li role="tab" class="first current">
                                <a ng-click="setStep(1)">
                                    <span class="current-info audible">current step: </span>
                                    <span class="number">1.</span>
                                    <img ng-src="booking_template_asset/images/bookingPages/step-1{{ step === 1 ? '-active' : '' }}.png" alt="">
                                    <span class="step-order">Step 01</span>
                                </a>
                                <img src="booking_template_asset/images/bookingPages/step-arrow.png" alt="" class="step-arrow">
                            </li>
                            <li role="tab" ng-class="{ disabled: step < 2 }">
                                <a ng-click="setStep(2)">
                                    <span class="number">2.</span>
                                    <img ng-src="booking_template_asset/images/bookingPages/step-2{{ step === 2 ? '-active' : '' }}.png" alt="">
                                    <span class="step-order">Step 02</span>
                                </a>
                                <img src="booking_template_asset/images/bookingPages/step-arrow.png" alt="" class="step-arrow">
                            </li>
                            <li role="tab" ng-class="{ disabled: step < 3 }">
                                <a ng-click="setStep(3)">
                                    <span class="number">3.</span>
                                    <img ng-src="booking_template_asset/images/bookingPages/step-3{{ step === 3 ? '-active' : '' }}.png" alt="">
                                    <span class="step-order">Step 03</span>
                                </a>
                                <img src="booking_template_asset/images/bookingPages/step-arrow.png" alt="" class="step-arrow">
                            </li>
                            <li role="tab" ng-class="{ disabled: step < 4 }">
                                <a ng-click="setStep(4)">
                                    <span class="number">4.</span>
                                    <img ng-src="booking_template_asset/images/bookingPages/step-4{{ step === 4 ? '-active' : '' }}.png" alt="">
                                    <span class="step-order">Step 04</span>
                                </a>
                                <img src="booking_template_asset/images/bookingPages/step-arrow.png" alt="" class="step-arrow">
                            </li>
                            <li role="tab" class="last" ng-class="{ disabled: step < 5 }">
                                <a ng-click="setStep(5)">
                                    <span class="number">5.</span>
                                    <img ng-src="booking_template_asset/images/bookingPages/step-4{{ step === 5 ? '-active' : '' }}.png" alt="">
                                    <span class="step-order">Step 05</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="content" ng-switch="step" >
                        <section ng-switch-when="1">
                            <h4></h4>
                            <h3>Basic details</h3>
                            <div class="form-row">
                                <div class="form-holder w-100">
                                    <i class="zmdi zmdi-account"></i>
                                    <input type="text" class="form-control" ng-class="{ error: templateForm.firstName.$touched && templateForm.firstName.$invalid }"
                                           placeholder="First Name" name="firstName" ng-model="form.info.firstName" required>
                                </div>
                            </div>
<!--                            <div class="form-row">-->
<!--                                <div class="form-holder w-100">-->
<!--                                    <i class="zmdi zmdi-account"></i>-->
<!--                                    <input type="text" class="form-control" ng-class="{ error: templateForm.lastName.$touched && templateForm.lastName.$invalid }"-->
<!--                                           placeholder="Last Name" name="lastName" ng-model="form.info.lastName" required>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="form-row">
                                <div class="form-holder w-100">
                                    <i class="zmdi zmdi-account"></i>
                                    <input type="text" class="form-control" ng-class="{ error: templateForm.phone.$touched && templateForm.phone.$invalid }"
                                           placeholder="Phone Number" name="phone" ng-model="form.info.phone" required>
                                </div>
                            </div>
<!--                            <div class="form-row">-->
<!--                                <div class="form-holder w-100">-->
<!--                                    <i class="zmdi zmdi-account"></i>-->
<!--                                    <input type="text" class="form-control" ng-class="{ error: templateForm.email.$touched && templateForm.email.$invalid }"-->
<!--                                           placeholder="Email Address" name="email" ng-model="form.info.email" required>-->
<!--                                </div>-->
<!--                            </div>-->
                        </section>
                        <section ng-switch-when="2">
                            <h3>Pick Service</h3>

                            <div class="list">
                                <div class="list-item service-item clickable" ng-class="{ active: form.services[item.id].active }"
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
                                        <ui-select class="w-100" ng-model="form.services[item.id].employeeId" theme="select2" title="Choose a employee" append-to-body="1">
                                            <ui-select-match placeholder="Select a employee in the list or search name...">
                                                {{ $select.selected.name }}
                                            </ui-select-match>
                                            <ui-select-choices repeat="employee.id as employee in employees | propsFilter: { name: $select.search }">
                                                <div class="flex-item employee-item">
                                                    <div class="img">
                                                        <img alt="" ng-src="{{ employee.img }}"/>
                                                    </div>

                                                    <div class="text" ng-bind-html="employee.name | highlight: $select.search"></div>
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
                                            <b><small>Employee: {{ employeesMap[form.services[item.id].employeeId].name }}</small></b>
                                        </div>
                                    </div>

                                    <div class="flex flex-item w-20" style="justify-content: flex-end">
                                        <input date-range-picker class="form-control" type="text"
                                               ng-model="form.services[item.id].date"
                                               options="{ singleDatePicker: true, timePicker: true }" />
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
                                            <span>{{ form.info.firstName }} {{ form.info.lastName }}</span>
                                        </td>
                                    </tr>
<!--                                    <tr>-->
<!--                                        <th>Email</th>-->
<!--                                        <td data-title="Subtotal">-->
<!--                                            <span>{{ form.info.email }}</span>-->
<!--                                        </td>-->
<!--                                    </tr>-->
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
                                                <div>{{ item.text }} by <b>{{ employeesMap[form.services[item.id].employeeId].name }}</b></div>
                                                <div>at <b>{{ form.services[item.id].date.startDate | date:'medium' }}</b></div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                    </div>

                    <div class="confirm" ng-class="{ hidden: step !== maxStep }">
                        <label><input ng-model="form.confirm.term" type="checkbox" /> I have read and understand the <a href="">Privacy policy</a></label>
                        <label><input ng-model="form.confirm.cookie" type="checkbox" /> I have read and agree to the <a href="">Term Of Use</a> and <a href="">Cookies Policy</a></label>
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
         const app = angular.module('app', ['daterangepicker', 'ui.select', 'ngSanitize'])


         app.filter('propsFilter', function() {
             return function(items, props) {
                 var out = [];

                 if (angular.isArray(items)) {
                     var keys = Object.keys(props);

                     items.forEach(function(item) {
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

         app.controller('FormWizardController', FormWizardController)

         function FormWizardController($scope) {
             $scope.step = 1;
             $scope.maxStep = 5;

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
             ]

             $scope.servicesMap = $scope.services.reduce((result, item) => {
                 return {
                     ...result,
                     [item.id]: item
                 }
             }, {});

             $scope.employees = [
                 { id: 1, name: 'Adam',      img: 'booking_template_asset/assets/images/item-1.jpg' },
                 { id: 2, name: 'Amalie',    img: 'booking_template_asset/assets/images/item-2.jpg' },
                 { id: 3, name: 'Estefanía', img: 'booking_template_asset/assets/images/item-1.jpg' },
                 { id: 4, name: 'Adrian',    img: 'booking_template_asset/assets/images/item-2.jpg' },
                 { id: 5, name: 'Wladimir',  img: 'booking_template_asset/assets/images/item-1.jpg' },
                 { id: 6, name: 'Samantha',  img: 'booking_template_asset/assets/images/item-2.jpg' },
                 { id: 7, name: 'Nicole',    img: 'booking_template_asset/assets/images/item-1.jpg' },
                 { id: 8, name: 'Natasha',   img: 'booking_template_asset/assets/images/item-2.jpg' },
                 { id: 9, name: 'Michael',   img: 'booking_template_asset/assets/images/item-1.jpg' }
             ];

             $scope.employeesMap = $scope.employees.reduce((result, item) => {
                 return {
                     ...result,
                     [item.id]: item
                 }
             }, {});

             $scope.form = {
                 info: {
                     firstName: 'Pellentesque' ,
                     lastName: 'Fermentum',
                     email: 'facilisis@gmail.com',
                     phone: '0123456789'
                 },
                 services: $scope.services.reduce((result, item) => {
                     return {
                         ...result,
                         [item.id]: {
                             active: false,
                             date: {
                                 startDate: +new Date(),
                                 endDate: +new Date()
                             },
                             employeeId: $scope.employees[0].id
                         }
                     }
                 }, {}),
                 confirm: {
                     term: false,
                     cookie: false
                 }
             }

             $scope.setStep = function(step) {
                 $scope.step = step;
             }

             $scope.nextStep = function() {
                 $scope.setStep(Math.min($scope.step + 1, $scope.maxStep));
             }

             $scope.prevStep = function() {
                 $scope.setStep(Math.max($scope.step - 1, 1));
             }

             $scope.done = function() {
                 console.log($scope.form);
             }

             $scope.validateNext = function() {
                 return $scope.step === $scope.maxStep;
             }

             $scope.disableNext = function(form, step=$scope.step) {
                 switch (step) {
                     case 1: {
                         return !(form.firstName.$valid && form.lastName.$valid && form.phone.$valid && form.email.$valid)
                     }

                     case 2: {
                         return Object.values($scope.form.services).every(item => !item.active);
                     }

                     case 3: {
                         return false;
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
