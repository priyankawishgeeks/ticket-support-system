<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNoteController;
use App\Http\Controllers\Admin\AppUserController;
use App\Http\Controllers\Admin\CannedMessageController;
use App\Http\Controllers\Admin\TicketReplyController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\UserRoleAssignController as AdminUserRoleAssignController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\SubscriptionPaymentController as AdminSubscriptionPaymentController;
use App\Http\Controllers\Admin\ExpiredSubscriptionController as AdminExpiredSubscriptionController;
use App\Http\Controllers\Admin\GlobalAppUserMessageController;
use App\Http\Controllers\Admin\TicketMainCategoryController as AdminTicketMainCategoryController;
use App\Http\Controllers\Admin\TicketSubcategoryController;
use App\Http\Controllers\Admin\TicketServiceController;
use App\Http\Controllers\Admin\TicketServiceUserController;
use App\Http\Controllers\Client\ClientTicketController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\SiteUserController;
use App\Http\Controllers\SiteUserAuthController;
use App\Http\Controllers\Superviser\SuperviserController;
use App\Http\Controllers\User\ClientPlanController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\TicketSubcategory;
use App\Models\TicketService;

// Route::get('/', function () {
//     return view('welcome');
// });

// use App\Mail\TestMail;
// use Illuminate\Support\Facades\Mail;

