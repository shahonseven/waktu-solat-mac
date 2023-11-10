<?php

namespace App\Livewire;

use App\Enums\PrayerTime as EnumsPrayerTime;
use App\Models\LocationCode;
use App\Models\PrayerTime;
use App\Services\MalaysiaPrayerTimeService;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DailyPrayerTime extends Component
{
    public mixed $code;

    public mixed $theme;

    public array $locationCodes;

    public PrayerTime $prayerTimes;

    public string $activeTab = 'prayer-time';

    public function mount(MalaysiaPrayerTimeService $malaysiaPrayerTimeService): void
    {
        $this->code = option('code', env('DEFAULT_LOCATION_CODE'));

        $this->theme = option('theme', 'light');

        $this->locationCodes = LocationCode::query()->get()->groupBy('state')->toArray();

        $this->prayerTimes = $malaysiaPrayerTimeService->get(code: $this->code);
    }

    #[Computed]
    public function currentPrayerName(): string
    {
        $currentPrayerName = '';

        foreach ($this->prayerNames() as $prayerName) {
            $isPast = Carbon::createFromTimestamp($this->prayerTimes->{$prayerName->value})->lessThanOrEqualTo(now());

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
        return LocationCode::query()->where('code', $this->code)->first()?->location ?? 'N/A';
    }

    public function render(): Renderable
    {
        return view('livewire.daily-prayer-time');
    }

    public function save(): void
    {
        option(['code' => $this->code ?? env('DEFAULT_LOCATION_CODE'), 'theme' => $this->theme]);

        unset($this->prayerTimeLocation);

        $this->prayerTimes = (new MalaysiaPrayerTimeService())->get(code: $this->code, fresh: true);

        redirect(request()->header('Referer'));
    }
}
