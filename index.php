<?php 
require 'vendor/autoload.php';
require 'helpers.php';
use App\Router\Router;
use App\Library\Session\Session;
use App\Config;

Session::start();
Router::init();


/**
 * Ici sont définis les routes de notre application
 * 
 * LES ROUTES LES PLUS PRECISES AVANT LES ROUTES LES MOINS LES PRECISES
 * Router::get('/posts/{slug}-{id}') avant
 * Router::get('/posts/{id}')
 **/

Router::get('/', 'PageController@home', 'home');
Router::get('/terms-of-services', 'PageController@terms_of_services', 'terms-of-services');
Router::get('/our-services', 'PageController@our_services', 'our-services');
Router::get('/our-team', 'PageController@our_team', 'our-team');
Router::get('/faq', 'PageController@faq', 'faq');
Router::get('/contact', 'PageController@contact', 'contact');
Router::post('/contact', 'PageController@postContact', 'post_contact');
Router::get('/join-our-team', 'PageController@join_our_team', 'join-our-team');
Router::post('/join-our-team', 'PageController@post_join_our_team', 'post_join_our_team');
Router::get('/order', 'PageController@order', 'order-now');
Router::get('/coaching', 'PageController@coaching', 'coaching');

Router::post('/price', 'OrderController@getPrice', 'getPrice');

// Paypal routes
Router::get('/payment', 'PaypalController@payment', 'paypal_payment');
Router::get('/pay', 'PaypalController@pay', 'paypal_pay');

/**********************************************************/
/****************** BOOSTPANEL ROUTES *********************/
/**********************************************************/

// Login routes
Router::get('/login', 'LoginController@show', 'login.show');
Router::post('/login', 'LoginController@post', 'login.post');
// Logout route
Router::get('/logout', function () { session_unset(); (new App\Library\Redirect\Redirect)->route('login.show'); }, 'logout');

// Customer routes
Router::get(Config::CUSTOMER, 'CustomerController@show', Config::CUSTOMER);
Router::get(Config::CUSTOMER . '/order/{coach_order}', 'CustomerController@showCoachOrder', 'customer.coachorder');
Router::post(CONFIG::CUSTOMER . '/account_order', 'CustomerController@account_order', 'account_order');

// Admin routes 
Router::get(Config::ADMIN, 'AdminController@show', Config::ADMIN);
Router::get(Config::ADMIN . '/booster/add', 'AdminController@getAddBooster', 'show_add_booster');
Router::post(Config::ADMIN . '/booster/add_user', 'AdminController@postAddUser', 'post_add_user');
Router::post(Config::ADMIN . '/booster/add_booster', 'AdminController@postAddBooster', 'post_add_booster');
Router::post(Config::ADMIN . '/booster/change_percentage', 'AdminController@changePercentage', 'post_change_percentage');
Router::get(Config::ADMIN . "/booster/delete/{id}", 'AdminController@deleteBooster', 'booster_delete');
Router::get(Config::ADMIN . "/booster/edit/{id}", 'AdminController@showEditBooster', 'booster_edit');
Router::post(Config::ADMIN . "/booster/edit/{id}", 'AdminController@editBooster', 'booster.edit.post');
Router::get(Config::ADMIN . "/order/add", 'AdminController@showAddOrder', 'show_add_order');
Router::post(Config::ADMIN . '/order/user/create', 'AdminController@postAddUserOrder', 'post_add_user_order');
Router::post(Config::ADMIN . '/order/create', 'AdminController@postAddOrder', 'post_add_order');
Router::post(Config::ADMIN . '/order/assign', 'AdminController@assignOrder', 'assign_order');
Router::get(Config::ADMIN . '/order/drop/{order_id}', 'AdminController@dropOrder', 'drop_order');
Router::get(Config::ADMIN . '/order/paid/{order_id}', 'AdminController@paidOrder', 'paid_booster');

// Booster routes
Router::get(Config::BOOSTER, 'BoosterController@show', Config::BOOSTER);
Router::get(Config::BOOSTER . '/order/apply/{order_id}', 'BoosterController@applyToOrder', 'apply_to_order');
Router::get(Config::BOOSTER . '/order/details/{order_id}', 'BoosterController@showOrder', 'order');
Router::get(Config::BOOSTER . '/order/finished/{order_id}', 'BoosterController@finishedOrder', 'finished_order');
Router::get(Config::BOOSTER . '/order/drop/{order_id}', 'BoosterController@dropOrder', 'drop_order');

Router::get('/profile', 'ProfileController@show', 'profile');
Router::post('/profile', 'ProfileController@postProfile', 'profile.post');

Router::post('/ChatPoster/{id}', 'ChatController@postMessage', 'ChatPoster');
Router::get('/getMessages/{id}', 'ChatController@getMessages', 'ChatMessages');
Router::get('/countOrders/{servers}', 'OrderController@countOrders', 'countOrders');

/**********************************************************/
/**************** END BOOSTPANEL ROUTES *******************/
/**********************************************************/



Router::run();