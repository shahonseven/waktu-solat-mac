<?php

namespace App\Console\Commands;

use App\Enums\PrayerTime;
use App\Models\LocationCode;
use App\Services\MalaysiaPrayerTimeService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Native\Laravel\Facades\Notification;

class SendPrayerTimeDesktopNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-prayer-time-desktop-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(MalaysiaPrayerTimeService $malaysiaPrayerTimeService): void
    {
        $prayerNames = PrayerTime::cases();

        $prayerTimes = $malaysiaPrayerTimeService->get();

        $prayerTimeLocation = LocationCode::query()
            ->where('code', option('code', env('DEFAULT_LOCATION_CODE')))
            ->first()?->location
            ?? 'N/A';

        foreach ($prayerNames as $prayerName) {
            $prayerTime = Carbon::createFromTimestamp($prayerTimes->{$prayerName->value});

            if ($prayerTime->format('Hi') == now()->format('Hi')) {
                $message = sprintf(
                    __('It is now the %s time for the %s area.'),
                    $prayerName->label(),
                    $prayerTimeLocation
                );

                Notification::title(config('app.name'))
                    ->message($message)
                    ->show();
            }
        }
    }
}
