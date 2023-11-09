<?php

namespace App\Livewire;

use App\Enums\PrayerTime as EnumsPrayerTime;
use App\Models\LocationCode;
use App\Models\PrayerTime;
use App\Services\MalaysiaPrayerTimeService;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DailyPrayerTime extends Component
{
    public PrayerTime $prayerTimes;

    public function boot(MalaysiaPrayerTimeService $malaysiaPrayerTimeService): void
    {
        $this->prayerTimes = $malaysiaPrayerTimeService->get();
    }

    #[Computed]
    public function currentPrayerName(): string
    {
        $currentPrayerName = '';

        foreach ($this->prayerNames() as $prayerName) {
            $isPast = $this->prayerTimes->{$prayerName->value} <= now()->timestamp;

            if ($isPast) {
                $currentPrayerName = $prayerName->value;
            }
        }
        
        return $currentPrayerName;
    }

    /**
     * @return EnumsPrayerTime[]
     */
    #[Computed]
    public function prayerNames()
    {
        return EnumsPrayerTime::cases();
    }

    #[Computed]
    public function prayerTimeLocation(): string
    {
        return LocationCode::query()->where('code', option('code', 'wlp-0'))->first()?->location ?? 'N/A';
    }

    public function render(): Renderable
    {
        return view('livewire.daily-prayer-time');
    }
}
