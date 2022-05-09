<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace'=>'Front'], function () {
    /*captcha*/
    Route::get('createcaptcha', 'CaptchaController@create');
    Route::post('captcha', 'CaptchaController@captchaValidate');
    Route::get('refreshcaptcha', 'CaptchaController@refreshCaptcha')->name('refreshcaptcha');
    /*end captcha*/
    Route::get('/', 'FrontController@index')->name('indexRoute');
    Route::get('/shop', 'FrontController@shop')->name('shopRoute');
    Route::get('/shop/filter', 'FrontController@shopFilter')->name('shopFilterRoute');
    Route::get('/reward/filter', 'FrontController@rewardFilter')->name('rewardFilterRoute');
    Route::get('/shop/book/{id}', 'FrontController@book')->name('singleBookRoute');
    Route::get('/reward', 'FrontController@reward')->name('rewardRoute');
    Route::get('/reward/{id}', 'FrontController@single_reward')->name('singleRewardRoute');
    Route::get('/reward/cat/{id}', 'FrontController@cat_reward')->name('catRewardRoute');
    Route::get('/reward/cat/ajax/{id}', 'FrontController@ajax_cat_reward')->name('ajaxCatRewardRoute');
    Route::get('/shop/cat/{id}', 'FrontController@cat_shop')->name('showCatShopRoute');
    //Route::get('/shop/cat/ajax/{id}', 'FrontController@ajax_cat_shop')->name('ajaxCatShopRoute');
    Route::post('/shop/cat/ajax', 'FrontController@ajax_cat_shop')->name('ajaxCatShopRoute');
    Route::get('/search/book/', 'FrontController@searchBook')->name('searchBookFrontRoute');
    Route::get('/search/rewardbyname/', 'FrontController@searchRewardByName')->name('searchRewardByNameFrontRoute');
    Route::get('/search/rewardbycoint/', 'FrontController@searchRewardByCoint')->name('searchRewardByCointFrontRoute');
    Route::get('/register/{type}/{id}', 'FrontController@register')->name('registerRoute');
    Route::post('/register', 'FrontController@doRegister')->name('doRegisterRoute');
    Route::get('/register', 'FrontController@register')->name('registerRoute');
    Route::get('/blog', 'FrontController@blog')->name('blogRoute');
    Route::get('/blog/filter', 'FrontController@blogFilter')->name('blogFilterRoute');
    Route::get('/blog/{slug}', 'FrontController@single_blog')->name('singleBlogRoute');
    Route::get('/blog/cat/{id}', 'FrontController@cat_blog')->name('catBlogRoute');
    Route::get('/blog/cat/ajax/{id}', 'FrontController@ajax_cat_blog')->name('ajaxCatBlogRoute');
    Route::get('/search/blogbyname/', 'FrontController@searchBlogByName')->name('searchBlogByNameFrontRoute');
    Route::post('/insert_comment_book', 'FrontController@insert_comment_book')->name('insertCommentBookRoute');
    Route::post('/insert_comment_reward', 'FrontController@insert_comment_reward')->name('insertCommentRewardRoute');
    Route::post('/insert_comment_blog', 'FrontController@insert_comment_blog')->name('insertCommentBlogRoute');
    /*    Route::post('/register', 'FrontController@doRegister')->name('doRegisterRoute');*/
    Route::get('/retrieve_password', 'FrontController@retrievePassword')->name('retrievePasswordRoute');
    Route::post('/retrieve_password', 'FrontController@postRetrievePassword')->name('postRetrievePasswordRoute');
    Route::get('/confirm_password', 'FrontController@confirm_password')->name('confirmPasswordRoute');
    Route::post('/confirm_password', 'FrontController@post_confirm_password')->name('postConfirmPasswordRoute');
    Route::get('/about', 'FrontController@about')->name('frontAboutRoute');
    Route::get('/contact', 'FrontController@contact')->name('frontContactRoute');
    Route::post('/contact', 'FrontController@postContact')->name('postContactRoute');
    Route::get('/onlinequiz', 'FrontController@quizCode')->name('QuizCodeRoute');

    /*cart basket*/
    Route::get('/cart', 'FrontController@cart')->name('cartRoute');
    Route::post('/cart/add', 'FrontController@addCart')->name('addCartRoute');
    Route::post('/cart/update', 'FrontController@updateCart')->name('updateCartRoute');
    Route::post('/cart/update/ajax', 'FrontController@ajaxUpdateCart')->name('ajaxUpdateCartRoute');
    Route::post('/cart/remove', 'FrontController@removeCart')->name('removeCartRoute');
    Route::post('/cart/clear', 'FrontController@clearCart')->name('clearCartRoute');
    Route::post('/cart/discount', 'FrontController@ajaxUpdateDiscountPrice')->name('ajaxUpdateDiscountPriceRoute');



    Route::get('/shipping', 'FrontController@shipping')->name('shippingRoute');
    /*end cart basket*/


    Route::get('/login', 'FrontController@login')->name('userLoginRoute');
    Route::post('/login', 'FrontController@doLogin')->name('userDoLoginRoute');
    Route::post('/fastLogin/{book_id}', 'FrontController@doFastLogin')->name('userDoFastLoginRoute');
    Route::post('/fastRegister/{book_id}', 'FrontController@doFastRegister')->name('doFastRegisterRoute');
    Route::post('/fastLoginReward/{reward_id}', 'FrontController@doFastLoginReward')->name('userDoFastLoginRewardRoute');
    Route::post('/fastLoginQuiz', 'FrontController@doFastLoginQuiz')->name('userDoFastLoginQuizRoute');
    Route::post('/fastLogin/{book_id}', 'FrontController@doFastLogin')->name('userDoFastLoginRoute');
    Route::get('/logout', 'FrontController@logout')->name('userLogoutRoute');

    Route::get('/adminAccess/login', 'FrontController@AdminLogin')->name('AdminLoginRoute');
    Route::post('/adminAccess/loginPost', 'FrontController@PostAdminLogin')->name('PostAdminLoginRoute');
});
Route::group(['namespace'=>'User'], function () {
    Route::post('/onlinequiz/post', 'UserController@checkQuizCode')->name('checkQuizCodeRoute');
    Route::get('/panel', 'UserController@dashboard')->name('userDashboardRoute');
    Route::get('/quiz/{code_id}', 'UserController@quiz')->name('QuizRoute');
    Route::get('/match/{id}', 'UserController@match')->name('matchRoute');
    Route::post('/match/post', 'UserController@matchSubmit')->name('matchSubmitRoute');
    Route::get('/checkout/{book_id}', 'UserController@checkout')->name('checkoutRoute');
    Route::post('/checkout/priceTotal', 'UserController@ajaxGetPriceCity')->name('ajaxGetPriceCity');
    Route::get('/checkoutReward/{reward_id}', 'UserController@rewardCheckout')->name('rewardCheckoutRoute');
    Route::post('/submitOrders', 'UserController@submitOrder')->name('submitOrderRoute');
    Route::get('/showPayment', 'UserController@order')->name('showPaymentRoute');
    Route::get('/panel/profile', 'UserController@profile')->name('profileUserDashboardRoute');
    Route::post('/panel/profile', 'UserController@postProfile')->name('postProfileUserDashboardRoute');
    Route::post('/panel/profileAjax', 'UserController@postProfileAjax')->name('postProfileAjaxUserDashboardRoute');
    Route::get('/panel/order', 'UserController@order_user')->name('orderUserDashboardRoute');
    Route::get('/panel/match', 'UserController@matchUser')->name('matcUserDashboardRoute');
    Route::get('/panel/award', 'UserController@awardUser')->name('awardUserDashboardRoute');
    Route::get('/panel/coin', 'UserController@showCoin')->name('showCoinRoute');
    Route::get('/panel/changeCoin', 'UserController@changeCoin')->name('changeCoinRoute');
    Route::post('/panel/changeCoin/post', 'UserController@changeCoinSubmit')->name('changeCoinSubmitRoute');
    Route::post('/buy_reward/{id}', 'UserController@buy_reward')->name('buyRewardRoute');
    Route::get('/discounter', 'UserController@discounter')->name('discounterRoute');
});
Route::group(['prefix'=>'adminDashboard','namespace'=>'Admin'], function () {
    Route::get('/', 'DashboardController@dashboard')->name('adminDashboardRoute');
    Route::get('/report', 'DashboardController@report')->name('adminReportRoute');
    Route::post('/report', 'DashboardController@postReport')->name('adminPostReportRoute');
    Route::get('/message', 'DashboardController@message')->name('messageRoute');
    /*Code*/
    Route::get('/code','DashboardController@codes')->name('codeRoute');
    Route::get('/code_new','DashboardController@codesNew')->name('codeNewRoute');
//   Route::get('//post','DashboardController@get_codes_by_prefix')->name('codeByPrefixRoute');
    Route::post('/code/post', 'DashboardController@insert_code')->name('insertCodeRoute');
    Route::post('/code/print', 'DashboardController@print_code')->name('printCodeRoute');
    /*End Code*/
    /*Slide*/
    Route::get('/slider/add', 'DashboardController@add_slider')->name('addSliderRoute');
    Route::post('/slider/add', 'DashboardController@insert_slider')->name('insertSliderRoute');
    Route::get('/slider', 'DashboardController@slider')->name('sliderRoute');
    Route::get('/deleteSlider/{id}', 'DashboardController@delete_slider')->name('deleteSliderRoute');

    /*end Slider*/

    /*shop Slide*/
    Route::get('/shopslider/add', 'DashboardController@add_shopslider')->name('addShopSliderRoute');
    Route::post('/shopslider/add', 'DashboardController@insert_shopslider')->name('insertShopSliderRoute');
    Route::get('/shopslider', 'DashboardController@shop_slider')->name('ShopSliderRoute');
    Route::get('/deleteshopslider/{id}', 'DashboardController@delete_shopslider')->name('deleteShopSliderRoute');

    /*end shop Slider*/
    
    
    
    /*discount*/
    
    Route::get('/discount', 'DashboardController@discount')->name('discountRoute');
    Route::get('/discount/add', 'DashboardController@add_discount')->name('addDiscountrRoute');
    Route::post('/discount/add', 'DashboardController@insert_discount')->name('insertDiscountRoute');
    Route::get('/discount/edit/{id}', 'DashboardController@edit_discount')->name('editDiscountRoute');
    Route::post('/discount/update/{id}', 'DashboardController@update_discount')->name('updateDiscountRoute');
    Route::get('/deletediscount/{id}', 'DashboardController@delete_discount')->name('deleteDiscountRoute');
    
    
    /*end discount*/

    /*reward*/
    Route::get('/reward/add', 'DashboardController@add_reward')->name('addRewardRoute');
    Route::post('/reward/add', 'DashboardController@insert_reward')->name('insertRewardRoute');
    Route::get('/reward', 'DashboardController@reward')->name('adminRewardRoute');
    Route::get('/reward/edit/{id}', 'DashboardController@edit_reward')->name('editRewardRoute');
    Route::post('/reward/update/{id}', 'DashboardController@update_reward')->name('updateRewardRoute');
    Route::get('/deleteReward/{id}', 'DashboardController@delete_reward')->name('deleteRewardRoute');

    /*end reward*/

    /*Quiz*/
    Route::get('/quiz', 'DashboardController@quiz')->name('quizRoute');
    Route::get('/quiz/add', 'DashboardController@add_quiz')->name('addQuizRoute');
    Route::post('/quiz/post', 'DashboardController@insert_quiz')->name('insertQuizRoute');
    Route::get('/quiz/edit/{id}', 'DashboardController@edit_quiz')->name('editQuizRoute');
    Route::post('/quiz/edit/{id}', 'DashboardController@update_quiz')->name('updateQuizRoute');
    Route::get('/quiz/delete/{id}', 'DashboardController@delete_quiz')->name('deleteQuizRoute');
    /*End Quiz*/
    /*book cat*/
    Route::get('/bookcategory', 'DashboardController@category')->name('categoryRoute');
    Route::get('/bookcategory/add', 'DashboardController@add_category')->name('addCategoryRoute');
    Route::post('/bookcategory/add', 'DashboardController@insert_category')->name('insertCategoryRoute');
    Route::get('/bookcategory/edit/{id}', 'DashboardController@edit_category')->name('editCategoryRoute');
    Route::post('/bookcategory/edit/{id}', 'DashboardController@update_category')->name('updateCategoryRoute');
    Route::get('/bookcategory/delete/{id}', 'DashboardController@delete_category')->name('deleteCategoryRoute');
    /*end book cat*/

    /*reward cat*/
    Route::get('/rewardcategory', 'DashboardController@rewardcategory')->name('rewardCategoryRoute');
    Route::get('/rewardcategory/add', 'DashboardController@add_rewardcategory')->name('addRewardCategoryRoute');
    Route::post('/rewardcategory/add', 'DashboardController@insert_rewardcategory')->name('insertRewardCategoryRoute');
    Route::get('/rewardcategory/edit/{id}', 'DashboardController@edit_rewardcategory')->name('editRewardCategoryRoute');
    Route::post('/rewardcategory/edit/{id}', 'DashboardController@update_rewardcategory')->name('updateRewardCategoryRoute');
    Route::get('/rewardcategory/delete/{id}', 'DashboardController@delete_rewardcategory')->name('deleteRewardCategoryRoute');
    /*end reward cat*/

    /* question route */

    Route::get('/question/add', 'DashboardController@add_question')->name('addQuestionRoute');
    Route::post('/question/add', 'DashboardController@insert_question')->name('insertQuestionRoute');
    Route::get('/question', 'DashboardController@question')->name('questionRoute');
    Route::get('/deleteQuestion/{id}', 'DashboardController@delete_question')->name('deleteQuestionRoute');
    Route::get('/question/edit/{id}', 'DashboardController@edit_question')->name('editQuestionRoute');
    Route::post('/editQuestion/{id}', 'DashboardController@update_question')->name('updateQuestionRoute');

    /* question route */

    /* order route */

   // Route::get('order/{id}', 'DashboardController@orders')->name('indexidRoute');
    Route::get('order/', 'DashboardController@orders')->name('orderRoute');
    Route::get('/deleteOrder/{id}', 'DashboardController@delete_order')->name('deleteOrderRoute');
    Route::get('/order/edit/{id}', 'DashboardController@edit_order')->name('editOrderRoute');
    Route::post('/editOrder/{id}', 'DashboardController@update_order')->name('updateOrderRoute');

    /* order route */

    /* book route */
    Route::get('/book/add', 'DashboardController@add_book')->name('addBookRoute');
    Route::post('/book/add', 'DashboardController@insert_book')->name('insertBookRoute');
    Route::get('/book', 'DashboardController@book')->name('bookRoute');
    Route::get('/deletebook/{id}', 'DashboardController@delete_book')->name('deleteBookRoute');
    Route::get('/book/edit/{id}', 'DashboardController@edit_book')->name('editBookRoute');
    Route::post('/editbook/{id}', 'DashboardController@update_book')->name('updateBookRoute');
    /* book route */

    /*contact us*/
    Route::get('/contact', 'DashboardController@contact_us')->name('contactRoute');
    Route::get('/contact/details/{id}', 'DashboardController@contact_detail')->name('contactDetailsRoute');
    Route::get('/contact/delete/{id}', 'DashboardController@contact_delete')->name('contactDeleteRoute');
    /*end contact us*/
    /*request money*/
    Route::get('/request_money', 'DashboardController@request_money')->name('adminRequestMoneyRoute');
    Route::get('/request_money/{id}', 'DashboardController@request_money_details')->name('adminRequestMoneyDetailsRoute');
    Route::get('/request_money/changeState/{id}', 'DashboardController@request_money_change_state')->name('adminRequestMoneyChangeStateRoute');
    Route::get('/request_money/delete/{id}', 'DashboardController@request_money_delete')->name('adminRequestMoneyDeleteRoute');
    /*end request money*/
    Route::get('/setting', 'DashboardController@setting')->name('adminSettingRoute');
    Route::post('/setting', 'DashboardController@setting_post')->name('adminPostSettingRoute');
    Route::get('/homesetting', 'DashboardController@home_setting')->name('adminHomeSettingRoute');
    Route::post('/homesetting', 'DashboardController@home_setting_post')->name('adminHomePostSettingRoute');
    Route::post('/changeCoverImage', 'DashboardController@changeCoverImage')->name('changeCoverImageDashboardRoute');

    Route::get('/request_reward', 'DashboardController@request_reward')->name('adminRequestRewardRoute');
    Route::get('/request_reward/{id}', 'DashboardController@request_reward')->name('adminRequestReward2Route');
    Route::get('/request_reward/changeState/{id}', 'DashboardController@request_reward_change_state')->name('adminRequestRewardChangeStateRoute');
    Route::get('/request_single_reward/{id}', 'DashboardController@request_reward_single')->name('adminRequestRewardSingleRoute');
    Route::get('/request_reward/delete/{id}', 'DashboardController@request_reward_delete')->name('adminRequestRewardDeleteRoute');
    Route::get('/logout', 'DashboardController@logout')->name('adminLogoutRoute');

    //saeed
    Route::get('/usersList', 'DashboardController@usersList')->name('usersListRoute');
    Route::get('/useredit/{id}', 'DashboardController@userEdit')->name('usersEditRoute');
    Route::post('/userupdate/', 'DashboardController@userUpdate')->name('usersUpdateRoute');
    Route::get('/userBooks/{id}', 'DashboardController@userBooks')->name('userBooksRoute');
    Route::get('/userRewards/{id}', 'DashboardController@userRewards')->name('userRewardsRoute');
    Route::get('/searchUser', 'DashboardController@searchUser')->name('searchUserRoute');
    Route::get('/searchBook', 'DashboardController@searchBook')->name('searchBookRoute');
    Route::get('/findIntroduced/{id}', 'DashboardController@findIntroduced')->name('findIntroducedRoute');
    Route::get('/searchCode', 'DashboardController@searchCode')->name('searchCodeRoute');
    //saeed

    /* Start Post Routs */
        Route::get('/posts', 'DashboardController@listPosts')->name('dashboardListPosts');
        Route::get('/post/add', 'DashboardController@addPost')->name('addPost');
        Route::post('/post/insert', 'DashboardController@insertPost')->name('insertPost');
        Route::post('/post/ckeditor/upload', 'DashboardController@upload_image_cke')->name('ckeditor.upload');
        Route::get('/post/edit/{id}', 'DashboardController@editPost')->name('editPost');
        Route::post('/post/update', 'DashboardController@updatePost')->name('updatePost');
        Route::post('/post/delete', 'DashboardController@deletePost')->name('deletePost');
        // CKE uploader
    /* End Post Routs */


    /* Start Comment Routs */
    Route::get('/comments/books', 'DashboardController@listCommentsBooks')->name('dashboardListCommentsBooks');
    Route::get('/comments/posts', 'DashboardController@listCommentsPosts')->name('dashboardListCommentsPosts');
    Route::get('/comments/reward', 'DashboardController@listCommentsRewards')->name('dashboardListCommentsRewards');
    Route::get('/comment/edit/{id}', 'DashboardController@editComment')->name('editComment');
    Route::get('/comment/change_comment_read_state/{id}', 'DashboardController@change_comment_read_state')->name('change_comment_read_state');
    Route::post('/comment/update', 'DashboardController@updateComment')->name('updateComment');
    Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
    /* End Comment Routs */

    /*post cat*/
    Route::get('/postcategory', 'DashboardController@postcategory')->name('postCategoryRoute');
    Route::get('/postcategory/add', 'DashboardController@add_postcategory')->name('addpostCategoryRoute');
    Route::post('/postcategory/add', 'DashboardController@insert_postcategory')->name('insertpostCategoryRoute');
    Route::get('/postcategory/edit/{id}', 'DashboardController@edit_postcategory')->name('editpostCategoryRoute');
    Route::post('/postcategory/edit/{id}', 'DashboardController@update_postcategory')->name('updatepostCategoryRoute');
    Route::get('/postcategory/delete/{id}', 'DashboardController@delete_postcategory')->name('deletepostCategoryRoute');
    /*end post cat*/
});


