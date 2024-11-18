<?php

use App\Http\Controllers\Accounts\Client\AccountController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\Contacts\Clients\ContactGroupController;
use App\Http\Controllers\Contacts\Clients\ImportContacts;
use App\Http\Controllers\Donations\Client\DonationController;
use App\Http\Controllers\Donations\Client\DonationTransactionsController;
use App\Http\Controllers\Events\Admin\EventAttendeeController;
use App\Http\Controllers\Events\Admin\EventController;
use App\Http\Controllers\Events\Admin\EventQuestionController;
use App\Http\Controllers\Events\Admin\SendSmsToAttendees;
use App\Http\Controllers\Events\Admin\SendVoiceMessageToAttendees;
use App\Http\Controllers\Events\Client\ClientEventAttendeeController;
use App\Http\Controllers\Events\Client\ClientEventDonationController;
use App\Http\Controllers\Events\Client\ClientEventQuestionController;
use App\Http\Controllers\Events\Client\DownloadProgramLineup;
use App\Http\Controllers\Events\Client\EventController as ClientEventController;
use App\Http\Controllers\Events\Client\EventTicketTypeController;
use App\Http\Controllers\Events\Client\SendSmsToAttendees as ClientSendSmsToAttendees;
use App\Http\Controllers\Events\Client\SendVoiceMessageToAttendees as ClientSendVoiceMessageToAttendees;
use App\Http\Controllers\GetInTouch;
use App\Http\Controllers\Gifts\Client\GiftsController;
use App\Http\Controllers\GuestList\GuestListsController;
use App\Http\Controllers\HandleDonationsCallbackWebhook;
use App\Http\Controllers\HandleHubtelRecurringPaymentsWebhook;
use App\Http\Controllers\HandleHubtelWebhook;
use App\Http\Controllers\Home\ShowAdminHome;
use App\Http\Controllers\Payment\Client\PaymentController;
use App\Http\Controllers\Payment\Client\VerifyArkeselPayment;
use App\Http\Controllers\Payment\Client\VerifyPaystackPayment;
use App\Http\Controllers\Payment\VerifyTicketPayment;
use App\Http\Controllers\Profile\AdminProfileController;
use App\Http\Controllers\Profile\ClientProfileController;
use App\Http\Controllers\Sms\Client\SmsCampaignController;
use App\Http\Controllers\Sms\HandleSmsWebhook;
use App\Http\Controllers\SupportedEventsController;
use App\Http\Controllers\Ticketing\Client\TicketingController;
use App\Http\Controllers\Transactions\Admin\TransactionsController;
use App\Http\Controllers\UserManagement\UserManagementController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Ussd\Admin\UssdAvailabilityController;
use App\Http\Controllers\Ussd\Admin\UssdExtensionsController;
use App\Http\Controllers\Wallet\WalletEventsController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'home')->name('welcome');
Route::post('/send/message', GetInTouch::class)->name('send.message');
Route::get('/supported-events', SupportedEventsController::class)->name('index');
Route::get('/contacts', ContactPageController::class)->name('index');

Route::get('sms_histories/webhook', HandleSmsWebhook::class)->name('sms_histories.webhook');
Route::get('payment/confirm', VerifyPaystackPayment::class)->name('payment.confirm');
Route::get('payment/arkesel/confirm', VerifyArkeselPayment::class)->name('payment.arkesel.confirm');
Route::post('payment/hubtel/webhook', HandleHubtelWebhook::class)->name('payment.hubtel.webhook');
Route::get('payment/ticket/confirm', VerifyTicketPayment::class)->name('payment.ticket.confirm');
Route::get('{ticket}/qrcode', [TicketingController::class, 'scanQRCode'])->name('ticket.scanQRCode');

Route::middleware(['auth', 'email_verified', 'phone_not_verified'])
    ->group(function () {
        Route::get('/otp/request', [VerificationController::class, 'index'])->name('otp.request');
        Route::post('/otp/verify', [VerificationController::class, 'verify'])->name('otp.verify');
        Route::get('/otp/send', [VerificationController::class, 'send'])->name('otp.send');
    });

