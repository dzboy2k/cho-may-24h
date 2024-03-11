<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'admin', 'middleware' => 'check.auth'], function () {
    Voyager::routes();
    Route::group(['namespace' => 'Site'], function () {
        Route::get('login', 'AuthController@showLoginForm')->name('voyager.login');
    });
    Route::group(['namespace' => 'Admin', 'middleware' => 'admin.user'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'VoyagerUserController@index')->name('voyager.users.index');
            Route::get('/create', 'VoyagerUserController@create')->name('voyager.users.create');
            Route::post('/store', 'VoyagerUserController@store')->name('voyager.users.create.post');
            Route::get('/relation', 'VoyagerUserController@relation')->name('voyager.users.relationship');
            Route::get('/relationship', 'VoyagerUserController@relationship')->name('voyager.users.relation');
            Route::get('/{id}/edit', 'VoyagerUserController@edit')->name('voyager.users.edit');
            Route::put('/{id}', 'VoyagerUserController@update')->name('voyager.users.update');
            Route::get('/{id}/wallet', 'VoyagerUserController@detailWallet')->name('voyager.user.wallet');
            Route::get('/{id}/wallet/{type}/edit', 'VoyagerUserController@showWalletEditForm')->name('voyager.user.wallet.edit.form');
            Route::post('/wallet/edit', 'VoyagerUserController@editWallet')->name('voyager.user.wallet.edit');
            Route::post('/support_wallet/edit', 'VoyagerUserController@editSupportWallet')->name('voyager.user.support_wallet.edit');
        });
        Route::group(['prefix' => 'menus/{menu}'], function () {
            Route::get('/builder', 'VoyagerMenuController@builder')->name('voyager.menus.builder');
        });

        Route::get('/', 'AdminController@index')->name('voyager.dashboard');

        Route::get('/charge-data', 'AdminController@getChargeData')->name('admin.charge.data');
        Route::group(['prefix' => 'transactions'], function () {
            Route::get('/', 'TransactionController@index')->name('admin.transactions');
            Route::get('/search', 'TransactionController@search')->name('admin.transactions.search');
        });
        Route::group(['prefix' => 'withdraws'], function () {
            Route::get('/', 'WithdrawController@index')->name('admin.withdraws');
            Route::get('/verify-withdraw-request/{id}', 'WithdrawController@verifyWithdrawRequest')->name('admin.withdraws.verify');
            Route::get('/search', 'WithdrawController@search')->name('admin.withdraws.search');
        });
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'CategoryController@index')->name('admin.categories');
            Route::get('/create', 'CategoryController@showCreateForm')->name('admin.categories.create.form');
            Route::post('/create', 'CategoryController@create')->name('admin.categories.create');
            Route::get('/edit/{id}', 'CategoryController@showEditForm')->name('admin.categories.edit.form');
            Route::post('/edit', 'CategoryController@edit')->name('admin.categories.edit');
            Route::get('/delete/{id}', 'CategoryController@delete')->name('admin.categories.delete');
            Route::post('/delete-all', 'CategoryController@deleteAll')->name('admin.categories.delete.all');
            Route::get('/detail/{slug}', 'CategoryController@detail')->name('admin.categories.detail');
            Route::get('/search', 'CategoryController@search')->name('admin.categories.search');
        });

        Route::group(['prefix' => 'pages'], function () {
            Route::get('/', 'PageController@index')->name('admin.pages');
            Route::get('/create', 'PageController@showCreateForm')->name('admin.pages.create.form');
            Route::post('/create', 'PageController@create')->name('admin.pages.create');
            Route::get('/edit/{id}', 'PageController@showEditForm')->name('admin.pages.edit.form');
            Route::post('/edit', 'PageController@edit')->name('admin.pages.edit');
            Route::get('/delete/{id}', 'PageController@delete')->name('admin.pages.delete');
            Route::get('/detail/{id}', 'PageController@detail')->name('admin.pages.detail');
            Route::get('/search', 'PageController@search')->name('admin.pages.search');
        });

        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'PostController@index')->name('admin.posts');
            Route::get('/create', 'PostController@showCreateForm')->name('admin.posts.create.form');
            Route::post('/create', 'PostController@create')->name('admin.posts.create');
            Route::get('/delete/{id}', 'PostController@delete')->name('admin.posts.delete');
            Route::post('/delete-all', 'PostController@deleteAll')->name('admin.posts.delete.all');
            Route::get('/detail/{id}', 'PostController@detail')->name('admin.posts.detail');
            Route::get('/verify-post/{id}', 'PostController@showVerifyForm')->name('admin.posts.verify.form');
            Route::post('/verify-post', 'PostController@verifyPost')->name('admin.posts.verify');
        });
        Route::get('/search', 'PostController@search')->name('admin.posts.search');
        Route::get('/unverify', 'PostController@unverifyPost')->name('admin.posts.unverify');

        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', 'BrandController@index')->name('admin.brands');
            Route::get('/create', 'BrandController@showCreateForm')->name('admin.brands.create.form');
            Route::post('/create', 'BrandController@create')->name('admin.brands.create');
            Route::get('/edit/{id}', 'BrandController@showEditForm')->name('admin.brands.edit.form');
            Route::post('/edit', 'BrandController@edit')->name('admin.brands.edit');
            Route::get('/delete/{id}', 'BrandController@delete')->name('admin.brands.delete');
            Route::post('/delete-all', 'BrandController@deleteAll')->name('admin.brands.delete.all');
            Route::get('/detail/{id}', 'BrandController@detail')->name('admin.brands.detail');
            Route::get('/search', 'BrandController@search')->name('admin.brands.search');
        });
        Route::group(['prefix' => 'status'], function () {
            Route::get('/', 'StatusController@index')->name('admin.status');
            Route::get('/create', 'StatusController@showCreateForm')->name('admin.status.create.form');
            Route::post('/create', 'StatusController@create')->name('admin.status.create');
            Route::get('/edit/{id}', 'StatusController@showEditForm')->name('admin.status.edit.form');
            Route::post('/edit', 'StatusController@edit')->name('admin.status.edit');
            Route::get('/delete/{id}', 'StatusController@delete')->name('admin.status.delete');
            Route::post('/delete-all', 'StatusController@deleteAll')->name('admin.status.delete.all');
            Route::get('/detail/{id}', 'StatusController@detail')->name('admin.status.detail');
            Route::get('/search', 'StatusController@search')->name('admin.status.search');
        });
        Route::group(['prefix' => 'post-plans'], function () {
            Route::get('/', 'PostPlanController@index')->name('admin.post-plans');
            Route::get('/create', 'PostPlanController@showCreateForm')->name('admin.post-plans.create.form');
            Route::post('/create', 'PostPlanController@create')->name('admin.post-plans.create');
            Route::get('/edit/{id}', 'PostPlanController@showEditForm')->name('admin.post-plans.edit.form');
            Route::post('/edit', 'PostPlanController@edit')->name('admin.post-plans.edit');
            Route::get('/delete/{id}', 'PostPlanController@delete')->name('admin.post-plans.delete');
            Route::post('/delete-all', 'PostPlanController@deleteAll')->name('admin.post-plans.delete.all');
            Route::get('/detail/{id}', 'PostPlanController@detail')->name('admin.post-plans.detail');
            Route::get('/search', 'PostPlanController@search')->name('admin.post-plans.search');
            Route::group(['prefix' => 'users'], function () {
                Route::get('/', 'UserPostingPlanController@index')->name('admin.user.posting.plan');
                Route::get('/delete/{id}', 'UserPostingPlanController@delete')->name('admin.user-posting-plan.delete');
                Route::post('/delete-all', 'UserPostingPlanController@deleteAll')->name('admin.user-posting-plan.delete.all');
                Route::get('/search', 'UserPostingPlanController@search')->name('admin.user-posting-plan.search');
                Route::get('/detail/{id}', 'UserPostingPlanController@detail')->name('admin.user-posting-plan.detail');
            });
        });
        Route::any('/{any?}', 'AdminController@fallback')
            ->where('any', '.*')
            ->name('admin.not_found');
    });
});