// Route::get('/send-test-mail', function() {
//     Mail::to('sahiba@wishgeekstechserve.com')->send(new TestMail());
//     return 'Mail sent!';
// });


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {

    Route::get('/tickets/{ticketId}/replies', [TicketReplyController::class, 'index'])->name('ticket.replies.index');
    Route::post('/tickets/reply', [TicketReplyController::class, 'store'])->name('ticket.replies.store');
    Route::post('/tickets/reply/{id}/read', [TicketReplyController::class, 'markAsRead'])->name('ticket.replies.read');
    Route::delete('/tickets/reply/{id}', [TicketReplyController::class, 'destroy'])->name('ticket.replies.destroy');
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('user/details', [App\Http\Controllers\Admin\AdminController::class, 'fetchUserDetails'])
        ->name('admin.user.details');



    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/roles-create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::get('/roles-edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::post('/roles-store', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::put('/roles-update/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles-destroy/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

    Route::get('/user-list', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/user-create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('user-store', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/user-edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/user-status/{id}', [AdminUserController::class, 'status'])->name('admin.users.status');
    Route::put('/user-update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/user-destroy/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/user-roles', [AdminUserRoleAssignController::class, 'index'])->name('user_roles.index');
        Route::get('/user-roles/{id}/edit', [AdminUserRoleAssignController::class, 'edit'])->name('user_roles.edit');
        Route::put('/user-roles/{id}', [AdminUserRoleAssignController::class, 'update'])->name('user_roles.update');
        Route::delete('/user-roles/{userId}/{roleId}', [AdminUserRoleAssignController::class, 'destroy'])->name('user_roles.destroy');
    });


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/plans', [AdminPlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/create', [AdminPlanController::class, 'create'])->name('plans.create');
        Route::post('/plans/store', [AdminPlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/{id}/edit', [AdminPlanController::class, 'edit'])->name('plans.edit');
        Route::put('/plans/{id}', [AdminPlanController::class, 'update'])->name('plans.update');
        Route::delete('/plans/{id}', [AdminPlanController::class, 'destroy'])->name('plans.destroy');
    });



    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/subscriptions', [AdminSubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/create', [AdminSubscriptionController::class, 'create'])->name('subscriptions.create');
        Route::post('/subscriptions/store', [AdminSubscriptionController::class, 'store'])->name('subscriptions.store');
        Route::get('/subscriptions/{id}/edit', [AdminSubscriptionController::class, 'edit'])->name('subscriptions.edit');
        Route::put('/subscriptions/{id}', [AdminSubscriptionController::class, 'update'])->name('subscriptions.update');
        Route::delete('/subscriptions/{id}', [AdminSubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/subscription_payments', [AdminSubscriptionPaymentController::class, 'index'])->name('subscription_payments.index');
        Route::get('/subscription_payments/create', [AdminSubscriptionPaymentController::class, 'create'])->name('subscription_payments.create');
        Route::post('/subscription_payments/store', [AdminSubscriptionPaymentController::class, 'store'])->name('subscription_payments.store');
        Route::get('/subscription_payments/{id}/edit', [AdminSubscriptionPaymentController::class, 'edit'])->name('subscription_payments.edit');
        Route::put('/subscription_payments/{id}', [AdminSubscriptionPaymentController::class, 'update'])->name('subscription_payments.update');
        Route::delete('/subscription_payments/{id}', [AdminSubscriptionPaymentController::class, 'destroy'])->name('subscription_payments.destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/expired_subscriptions', [AdminExpiredSubscriptionController::class, 'index'])->name('expired_subscriptions.index');
        Route::get('/expired_subscriptions/create', [AdminExpiredSubscriptionController::class, 'create'])->name('expired_subscriptions.create');
        Route::post('/expired_subscriptions/store', [AdminExpiredSubscriptionController::class, 'store'])->name('expired_subscriptions.store');
        Route::get('/expired_subscriptions/{id}/edit', [AdminExpiredSubscriptionController::class, 'edit'])->name('expired_subscriptions.edit');
        Route::put('/expired_subscriptions/{id}', [AdminExpiredSubscriptionController::class, 'update'])->name('expired_subscriptions.update');
        Route::delete('/expired_subscriptions/{id}', [AdminExpiredSubscriptionController::class, 'destroy'])->name('expired_subscriptions.destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/ticket/main_categories', [AdminTicketMainCategoryController::class, 'index'])->name('ticket_main_categories.index');
        Route::get('/ticket/main_categories/create', [AdminTicketMainCategoryController::class, 'create'])->name('ticket_main_categories.create');
        Route::post('/ticket/main_categories/store', [AdminTicketMainCategoryController::class, 'store'])->name('ticket_main_categories.store');
        Route::get('/ticket/main_categories/{id}/edit', [AdminTicketMainCategoryController::class, 'edit'])->name('ticket_main_categories.edit');
        Route::put('/ticket/main_categories/{id}', [AdminTicketMainCategoryController::class, 'update'])->name('ticket_main_categories.update');
        Route::delete('/ticket/main_categories/{id}', [AdminTicketMainCategoryController::class, 'destroy'])->name('ticket_main_categories.destroy');
    });


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/ticket_subcategories', [TicketSubcategoryController::class, 'index'])->name('ticket_subcategories.index');
        Route::get('/ticket_subcategories/create', [TicketSubcategoryController::class, 'create'])->name('ticket_subcategories.create');
        Route::post('/ticket_subcategories/store', [TicketSubcategoryController::class, 'store'])->name('ticket_subcategories.store');
        Route::get('/ticket_subcategories/{id}/edit', [TicketSubcategoryController::class, 'edit'])->name('ticket_subcategories.edit');
        Route::put('/ticket_subcategories/{id}', [TicketSubcategoryController::class, 'update'])->name('ticket_subcategories.update');
        Route::delete('/ticket_subcategories/{id}', [TicketSubcategoryController::class, 'destroy'])->name('ticket_subcategories.destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/ticket_services', [TicketServiceController::class, 'index'])->name('ticket_services.index');
        Route::get('/ticket_services/create', [TicketServiceController::class, 'create'])->name('ticket_services.create');
        Route::post('/ticket_services/store', [TicketServiceController::class, 'store'])->name('ticket_services.store');
        Route::get('/ticket_services/{id}/edit', [TicketServiceController::class, 'edit'])->name('ticket_services.edit');
        Route::put('/ticket_services/{id}', [TicketServiceController::class, 'update'])->name('ticket_services.update');
        Route::delete('/ticket_services/{id}', [TicketServiceController::class, 'destroy'])->name('ticket_services.destroy');

        // AJAX route for dependent dropdown
        Route::get('/ticket_subcategories/{mainCategoryId}', [TicketServiceController::class, 'getSubcategories'])
            ->name('ticket_services.get_subcategories');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        // Service ↔ User linking
        Route::get('/ticket_service_user', [TicketServiceUserController::class, 'index'])->name('ticket_service_user.index');
        Route::get('/ticket_service_user/create', [TicketServiceUserController::class, 'create'])->name('ticket_service_user.create');
        Route::post('/ticket_service_user/store', [TicketServiceUserController::class, 'store'])->name('ticket_service_user.store');
        Route::get('/ticket_service_user/{id}/edit', [TicketServiceUserController::class, 'edit'])->name('ticket_service_user.edit');
        Route::put('/ticket_service_user/{id}', [TicketServiceUserController::class, 'update'])->name('ticket_service_user.update');
        Route::delete('/ticket_service_user/{id}', [TicketServiceUserController::class, 'destroy'])->name('ticket_service_user.destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        // Service ↔ User linking
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::get('/tickets/{id}/show', [TicketController::class, 'show'])->name('tickets.show');
        Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
        Route::get('/tickets/set_assign/{id}', [TicketController::class, 'setAssign'])->name('tickets.set_assign');
        Route::put('/tickets/{id}/assign', [TicketController::class, 'updateAssign'])->name('tickets.assign.update');


        Route::post('/tickets/update-status', [TicketController::class, 'updateStatus'])
            ->name('tickets.update_status');

        Route::post('/tickets/update-priority', [TicketController::class, 'updatePriority'])
            ->name('tickets.update_priority');



        Route::get('/canned-messages/fetch', [CannedMessageController::class, 'fetch'])
            ->name('canned_messages.fetch');

        Route::post('/notes/store', [AdminNoteController::class, 'store'])
            ->name('notes.store');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        // your main ticket resource routes here
        Route::get('subcategories/{categoryId}', [TicketController::class, 'getSubcategories'])->name('subcategories');
        Route::get('services/{subcatId}', [TicketController::class, 'getServices'])->name('services');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/app_user', [AppUserController::class, 'index'])->name('app_user.index');
        Route::get('/app_user/create', [AppUserController::class, 'create'])->name('app_user.create');
        Route::post('/app_user/store', [AppUserController::class, 'store'])->name('app_user.store');
        Route::get('/app_user/{id}/edit', [AppUserController::class, 'edit'])->name('app_user.edit');
        Route::get('/app_user/{id}/show', [AppUserController::class, 'show'])->name('app_user.show');
        Route::put('/app_user/{id}', [AppUserController::class, 'update'])->name('app_user.update');
        Route::delete('/app_user/{id}', [AppUserController::class, 'destroy'])->name('app_user.destroy');
    });

    Route::prefix('admin/site_user')->name('admin.site_user.')->group(function () {
        Route::get('/', [SiteUserController::class, 'index'])->name('index');
        Route::get('/create', [SiteUserController::class, 'create'])->name('create');
        Route::post('/store', [SiteUserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SiteUserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SiteUserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [SiteUserController::class, 'delete'])->name('delete');
        Route::post('/status/{id}', [SiteUserController::class, 'status'])->name('status');
    });


    Route::prefix('admin/canned_messages')->name('admin.canned_messages.')->group(function () {
        Route::get('/', [CannedMessageController::class, 'index'])->name('index');
        Route::get('/create', [CannedMessageController::class, 'create'])->name('create');
        Route::post('/store', [CannedMessageController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CannedMessageController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CannedMessageController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CannedMessageController::class, 'delete'])->name('delete');
        Route::post('/status/{id}', [CannedMessageController::class, 'status'])->name('status');
    });


    Route::prefix('admin/messages')->group(function () {
        Route::get('/', [GlobalAppUserMessageController::class, 'index'])->name('admin.messages.index');
        Route::get('/fetch', [GlobalAppUserMessageController::class, 'fetchMessages'])->name('admin.messages.fetch');
        Route::post('/send', [GlobalAppUserMessageController::class, 'sendMessage'])->name('admin.messages.send');
    });
});


