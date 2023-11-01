<?php

use Illuminate\Support\Facades\DB;
use Mferrara\Siren\Siren;

it('stores disk metrics in the database', function () {
    $siren = new Siren();

    // Collect and store
    $siren->process();

    // Retrieve the latest record from the database (assuming a DiskMetric model)
    $latestMetric = DB::table('server_siren')->latest()->first();

    // Assert that the latest record matches the expected values
    expect($latestMetric)->not->toBeNull();
    expect($latestMetric->memory_total)->toBeGreaterThan(0);
    expect($latestMetric->disk_total_space)->toBeGreaterThan(0);
    expect($latestMetric->cpu_1_min_load)->toBeGreaterThan(0);
});
