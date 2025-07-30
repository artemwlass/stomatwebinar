<?php

namespace App\Providers;

use App\Events\SendEmail;
use App\Events\SendEmailOpenWebinarFromAdmin;
use App\Events\SendEmailPreorder;
use App\Events\SendOrderEmail;
use App\Events\SendOrderTelegram;
use App\Events\SendRegisterEmailUser;
use App\Events\SendTelegram;
use App\Listeners\SendEmailListener;
use App\Listeners\SendEmailOpenWebinarFromAdminListener;
use App\Listeners\SendEmailPreorderListener;
use App\Listeners\SendOrderEmailListener;
use App\Listeners\SendOrderTelegramListener;
use App\Listeners\SendregisterEmailUserListener;
use App\Listeners\UpdateOnlineListener;
use App\Models\Webinar;
use App\Observers\WebinarObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        SendTelegram::class => [
          \App\Listeners\SendTelegramListener::class
        ],
        SendEmail::class => [
            SendEmailListener::class
        ],
        SendOrderEmail::class => [
            SendOrderEmailListener::class
        ],
        SendOrderTelegram::class => [
            SendOrderTelegramListener::class
        ],
        SendRegisterEmailUser::class => [
            SendregisterEmailUserListener::class
        ],
        SendEmailOpenWebinarFromAdmin::class => [
            SendEmailOpenWebinarFromAdminListener::class
        ],
        Login::class => [
            UpdateOnlineListener::class
        ],
        SendEmailPreorder::class => [
            SendEmailPreorderListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
//        Webinar::observe(WebinarObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
