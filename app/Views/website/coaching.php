<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?php echo asset('website_assets/img/favicon.ico'); ?>" />
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('website_assets/css/app.css'); ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo asset('boostpanel_assets/bower_components/select2/dist/css/select2.min.css'); ?>">
    <title>Coaching — Kattboost</title>
</head>
<body>

<header class="header_coaching text-center">
    <div class="layer">
        <div class="container">
            <div class="header-header">
                <a href="<?php echo App\Router\Router::url('home'); ?>">
                    <img src="<?php echo asset('website_assets/img/logo.png'); ?>" class="logo" alt="L9 ELO BOOSTING LOGO">
                </a>
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('home'); ?>">Home</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('home'); ?>#why_choose_us">Why choose us</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('our-services'); ?>">Our services <span class="sr-only">(current)</span></a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('order-now'); ?>">Order now</a>
                            <a class="nav-item nav-link active" href="<?php echo App\Router\Router::url('coaching'); ?>">Coaching</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('our-team'); ?>">Our team</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('faq'); ?>">FAQ</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('contact'); ?>">Contact us</a>
                            <a class="nav-item nav-link" href="<?php echo App\Router\Router::url('join-our-team'); ?>">Join our team</a>
                            <a class="nav-item nav-link nav-pink" href="<?php echo App\Router\Router::url('login.show'); ?>">Login</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="header-content">
                <h1 class="header-page-title">coaching</h1>
            </div>
        </div>
    </div>
</header><!-- /header -->

<section class="black">
    <div class="container text-center">
        <h1 class="section-h1-pink">WHY WOULD YOU GET A COACH?</h1>

        <p>Coaches work by analyzing your gameplay and being able to show you your mistakes so you can avoid them in the future.</p>
        <p>They also help you understand the objective of the game better, how to work towards a victory and becoming a better player.</p>
        <p>Getting a coach is the easiest way to improve over a short period of time.</p>
        <p>The more you work with your coach, the more you will see improvements and success.</p>
        <p>It doesn't improve overnight</p>
        <br><br>
        <p>HOWEVER...</p>
        <br><br>
        <p>Our team of Boosters and Coaches could make a difference in your gameplay even with just one hour with us!</p>
        <p>See more reviews of customers that bought from us in our discord!</p>

        <h1 class="section-h1-pink">HOW DOES OUR COACHING WORK?</h1>
        <p>You select your Desired Coaching Level , at a Masters Level or Challenger Level or even Specific with Famous Streamers / Coaches like Tarzaned , ZWAG , KatEvolved.</p>
        <p>Select your amount of Hours of Coaching and you will be prompted to enter your specific role request and the date you want the coaching to be completed by.</p>
        <p>After your order is processed, wait for your coach to message you to set up time.</p>

        <div class="coach_select">
            <h3 class="section-h3-blue">Tarzaned Coaching</h3>
            <p id="special_coach_price">from $80.00</p>
            <p>Live gameplay or VOD review from Season 6 Rank 1 player : Tarzaned</p>
            <div class="form-group">
                <select id="special_coach" class="form-control">
                    <option value="">Select Amount of Coaching</option>
                    <option value="1">60-90 Minutes</option>
                    <option value="2">120-180 Minutes</option>
                    <option value="3">180-270 Minutes</option>
                    <option value="4">240-360 Minutes</option>
                    <option value="5">300-450 Minutes</option>
                    <option value="1.25">VOD REVIEW 60-90 Minutes</option>
                    <option value="2.50">VOD REVIEW 120-180 Minutes</option>
                    <option value="3.75">VOD REVIEW 180-270 Minutes</option>
                </select>
            </div>
        </div>

        <div class="coach_select">
            <h3 class="section-h3-blue">Challenger Coaching</h3>
            <p id="challenger_coach_price">from $25.00</p>
            <p>Coaching from a verified Challenger Booster/Player.</p>
            <div class="form-group">
                <select id="challenger_coach" class="form-control">
                    <option value="">Select Amount of Coaching</option>
                    <option value="1">1 Hour</option>
                    <option value="2">2 Hours</option>
                    <option value="3">3 Hours</option>
                    <option value="4">4 Hours</option>
                    <option value="5">5 Hours</option>
                </select>
            </div>
        </div>

        <div class="coach_select">
            <h3 class="section-h3-blue">Master Coaching</h3>
            <p id="master_coach_price">from $20.00</p>
            <p>Coaching from a verified Master Booster/Player.</p>
            <div class="form-group">
                <select id="master_coach" class="form-control">
                    <option value="">Select Amount of Coaching</option>
                    <option value="1">1 Hour</option>
                    <option value="2">2 Hours</option>
                    <option value="3">3 Hours</option>
                    <option value="4">4 Hours</option>
                    <option value="5">5 Hours</option>
                </select>
            </div>
        </div>

        <label for="terms_services" style="margin-bottom: 35px">
            <input type="checkbox" id="terms_services">
            I agree to terms and services
        </label>
        <br>
        <a href="" data-toggle="modal" id="lets_go" data-target="#modal-set-order" class="button button-sm" style="display: none;">Let's go !</a>
    </div>
</section>

