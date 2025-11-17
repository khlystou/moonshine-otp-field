<?php 

declare(strict_types=1);

namespace Khlystou\OtpField;

use Illuminate\Support\ServiceProvider;

class OtpFieldServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'otp-field');
    }
}