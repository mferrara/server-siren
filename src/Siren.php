<?php

namespace Mferrara\Siren;

use Illuminate\Support\Facades\DB;

class Siren
{
    /**
     * Method to process all metrics
     */
    public function process(): void
    {
        $metrics = $this->collectMetrics();
        $this->storeMetrics($metrics);
    }

    /**
     * Method to collect all configured metrics
     */
    protected function collectMetrics(): array
    {
        return [
            'disk' => $this->getDiskSpace(),
            'memory' => $this->getMemory(),
            'cpu' => $this->getCPULoads(),
        ];
    }

    protected function storeMetrics(array $metrics): bool
    {
        $record = [
            'disk_total_space' => $metrics['disk']['total'],
            'disk_free_space' => $metrics['disk']['free'],
            'disk_used_space' => $metrics['disk']['used'],
            'disk_space_percent' => $metrics['disk']['percent'],
            'memory_total' => $metrics['memory']['total'],
            'memory_free' => $metrics['memory']['free'],
            'memory_used' => $metrics['memory']['used'],
            'memory_percent' => $metrics['memory']['percent'],
            'cpu_1_min_load' => $metrics['cpu']['1_min'],
            'cpu_1_min_load_adj' => $metrics['cpu']['1_min_adj'],
            'cpu_5_min_load' => $metrics['cpu']['5_min'],
            'cpu_5_min_load_adj' => $metrics['cpu']['5_min_adj'],
            'cpu_15_min_load' => $metrics['cpu']['15_min'],
            'cpu_15_min_load_adj' => $metrics['cpu']['15_min_adj'],
            'cpu_cores' => $metrics['cpu']['cores'],
        ];

        return DB::table('server_siren')->insert($record);
    }

    /**
     * Get the system's disk space.
     */
    public function getDiskSpace(string $path = '/'): array
    {
        // Fetch the system's total disk space.
        $total = disk_total_space($path);

        // Fetch the system's free disk space.
        $free = disk_free_space($path);

        return [
            'total' => $total,
            'free' => $free,
            'used' => $total - $free,
            'percent' => ($total - $free) / $total * 100,
        ];
    }

    /**
     * Get the system's total and available memory.
     */
    public function getMemory(): array
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows - This is a basic example and might not work in all environments.
            // Consider using COM objects or other methods to get accurate memory details on Windows.
            $total = 0; // Placeholder
            $free = 0;  // Placeholder
        } elseif (strtoupper(substr(PHP_OS, 0, 6)) === 'DARWIN') {
            // MacOS
            $vm_stat = shell_exec('vm_stat');
            $pattern = "/^Pages free:\s+(\d+)./m";
            preg_match($pattern, $vm_stat, $matches);
            $free_pages = intval($matches[1]);
            $free = $free_pages * 16384;  // Convert pages to bytes (using 16384 bytes per page)

            $pattern = "/^Pages active:\s+(\d+)./m";
            preg_match($pattern, $vm_stat, $matches);
            $active_pages = intval($matches[1]);
            $active = $active_pages * 16384;

            $pattern = "/^Pages inactive:\s+(\d+)./m";
            preg_match($pattern, $vm_stat, $matches);
            $inactive_pages = intval($matches[1]);
            $inactive = $inactive_pages * 16384;

            $total = $free + $active + $inactive;  // Total memory in bytes
        } else {
            // Linux
            $data = explode("\n", file_get_contents('/proc/meminfo'));
            $meminfo = [];
            foreach ($data as $line) {
                [$key, $val] = explode(':', $line);
                $meminfo[$key] = trim($val);
            }
            $total = intval($meminfo['MemTotal'] ?? 0) * 1024; // Convert from KB to Bytes
            $free = intval($meminfo['MemFree'] ?? 0) * 1024;   // Convert from KB to Bytes
        }

        return [
            'total' => $total,
            'free' => $free,
            'used' => $total - $free,
            'percent' => $total > 0 ? (($total - $free) / $total * 100) : 0,
        ];
    }

    /**
     * Get the system's CPU loads.
     */
    public function getCPULoads(): array
    {
        // Fetch the system's average load for the past 1, 5, and 15 minutes.
        $loads = sys_getloadavg();
        $core_count = $this->getCpuCoresCount();

        return [
            '1_min' => $loads[0],
            '1_min_adj' => $loads[0] / $core_count,
            '5_min' => $loads[1],
            '5_min_adj' => $loads[1] / $core_count,
            '15_min' => $loads[2],
            '15_min_adj' => $loads[2] / $core_count,
            'cores' => $core_count,
        ];
    }

    /**
     * Get the number of CPU cores.
     */
    public function getCpuCoresCount(): int
    {
        $cores = 1; // Default to 1 core

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows
            $process = @popen('wmic cpu get NumberOfCores', 'rb');
            if ($process !== false) {
                fgets($process); // Skip the header
                $cores = intval(fgets($process));
                pclose($process);
            }
        } else {
            // Linux and macOS
            $cores = intval(shell_exec('grep -Pc "^processor" /proc/cpuinfo') ?: 1);
        }

        return $cores;
    }
}