<section class="pink">
    <div class="container text-center">
        <a href="<?php echo App\Router\Router::url('terms-of-services'); ?>" class="button button-sm button-pink">Terms of services</a>
        <h3 style="margin-top: 50px;">KATTBOOST</h3>
        <p>League of Legends is a registered trademark of Riot Games, Inc. We are in no way affiliated with, associated with or endorsed by Riot Games, Inc.</p>
        <br>
        <br>
        <p class="text-left">2017-2018 Kattboostf | ALL RIGHTS RESERVED</p>
    </div>
</section>

<div class="modal fade" id="modal-set-order" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modal-title"></h4>
            </div>
            <div class="modal-body text-center">
                <div class="form-group">
                    <label>Current league</label>
                    <select id="current_league" class="form-control">
                        <option value="Bronze">Bronze</option>
                        <option value="Silver">Silver</option>
                        <option value="Gold" selected>Gold</option>
                        <option value="Platinum">Platinum</option>
                        <option value="Diamond">Diamond</option>
                        <option value="Master">Master</option>
                        <option value="Challenger">Challenger</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Current division</label>
                    <select id="current_division" class="form-control">
                        <option value="V">V</option>
                        <option value="IV">IV</option>
                        <option value="III">III</option>
                        <option value="II" selected>II</option>
                        <option value="I">I</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Prefered Positions</label>
                    <select id="prefered_positions" class="form-control select2" multiple="multiple" style="width: 100%">
                        <?php
                        $positions = [
                            'top',
                            'jungle',
                            'mid',
                            'bot',
                            'support'
                        ];
                        foreach ($positions as $position):
                            ?>
                            <option value="<?php echo $position; ?>"><?php echo $position; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Your server</label>
                    <select id="server" class="form-control">
                        <?php
                        foreach (\App\Config::SERVERS as $server):
                            ?>
                        <?php if ($server === "NA"): ?>
                            <option value="<?php echo $server; ?>" selected><?php echo $server; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $server; ?>"><?php echo $server; ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                <a class="btn btn-primary" id="submit_order">Pay</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '0c16e816-4dde-41ce-b314-5147fd52f1f7', f: true }); done = true; } }; })();</script>

<script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="<?php echo asset('boostpanel_assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
<script>
    // Modal data
    var selectedPreferedPositions = [];
    $('#prefered_positions').on('select2:select', function() {
        $.each($("#prefered_positions").select2('data'), function (key, item) {
            selectedPreferedPositions.indexOf(item.text) === -1 ? selectedPreferedPositions.push(item.text) : null;
        });
    });

    $('#prefered_positions').on('select2:unselect', function (e) {
        var index = selectedPreferedPositions.indexOf(e.params.data.text);
        if (index !== -1) selectedPreferedPositions.splice(index, 1);
    });

    var current_league = $('#current_league :selected').val();
    $('#current_league').on('change', function () {
        current_league = this.value;
    });

    var current_division= $('#current_division :selected').val();
    $('#current_division').on('change', function () {
        current_division = this.value;
    });

    var server = $('#server :selected').val();
    $('#server').on('change', function () {
        server = this.value;
    });

    var total_price = 0;
    var order_text = "";


    /**
     * Check terms of services make appear the button "lets go"
     */
    $(function() {
        var chk = $('#terms_services');

        chk.click(function() {
            if( $(this).is(':checked') ){
                document.getElementById('lets_go').style["display"] = "initial";
            }else{
                document.getElementById('lets_go').style["display"] = "none";
            }
        });
    });

    /**
     * Round a number with 2 digit
     * @param number
     * @returns number
     */
    var roundNumber = function (number) {
        return (Math.round(parseFloat(number) * 100) / 100).toFixed(2);
    };

    /**
     * Hide others coachers
     */
    var hideOthers = function (selected_coach) {
        // Get parent class
        var coacher_div = selected_coach.parent().parent();

        // Make others coacher disapear
        $('.coach_select').each(function () {
            if (!$(this).is(coacher_div)) {
                $(this).fadeOut('slow');
            }
        });
    };

    /**
     * Show all the coachers
     */
    var showAll = function () {
        $('.coach_select').each(function () {
            $(this).fadeIn('slow');
        });
    };

    /**
     * Set up the payment and the frontend
     * @param default_price
     * @param select_id
     */
    var setPayment = function (default_price, select_id) {
        $('#' + select_id).on('change', function () {
            // Get data
            var value = this.value;
            var text = $(this).parent().parent().find('h3').html() + " " + $(this).find("option:selected").text();
            var price = roundNumber(default_price);

            // Show data
            var el = $('#' + select_id + '_price');
            if (value === "") {
                el.html('from $' + price);
                showAll();
                total_price = 0;
                order_text = "";
                server = "";
            } else {
                price = value * price;
                el.html('$' + roundNumber(price));
                hideOthers($(this));
                order_text = text;
                total_price = price;
            }

        });
    };

    $('#submit_order').on('click', function () {
        if (total_price > 0 && order_text !== "") {
            var url = '<?php echo App\Router\Router::url('paypal_payment'); ?>?custom=' +
                order_text + '||0|' + total_price + '|USD|' + server + '|' +
                current_league + '|' + current_division + '||||||||' +
                selectedPreferedPositions +'|||false';
            window.location.replace(url);
        }
    });

    setPayment(80, 'special_coach');
    setPayment(25, 'challenger_coach');
    setPayment(20, 'master_coach');

    //Initialize Select2 Elements
    $('.select2').select2()

</script>
</body>
</html>