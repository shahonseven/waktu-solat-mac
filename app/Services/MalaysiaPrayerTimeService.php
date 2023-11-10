<?php

namespace App\Services;

use App\Enums\PrayerTime as EnumsPrayerTime;
use App\Http\SaloonRequests\MalaysiaPrayerTimeRequest;
use App\Models\PrayerTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class MalaysiaPrayerTimeService
{
    public function get(string $code = null, bool $fresh = false): PrayerTime
    {
        if ($fresh) {
            $this->refresh($code ?? env('DEFAULT_LOCATION_CODE'));
        }

        $query = PrayerTime::query()->where('fajr', '>=', now()->startOfDay()->timestamp);

        try {
            return $query->clone()->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->refresh();

            return $query->clone()->firstOrFail();
        }
    }

    public function refresh(string $code = null): void
    {
        $request = new MalaysiaPrayerTimeRequest();

        $request->query()->add('code', $code ?? env('DEFAULT_LOCATION_CODE'));

        $response = $request->send();

        $results = $response->json();

        $results = collect((array) $results['response']['times'])
            ->map(function ($times) {
                return collect(EnumsPrayerTime::cases())
                    ->pluck('value')
                    ->combine((array) $times)
                    ->toArray();
            })
            ->all();

        DB::table('prayer_times')->truncate();

        DB::table('prayer_times')->insert((array) $results);
    }
}
