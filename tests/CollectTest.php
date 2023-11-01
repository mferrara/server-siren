<?php

use Mferrara\Siren\Siren;

it('collects valid disk metrics', function () {
    $siren = new Siren();

    $diskMetrics = $siren->getDiskSpace();

    expect($diskMetrics)->toHaveKeys(['total', 'free', 'used', 'percent']);
    expect($diskMetrics['total'])->toBeGreaterThan(0);
    expect($diskMetrics['free'])->toBeLessThan($diskMetrics['total']);
    expect($diskMetrics['used'])->toBeLessThan($diskMetrics['total']);
    expect($diskMetrics['percent'])->toBeBetween(0, 100);
});

it('collects valid memory metrics', function () {
    $siren = new Siren();

    $memoryMetrics = $siren->getMemory();

    expect($memoryMetrics)->toHaveKeys(['total', 'free', 'used', 'percent']);
    expect($memoryMetrics['total'])->toBeGreaterThan(0);
    expect($memoryMetrics['free'])->toBeLessThan($memoryMetrics['total']);
    expect($memoryMetrics['used'])->toBeLessThan($memoryMetrics['total']);
    expect($memoryMetrics['percent'])->toBeBetween(0, 100);
});

it('collects valid CPU loads', function () {
    $siren = new Siren();

    $cpuLoads = $siren->getCPULoads();

    expect($cpuLoads)->toHaveKeys(['1_min', '1_min_adj', '5_min', '5_min_adj', '15_min', '15_min_adj', 'cores']);
    expect($cpuLoads['1_min'])->toBeGreaterThan(0);
    expect($cpuLoads['5_min'])->toBeGreaterThan(0);
    expect($cpuLoads['15_min'])->toBeGreaterThan(0);
    expect($cpuLoads['cores'])->toBeGreaterThan(0);
});

it('gets correct number of CPU cores', function () {
    $siren = new Siren();

    $cpuCores = $siren->getCpuCoresCount();

    expect($cpuCores)->toBeGreaterThan(0);
});
