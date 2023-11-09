<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = (string) file_get_contents(database_path('data/location_codes.json'));
        $locationCodes = (array) json_decode($content, true);

        foreach ($locationCodes as $locationCode) {
            foreach ((array) $locationCode as $locations) {
                DB::table('location_codes')->upsert((array) $locations, ['code']);
            }
        }
    }
}
