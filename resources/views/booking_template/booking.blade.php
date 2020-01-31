<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Booking Services</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="booking_template_asset/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
        <!-- STYLE CSS -->
        <link rel="stylesheet" href="booking_template_asset/css/style.css">
        <!-- DATE-PICKER -->
        <link rel="stylesheet" href="booking_template_asset/vendor/date-picker/css/datepicker.min.css">
	</head>

	<body>
		<div class="wrapper">
            <form action="" id="wizard">
        		<!-- SECTION 1 -->
                <h4></h4>
                <section>
                    <h3>Welcome to Lash</h3>
                	<div class="form-row">
<!--                        <div class="form-holder">-->
<!--                            <i class="zmdi zmdi-account"></i>-->
<!--                            <input type="text" class="form-control" placeholder="First Name">-->
<!--                        </div>-->
                        <div class="form-holder">
                            <i class="zmdi zmdi-smartphone-android"></i>
                            <input type="text" class="form-control" placeholder="Phone Number">
                        </div>
                        <div class="form-holder">
                            <i class="zmdi zmdi-account"></i>
                            <input type="text" class="form-control" placeholder="Your Name">

                        </div>


                	</div>


<!--                    <div class="form-row">-->
<!--                        <div class="form-holder">-->
<!--                            <i class="zmdi zmdi-email"></i>-->
<!--                            <input type="text" class="form-control" placeholder="Email ID">-->
<!--                        </div>-->
<!--                        <div class="form-holder">-->
<!--                            <i class="zmdi zmdi-account-box-o"></i>-->
<!--                            <input type="text" class="form-control" placeholder="Your User ID">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-row">-->
<!--                        <div class="form-holder">-->
<!--                            <i class="zmdi zmdi-map"></i>-->
<!--                            <input type="text" class="form-control" placeholder="Country">-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <div class="form-holder">-->
<!--                                <i class="zmdi zmdi-pin"></i>-->
<!--                                <input type="text" class="form-control" placeholder="State">-->
<!--                            </div>-->
<!--                            <div class="form-holder">-->
<!--                                <i class="zmdi zmdi-pin-drop"></i>-->
<!--                                <input type="text" class="form-control" placeholder="City">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                </section>

				<!-- SECTION 2 -->
                <h4></h4>
                <section>
                	<h3>Outstanding services ready for you</h3>
                    <div class="form-row">

                        <div class="form-holder">
                            <input type="text" class="form-control datepicker-here pl-85" data-language="en" data-date-format="dd - m - yyyy" id="dp1">


                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-holder w-100">
                            <input type="password" class="form-control" placeholder="Enter the Current Password">
                            <i class="zmdi zmdi-lock-open"></i>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder w-100">
                            <input type="password" class="form-control" placeholder="New Password">
                            <i class="zmdi zmdi-lock-open"></i>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder w-100">
                            <input type="password" class="form-control" placeholder="Confirm New Password">
                            <i class="zmdi zmdi-lock-open"></i>
                        </div>
                    </div>
                </section>

                <!-- SECTION 3 -->
                <h4></h4>
                <section>
                    <h3 style="margin-bottom: 16px;">My Cart</h3>



                </section>

                <!-- SECTION 4 -->
                <h4></h4>
                <section>
                    <h3>Cart Totals</h3>
                    <div class="cart_totals">
                        <table cellspacing="0" class="shop_table shop_table_responsive">
                            <tr class="cart-subtotal">
                                <th>Subtotal</th>
                                <td data-title="Subtotal">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">$</span>110.00
                                    </span>
                                </td>
                            </tr>
                            <tr class="cart-subtotal shipping">
                                <th>Shipping:</th>
                                <td data-title="Subtotal">
                                    <div class="checkbox">
                                        <label>
                                            <input type="radio" name="shipping" checked> Free Shipping
                                            <span class="checkmark"></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="shipping"> Local pickup: <span>$</span><span>0.00</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <span>Calculate shipping</span>
                                </td>
                            </tr>
                            <tr class="cart-subtotal">
                                <th>Service <span>(estimated for Vietnam)</span></th>
                                <td data-title="Subtotal">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">$</span>5.60
                                    </span>
                                </td>
                            </tr>
                            <tr class="order-total border-0">
                                <th>Total</th>
                                <td data-title="Total">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">$</span>64.69
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                </section>


<!--                <--- Section 5---->
                <h4></h4>
                <section>
                    <h3>Cart Totals 3333333333333</h3>
                    <div class="cart_totals">
                        <table cellspacing="0" class="shop_table shop_table_responsive">
                            <tr class="cart-subtotal">
                                <th>Subtotal</th>
                                <td data-title="Subtotal">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">$</span>110.00
                                    </span>
                                </td>
                            </tr>
                            <tr class="cart-subtotal shipping">
                                <th>Shipping:</th>
                                <td data-title="Subtotal">
                                    <div class="checkbox">
                                        <label>
                                            <input type="radio" name="shipping" checked> Free Shipping
                                            <span class="checkmark"></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="shipping"> Local pickup: <span>$</span><span>0.00</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <span>Calculate shipping</span>
                                </td>
                            </tr>
                            <tr class="cart-subtotal">
                                <th>Service <span>(estimated for Vietnam)</span></th>
                                <td data-title="Subtotal">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">$</span>5.60
                                    </span>
                                </td>
                            </tr>
                            <tr class="order-total border-0">
                                <th>Total</th>
                                <td data-title="Total">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">$</span>64.69
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                </section>
            </form>
            <div class="form-group">
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                <label for="agree-term" class="label-agree-term"><span><span></span></span>I have read and understand the  <a href="/terms" class="term-service" target="_blank">Privacy Policy</a></label>
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                <label for="agree-term" class="label-agree-term"><span><span></span></span>I have read and agree to the  <a href="/terms" class="term-service" target="_blank">Terms Of Use </a></label> and <a href="/terms" class="term-service" target="_blank">Cookies Policy</a></label>
            </div>
		</div>




        <script src="booking_template_asset/vendor/js/datepicker.js"></script>
        <script src="booking_template_asset/vendor/js/datepicker.en.js"></script>




        <script src="booking_template_asset/js/jquery-3.3.1.min.js"></script>



        <!-- JQUERY STEP -->
        <script src="booking_template_asset/js/jquery.steps.js"></script>
        <script src="booking_template_asset/js/main.js"></script>


</body>
</html>
