<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SiakadService
{
  protected $baseUrl;
  protected $timeout;

  public function __construct()
  {
    $this->baseUrl = env('URL_SERVICE_SIAKAD');
    $this->timeout = env('URL_SERVICE_SIAKAD_TIMEOUT');
  }

  /**
   * Get info pendaftaran dari PMB SIAKAD2
   */
  public function getInfoPendaftaran(): array
  {
    try {
      $response = Http::timeout($this->timeout)
        ->get($this->baseUrl . '/api/v2/getinfo');

      if ($response->successful()) {
        return [
          'success' => true,
          'data' => $response->json()['data'] ?? []
        ];
      }

      return [
        'success' => false,
        'message' => 'Gagal mengambil data dari PMB SIAKAD2'
      ];
    } catch (\Exception $e) {
      Log::error('SiakadService getInfoPendaftaran error: ' . $e->getMessage());
      return [
        'success' => false,
        'message' => 'Tidak dapat terhubung ke PMB SIAKAD2'
      ];
    }
  }

  /**
   * Register calon mahasiswa ke PMB SIAKAD2
   */
  public function registerCalonMahasiswa(array $data): array
  {
    try {
      $response = Http::timeout($this->timeout)
        ->post($this->baseUrl . '/api/v2/register', $data);

      $responseData = $response->json();

      if ($response->successful() && ($responseData['success'] ?? false)) {
        return [
          'success' => true,
          'data' => $responseData['data'] ?? [],
          'message' => $responseData['message'] ?? 'Registrasi berhasil'
        ];
      }

      return [
        'success' => false,
        'message' => $responseData['message'] ?? 'Registrasi gagal',
        'errors' => $responseData['errors'] ?? []
      ];
    } catch (\Exception $e) {
      Log::error('SiakadService registerCalonMahasiswa error: ' . $e->getMessage());
      return [
        'success' => false,
        'message' => 'Tidak dapat terhubung ke PMB SIAKAD2'
      ];
    }
  }

  /**
   * Check API status
   */
  public function checkApiStatus(): bool
  {
    try {
      $response = Http::timeout(10)
        ->get($this->baseUrl . '/api/v2/ping');

      return $response->successful() && ($response->json()['message'] ?? '') === 'pong';
    } catch (\Exception $e) {
      return false;
    }
  }
}
