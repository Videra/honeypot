<?php

namespace App\Providers;

use App\Events\AchievedBrokenAccessControl;
use App\Events\AchievedImageUploadBypass;
use App\Events\AchievedMassAssignment;
use App\Events\AchievedSQLi;
use App\Events\AchievedXSS;
use App\Events\ChallengeAttempted;
use App\Events\ChallengeCompleted;
use App\Events\CreatedUser;
use App\Events\DeletedUser;
use App\Events\AttemptedBrokenAccessControl;
use App\Events\AttemptedMassAssignment;
use App\Events\AttemptedSQLi;
use App\Events\UpdatedUser;
use App\Events\AttemptedXSS;
use App\Listeners\LogAchievedBrokenAccessControl;
use App\Listeners\LogAchievedImageUploadBypass;
use App\Listeners\LogAchievedMassAssignment;
use App\Listeners\LogAchievedSQLi;
use App\Listeners\LogAchievedXSS;
use App\Listeners\LogAuthenticated;
use App\Listeners\LogAuthenticationAttempt;
use App\Listeners\LogChallengeAttempted;
use App\Listeners\LogChallengeCompleted;
use App\Listeners\LogCreatedUser;
use App\Listeners\LogCurrentDeviceLogout;
use App\Listeners\LogDeletedUser;
use App\Listeners\LogFailedLogin;
use App\Listeners\LogAttemptedBrokenAccessControl;
use App\Listeners\LogLockout;
use App\Listeners\LogAttemptedMassAssignment;
use App\Listeners\LogOtherDeviceLogout;
use App\Listeners\LogPasswordReset;
use App\Listeners\LogRegisteredUser;
use App\Listeners\LogAttemptedSQLi;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use App\Listeners\LogUpdatedUser;
use App\Listeners\LogValidated;
use App\Listeners\LogVerified;
use App\Listeners\LogAttemptedXSS;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
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
            LogVerified::class,
        ],
        Logout::class => [
            LogSuccessfulLogout::class,
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
        Registered::class => [
            LogRegisteredUser::class,
        ],

        // Honeypot Events
        ChallengeAttempted::class => [
            LogChallengeAttempted::class,
        ],
        ChallengeCompleted::class => [
            LogChallengeCompleted::class,
        ],
        UpdatedUser::class => [
            LogUpdatedUser::class,
        ],
        CreatedUser::class => [
            LogCreatedUser::class,
        ],
        DeletedUser::class => [
            LogDeletedUser::class,
        ],

        // Challenges Attempts
        AttemptedBrokenAccessControl::class => [
            LogAttemptedBrokenAccessControl::class,
        ],
        AttemptedXSS::class => [
            LogAttemptedXSS::class,
        ],
        AttemptedSQLi::class => [
            LogAttemptedSQLi::class,
        ],
        AttemptedMassAssignment::class => [
            LogAttemptedMassAssignment::class,
        ],

        // Challenges Successes
        AchievedBrokenAccessControl::class => [
            LogAchievedBrokenAccessControl::class,
        ],
        AchievedSQLi::class => [
            LogAchievedSQLi::class,
        ],
        AchievedMassAssignment::class => [
            LogAchievedMassAssignment::class,
        ],
        AchievedXSS::class => [
            LogAchievedXSS::class,
        ],
        AchievedImageUploadBypass::class => [
            LogAchievedImageUploadBypass::class,
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