Route::middleware(['auth', 'role:supervisor'])->group(function () {
    Route::get('/superviser/dashboard', [SuperviserController::class, 'index'])->name('superviser.dashboard');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
    Route::get('/agent/tickets', [AgentController::class, 'tickets'])->name('agent.tickets');
    Route::get('/agent/tickets/show/{id}', [AgentController::class, 'showTicket'])->name('agent.tickets.show');
    Route::get('/agent/tickets/assigned', [AgentController::class, 'assignedTickets'])->name('agent.tickets.assigned');
    Route::get('/agent/site-users', [AgentController::class, 'siteTicketUser'])->name('agent.site_users.tickets');

    Route::get('/agent/canned-messages/fetch', [AgentController::class, 'fetch'])
        ->name('agent.canned_messages.fetch');

    Route::post('/agent/notes/store', [AdminNoteController::class, 'store'])
        ->name('agent.notes.store');
    Route::get('/agent/tickets/user/{id}', [AgentController::class, 'getUserTickets'])->name('agent.tickets.user');

    Route::get('/agent/user/details', [AgentController::class, 'fetchDetails'])
        ->name('agent.user.details');
});


Route::prefix('client')->group(function () {
    Route::get('/login', [SiteUserAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('/login', [SiteUserAuthController::class, 'login'])->name('client.login.submit');
    Route::post('/logout', [SiteUserAuthController::class, 'logout'])->name('client.logout');
});

Route::prefix('client')->middleware(['site_user_auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    // routes/web.php
    Route::get('/plans', [ClientPlanController::class, 'index'])->name('client.plans');
    // Route::get('/subscribe/{slug}', [ClientSubscriptionController::class, 'subscribe'])->name('client.subscribe');
    Route::get('/checkout/{planId}', [CheckoutController::class, 'index'])->name('client.checkout');
    Route::post('/checkout/{planId}/subscribe', [CheckoutController::class, 'subscribe'])->name('client.checkout.subscribe');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('client.checkout.success');
    Route::get('/tickets/create', [ClientTicketController::class, 'create'])->name('user.open_ticket');
    Route::post('/tickets/store', [ClientTicketController::class, 'store'])->name('user.open_ticket.store');
    Route::get('/subcategories/{catId}', [ClientTicketController::class, 'getSubcategories'])->name('client.getSubcategories');
    Route::get('/services/{subId}', [ClientTicketController::class, 'getServices'])->name('client.getServices');
    Route::get('/tickets/info/{id}', [ClientTicketController::class, 'showInfo'])->name('user.ticket.showInfo');
    Route::get('/tickets/detail/{id}', [ClientTicketController::class, 'show'])->name('user.ticket.detail');
    Route::post('/tickets/reply/{id}', [ClientTicketController::class, 'reply'])->name('user.ticket.reply');
    Route::get('/tickets/active', [ClientTicketController::class, 'activeTickets'])->name('user.tickets.active');
    Route::get('/tickets/closed', [ClientTicketController::class, 'closedTickets'])->name('user.tickets.closed');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('user.password.change');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::get('/contact-support', [UserController::class, 'contactSupport'])->name('user.contact_support');
});
