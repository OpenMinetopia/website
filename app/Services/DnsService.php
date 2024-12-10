<?php

namespace App\Services;

class DnsService
{
    public function verifyHostname(string $hostname): bool
    {
        $records = dns_get_record($hostname, DNS_A);
        
        if (empty($records)) {
            return false;
        }

        foreach ($records as $record) {
            if ($record['type'] === 'A' && $record['ip'] === config('instances.server_ip')) {
                return true;
            }
        }

        return false;
    }
} 