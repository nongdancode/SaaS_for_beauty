$(function(){
	$("#wizard").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        transitionEffectSpeed: 300,
        labels: {
            next: "Continue",
            previous: "Back",
            finish: 'Proceed to checkout',


        },
        onStepChanging: function (event, currentIndex, newIndex) {
            if ( newIndex >= 1 ) {
                $('.steps ul li:first-child a img').attr('src','booking_template_asset/images/051-aromatherapy.png');
            } else {
                $('.steps ul li:first-child a img').attr('src','booking_template_asset/images/051-bamboo.png');
            }

            if ( newIndex === 1 ) {
                $('.steps ul li:nth-child(2) a img').attr('src','booking_template_asset/images/051-bathrobe.png');
            } else {
                $('.steps ul li:nth-child(2) a img').attr('src','booking_template_asset/images/051-branch.png');
            }

            if ( newIndex === 2 ) {
                $('.steps ul li:nth-child(3) a img').attr('src','booking_template_asset/images/051-candles.png');
            } else {
                $('.steps ul li:nth-child(3) a img').attr('src','booking_template_asset/images/051-cardiogram.png');
            }

            if ( newIndex === 3 ) {
                $('.steps ul li:nth-child(4) a img').attr('src','booking_template_asset/images/051-cream.png');
                $('.actions ul').addClass('step-4');
            } else {
                $('.steps ul li:nth-child(4) a img').attr('src','booking_template_asset/images/051-diet.png');
                $('.actions ul').removeClass('step-4');
            }
            return true;
        }
    });

    // Custom Button Jquery Steps
    $('.forward').click(function(){

    	$("#wizard").steps('next');
    })
    $('.backward').click(function(){
        $("#wizard").steps('previous');
    })
    // Click to see password
    $('.password i').click(function(){
        if ( $('.password input').attr('type') === 'password' ) {
            $(this).next().attr('type', 'text');
        } else {
            $('.password input').attr('type', 'password');
        }
    })

    // Create Steps Image
    $('.steps ul li:first-child').append('<img src="booking_template_asset/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="booking_template_asset/images/051-aromatherapy.png" alt=""> ').append('<span class="step-order">Step 01</span>');
    $('.steps ul li:nth-child(2)').append('<img src="booking_template_asset/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="booking_template_asset/images/051-bathrobe.png" alt="">').append('<span class="step-order">Step 02</span>');
    $('.steps ul li:nth-child(3)').append('<img src="booking_template_asset/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="booking_template_asset/images/051-candles.png" alt="">').append('<span class="step-order">Step 03</span>');
    $('.steps ul li:nth-child(4)').append('<img src="booking_template_asset/images/step-arrow.png" alt="" class="step-arrow">').find('a').append('<img src="booking_template_asset/images/051-cream.png" alt="">').append('<span class="step-order">Step 04</span>');

    $('.steps ul li:last-child a').append('<img src="booking_template_asset/images/051-mask.png" alt="" >').append('<span class="step-order">Step 05</span>');
    // Count input


    $(".quantity span").on("click", function() {

        var $button = $(this);
        var oldValue = $button.parent().find("input").val();

        if ($button.hasClass('plus')) {
          var newVal = parseFloat(oldValue) + 1;
        } else {
           // Don't allow decrementing below zero
          if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
            } else {
            newVal = 0;
          }
        }
        $button.parent().find("input").val(newVal);
    });
    var dp1 = $('#dp1').datepicker().data('datepicker');
    dp1.selectDate(new Date());
    var dp2 = $('#dp2').datepicker().data('datepicker');
    dp2.selectDate(new Date());
    var dp3 = $('#dp3').datepicker().data('datepicker');
    dp3.selectDate(new Date());
    var dp4 = $('#dp4').datepicker().data('datepicker');
    dp4.selectDate(new Date());

    // Select Dropdown
    $('html').click(function() {
        $('.select .dropdown').hide();
    });
    $('.select').click(function(event){
        event.stopPropagation();
    });
    $('.select .select-control').click(function(){
        $(this).parent().next().toggle();
    })
    $('.select .dropdown li').click(function(){
        $(this).parent().toggle();
        var text = $(this).attr('rel');
        $(this).parent().prev().find('div').text(text);
    })

})


