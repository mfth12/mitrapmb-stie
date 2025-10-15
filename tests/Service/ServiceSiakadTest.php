<?php

namespace Tests\Service;

use Tests\TestCase;
use App\Services\SiakadService;

class ServiceSiakadTest extends TestCase
{
    public function test_can_get_info_pendaftaran()
    {
        $service = new SiakadService();
        $result = $service->getInfoPendaftaran();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
    }
}
