<?php

namespace App\Services;

use App\Enums\PrayerTime as EnumsPrayerTime;
use App\Http\SaloonRequests\MalaysiaPrayerTimeRequest;
use App\Models\PrayerTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class MalaysiaPrayerTimeService
{
    public function get(): PrayerTime
    {
        $query = PrayerTime::query()->where('fajr', '>=', now()->startOfDay()->timestamp);

        try {
            return $query->clone()->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->refresh(new MalaysiaPrayerTimeRequest());

            return $query->clone()->firstOrFail();
        }
    }

    public function refresh(MalaysiaPrayerTimeRequest $request): void
    {
        $request->query()->add('code', \option('code', 'wlp-0'));

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