Route::get('events/{event}/program-lineup', DownloadProgramLineup::class)
    ->middleware('signed')
    ->name('events.program-lineup-link');

Route::middleware(['auth', 'role:client|teller', 'email_verified', 'phone_verified'])
    ->group(function () {

        // Dashboard
        // Route::get('home', ShowClientHome::class)->name('home');

        //Events
        Route::get('events/create', [ClientEventController::class, 'create'])->name('events.create');
        Route::post('events/create/event', [ClientEventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [ClientEventController::class, 'edit'])->name('events.edit');
        Route::post('/events/{event}/update', [ClientEventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [ClientEventController::class, 'destroy'])->name('events.destroy');
        Route::put('{event}/questions/{question}', [ClientEventQuestionController::class, 'update'])->name('events.questions.update');
        Route::get('{event}/questions/{question}/delete', [ClientEventQuestionController::class, 'destroy'])->name('events.questions.destroy');
        Route::post('events/{id}/attendees/send-sms', ClientSendSmsToAttendees::class)->name('events.attendees.send-sms');
        Route::post('events/{id}/attendees/send-voice-message', ClientSendVoiceMessageToAttendees::class)->name('events.attendees.send-voice-message');

        //Accounts
        Route::middleware('can_manage_account')->get('accounts/{account}/delete', [AccountController::class, 'destroy'])->name('accounts.destroy');
        Route::resource(
            'accounts',
            AccountController::class
        )->except('destroy');

        //Donations
        Route::resource('donations', DonationController::class);

        //Wallet
        Route::resource('wallet-events', WalletEventsController::class);

        // Payments
        Route::post('pay', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('pay/{transaction}/show', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('pay/{transaction}/status', [PaymentController::class, 'status'])->name('payment.status');

        // Profile
        Route::withoutMiddleware(['email_verified', 'phone_verified'])->group(function () {
            Route::get('profile', [ClientProfileController::class, 'edit'])->name('profile.show');
            Route::put('/profile-update', [ClientProfileController::class, 'update'])->name('profile.update');
        });

        // Contacts
        Route::get('contacts/groups', [ContactGroupController::class, 'index'])->name('contacts.groups.index');
        Route::get('contacts/groups/create', [ContactGroupController::class, 'create'])->name('contacts.groups.create');
        Route::post('contacts/groups/store', [ContactGroupController::class, 'store'])->name('contacts.groups.store');
        Route::get('contacts/groups/delete/{id}', [ContactGroupController::class, 'destroy'])->name('contacts.groups.delete');
        Route::put('contacts/groups/{id}/update', [ContactGroupController::class, 'update'])->name('contacts.groups.update');
        Route::get('contacts/groups/{id}/show', [ContactGroupController::class, 'show'])->name('contacts.groups.show');
        Route::get('contacts/groups/{id}/table', [ContactGroupController::class, 'datatable'])->name('group.contacts.table');
        Route::get('contacts/groups/{id}/import', [ImportContacts::class, 'importView'])->name('contacts.import.view');
        Route::get('contacts/groups/download', [ImportContacts::class, 'downloadContactSampleFile'])->name('contacts.import.download');

        Route::post('contacts/groups/{id}/import', ImportContacts::class)->name('contacts.groups.import');
        Route::post('add/contact', [ContactGroupController::class, 'addContact'])->name('add.contact');
        Route::put('edit/contact/{id}', [ContactGroupController::class, 'editContact'])->name('edit.contact');
        Route::get('delete/contact/{id}', [ContactGroupController::class, 'deleteContact'])->name('delete.contact');

        //User Management
        Route::get('user-management/available-tellers', [UserManagementController::class, 'availableTellers'])->name('user-management.available-tellers');
        Route::resource('user-management', UserManagementController::class);

        Route::resource('sms-campaigns', SmsCampaignController::class)->only(['index', 'show']);
    });

Route::middleware(['auth', 'role:client|teller|client_admin', 'email_verified', 'phone_verified'])
    ->group(function () {
        Route::prefix('events')->group(function () {
            Route::get('/', [ClientEventController::class, 'index'])->name('events.index');
            Route::get('{event}', [ClientEventController::class, 'show'])->name('events.show');
            Route::get('{event}/questions', [ClientEventQuestionController::class, 'index'])->name('events.show.questions');
            Route::get('{event}/pre-registration-questions', [ClientEventQuestionController::class, 'showPreRegistrationQuestions'])->name('events.show.pre-registration-questions');
            Route::get('{event}/attendees', [ClientEventAttendeeController::class, 'index'])->name('events.show.attendees');
            Route::get('{event}/pre-registered-attendees', [ClientEventAttendeeController::class, 'showPreRegisteredAttendees'])->name('events.show.pre-registered-attendees');
            Route::get('{event}/attendees/search', [ClientEventAttendeeController::class, 'search'])->name('events.attendees.search');
            Route::get('{event}/attendees/export', [ClientEventAttendeeController::class, 'export'])->name('events.attendees.export');
        });

        Route::resource('events.donations', ClientEventDonationController::class);

        //Donations
        Route::resource('donations', DonationController::class);

        //Ticketing
        Route::resource('ticketing', TicketingController::class)->only(['index', 'show']);
        Route::resource('events.ticket-types', EventTicketTypeController::class)->only(
            ['index', 'update']
        );
        Route::get('ticketing/{event}/verify-ticket', [TicketingController::class, 'verifyTicket'])->name('ticket.verifyTicket');
        Route::post('ticketing/{event}/update-status', [TicketingController::class, 'updateStatus'])->name('ticket.update-status');

        Route::get('gifts/event-gifts/{event:id}', [GiftsController::class, 'listEventGifts'])->name('gifts.list');
        Route::get('gifts/create/{event}', [GiftsController::class, 'create'])->name('gifts.create');
        Route::resource('gifts', GiftsController::class)->except(['create']);

        Route::prefix('guests-list')->name('guests-list.')->group(function () {
            Route::get('download-template', [GuestListsController::class, 'downloadGuestListTemplate'])->name('download-template');
            Route::get('', [GuestListsController::class, 'index'])->name('index');
        });

        Route::prefix('donation-transactions')->name('donation-transactions.')->group(function () {
            Route::get('', [DonationTransactionsController::class, 'index'])->name('index');
            Route::get('event/{event:id}', [DonationTransactionsController::class, 'show'])->name('show');
        });
    });

// Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Home
        Route::get('home', ShowAdminHome::class)->name('home');

        // Events
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        // Route::post('events/save', [EventController::class, 'store'])->name('events.store');
        // Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::get('events/{id}/show', [EventController::class, 'show'])->name('events.show');
        Route::get('events/{id}/show/questions', [EventQuestionController::class, 'show'])->name('events.show.questions');
        Route::get('events/{id}/show/attendees', [EventAttendeeController::class, 'show'])->name('events.show.attendees');
        Route::post('events/{id}/attendees/send-sms', SendSmsToAttendees::class)->name('events.attendees.send-sms');
        Route::post('events/{id}/attendees/send-voice-message', SendVoiceMessageToAttendees::class)->name('events.attendees.send-voice-message');


        Route::get('events/{event}/ticket-details', [EventController::class, 'ticketSalesdetails'])->name('event.ticket.details');

        //Donations
        Route::get('events/{event}/donation/show', [EventController::class, 'eventDonationDetails'])->name('event.donation.show');

        // USSD
        Route::post('ussd-extensions/availability', [UssdAvailabilityController::class, 'store'])->name('ussd.availability.check');
        Route::resource('ussd-extensions', UssdExtensionsController::class);

        // Users
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UsersController::class, 'show'])->name('users.show');

        // Transactions
        Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions.index');

        // Profile
        Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.show');
        Route::put('/profile-update', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::get('logout', [AdminProfileController::class, 'logout'])->name('logout');
    });
    Route::post('/billing/webhook', HandleHubtelRecurringPaymentsWebhook::class)->name('billing.webhook');
    Route::post('/donations/webhook', HandleDonationsCallbackWebhook::class)->name('donations.webhook');
