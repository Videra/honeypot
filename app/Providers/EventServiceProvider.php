<?php

namespace App\Providers;

use App\Events\ChallengeAttempted;
use App\Events\ChallengeCompleted;
use App\Events\HoneypotAdminRetrieved;
use App\Events\XSSDetected;
use App\Listeners\LogAuthenticated;
use App\Listeners\LogAuthenticationAttempt;
use App\Listeners\LogChallengeAttempted;
use App\Listeners\LogChallengeCompleted;
use App\Listeners\LogCurrentDeviceLogout;
use App\Listeners\LogFailedLogin;
use App\Listeners\LogHoneypotAdminRetrieved;
use App\Listeners\LogLockout;
use App\Listeners\LogOtherDeviceLogout;
use App\Listeners\LogPasswordReset;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogValidated;
use App\Listeners\LogXSSDetected;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Validated;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Laravel default events
        Authenticated::class => [
            LogAuthenticated::class,
        ],
        Attempting::class => [
            LogAuthenticationAttempt::class,
        ],
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        Failed::class => [
            LogFailedLogin::class,
        ],
        Validated::class => [
            LogValidated::class,
        ],
        Verified::class => [
            LogFailedLogin::class,
        ],
        CurrentDeviceLogout::class => [
            LogCurrentDeviceLogout::class,
        ],
        OtherDeviceLogout::class => [
            LogOtherDeviceLogout::class,
        ],
        Lockout::class => [
            LogLockout::class,
        ],
        PasswordReset::class => [
            LogPasswordReset::class,
        ],

        // Honeypot Events
        ChallengeAttempted::class => [
            LogChallengeAttempted::class,
        ],
        ChallengeCompleted::class => [
            LogChallengeCompleted::class,
        ],
        HoneypotAdminRetrieved::class => [
            LogHoneypotAdminRetrieved::class,
        ],
        XSSDetected::class => [
            LogXSSDetected::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