Route::group(['prefix' => '/', 'namespace' => 'Site', 'middleware' => 'check.auth'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/login', 'AuthController@showLoginForm')->name('auth.login.form');
        Route::post('/login', 'AuthController@login')->name('auth.login');
        Route::get('/register', 'AuthController@showRegisterForm')->name('auth.register.form');
        Route::post('/register', 'AuthController@register')->name('auth.register');
        Route::get('/logout', 'AuthController@logout')->name('auth.logout');
        Route::get('/forgot-password', 'AuthController@showForgotPasswordForm')->name('auth.forgot_password.form');
        Route::post('/forgot-password', 'AuthController@forgotPassword')->name('auth.forgot_password');
        Route::group(['middleware' => 'forgot_password.verify'], function () {
            Route::get('/verify-forgot-code', 'AuthController@showVerifyForgotCodeForm')->name('auth.verify_forgot_password.form');
            Route::post('/verify-forgot-code', 'AuthController@verifyForgotCode')->name('auth.verify_forgot_password');
            Route::get('/reset-password', 'AuthController@showResetPasswordForm')->name('auth.reset_password.form');
            Route::post('/reset-password', 'AuthController@resetPassword')->name('auth.reset_password');
        });
    });
    Route::group(['prefix' => 'posts', 'middleware' => 'posts'], function () {
        Route::get('/create', 'PostController@showCreatePostForm')->name('post.create.form');
        Route::post('/create', 'PostController@createPost')->name('post.create');
        Route::get('/update/{id}', 'PostController@showUpdatePostForm')->name('post.update.form');
        Route::post('/update', 'PostController@edit')->name('post.update');
        Route::get('/filter', 'PostController@filterPost')->name('post.filter');
        Route::get('/post-detail/{slug}', 'PostController@postDetail')
            ->name('post.detail')
            ->withoutMiddleware(['check.auth', 'posts']);
        Route::post('/delete/{id}', 'PostController@delete')->name('post.delete');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => 'user_logged.filter'], function () {
            Route::get('/profile/edit', 'UserController@showEditProfileForm')->name('profile.edit.form');
            Route::put('/profile/edit', 'UserController@editProfile')->name('profile.edit');
            Route::get('/change-password', 'UserController@showChangePasswordForm')->name('user.change_password.form');
            Route::post('/change-password', 'UserController@changePassword')->name('user.change_password');
            Route::post('/{id}', 'UserController@toggleFollow')->name('user.follow');
            Route::get('/saved-posts', 'UserController@showSavedPosts')->name('saved.posts');
        });
        Route::get('/{id?}', 'UserController@showUserInfo')->name('user.info');
    });
    Route::group(['prefix' => 'transaction', 'namespace' => 'Transaction', 'middleware' => 'user_logged.filter'], function () {
        Route::group(['prefix' => 'withdrawal'], function () {
            Route::get('/', 'WithdrawalController@showWithdrawalForm')->name('withdrawal.form');
            Route::get('/enter-bank-account', 'WithdrawalController@showBankAccountForm')->name('withdrawal.bank.account');
            Route::post('/handle-withdraw', 'WithdrawalController@handleWithdraw')->name('withdrawal.handle');
        });
        Route::group(['prefix' => 'deposit'], function () {
            Route::get('/', 'DepositController@showDepositMethod')->name('deposit.method');
            Route::get('/enter-amount/{type}', 'DepositController@showEnterDepositAmount')->name('deposit.amount');
            Route::post('/create-transaction', 'DepositController@createTransaction')->name('deposit.transaction.create');
            Route::post('/transfer-coin-from-get-depreciation-to-the-main-wallet', 'DepositController@createFromGetDepreciationWalletToMainWallet')->name('deposit.transaction.transfer_coin_from_get_depreciation_to_the_main_wallet.create');
            Route::get('/depreciation', 'DepositController@showDepreciationTransferForm')->name('deposit.depreciation.transfer');
            Route::get('/transfer-info/{id}', 'DepositController@showTransferInfo')->name('deposit.transfer');
            Route::get('/to-sale-wallet', 'DepositController@showEnterSaleLimitAmount')->name('deposit.to-sale-limit');
            Route::post('/to-sale-wallet-transfer', 'DepositController@transferToSaleWallet')->name('deposit.to-sale-limit.transfer');
        });
        Route::group(['prefix' => 'support'], function () {
            Route::get('/transfer', 'SupportController@showTransfer')->name('support.transfer.show');
            Route::post('/active-transfer', 'SupportController@handleTransfer')->name('support.transfer.handle');
        });
        Route::group(['prefix' => 'sale-limit'], function () {
            Route::get('/transfer', 'SaleLimitController@showTransfer')->name('sale.limit.transfer.show');
            Route::post('/active-transfer', 'SaleLimitController@handleTransfer')->name('sale.limit.transfer.handle');
        });
    });
    Route::group(['prefix' => 'chat', 'middleware' => 'chat'], function () {
        Route::get('/', 'ChatController@showChatUI')->name('chat');
    });
    Route::group(['prefix' => 'tags'], function () {
        Route::get('/{id}/posts', 'TagController@postsByTag')->name('tag.posts');
    });

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/categories/{slug}', 'CategoryController@index')->name('category.explode');

    Route::group(['prefix' => 'history', 'middleware' => 'user_logged.filter'], function () {
        Route::group(['namespace' => 'History'], function () {
            Route::get('/transaction/{history_type?}', 'TransactionController@index')->name('site.history.transaction');
            Route::get('/support-transaction', 'SupportTransactionController@index')->name('site.history.support.transaction');
        });
        Route::group(['prefix' => 'order'], function () {
            Route::get('/sell', 'OrderController@sellOrdersHistory')->name('site.history.order_history.sell');
            Route::get('/buy', 'OrderController@buyOrdersHistory')->name('site.history.order_history.buy');
            Route::post('/set-paid/{id}', 'OrderController@setPaid')->name('site.order.set-paid');
            Route::post('/set-received/{id}', 'OrderController@setReceived')->name('site.order.set-received');
            Route::get('/detail/{id}', 'OrderController@detail')->name('site.history.order_detail');
        });
    });

    Route::group(['prefix' => 'post-plans'], function () {
        Route::get('/', 'PostPlanController@index')->name('site.post-plans');
        Route::get('/register-plan/{id}', 'PostPlanController@registerPlan')->name('site.post-plans.register');
        Route::get('/cancel-plan/{id}', 'PostPlanController@cancelPlan')->name('site.post-plans.cancel_plan');
    });

    Route::get('/search', 'SearchController@index')->name('site.search');
    Route::group(['prefix' => 'officials'], function () {
        Route::get('/', 'PageController@official');
    })->name('site.pages.officials');

    Route::get('/{slug}', 'PageController@index')->name('site.pages');
});
