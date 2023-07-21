<?php

namespace App\Services\Ews;

use App\Models\Ews;
use LaravelEasyRepository\Service;
use App\Repositories\Ews\EwsRepository;
use GuzzleHttp\Client;

class EwsServiceImplement extends Service implements EwsService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(EwsRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  // Define your custom methods :)
  public function all()
  {
    return $this->mainRepository->all();
  }

  public function create($data)
  {
    if ($data['longitude'] == null && $data['latitude'] == null) {
      $client = new Client();
      $response = $client->request('GET', $data['api_url']);
      $data2 = json_decode($response->getBody()->getContents());
      $latitude = $data2->channel->latitude;
      $longitude = $data2->channel->longitude;

      $data['longitude'] = $longitude;
      $data['latitude'] = $latitude;
    }

    return $this->mainRepository->store($data);
  }

  public function update($id, $data)
  {
    $dataValidate = [
      'name' => $data['name'],
      'detail' => $data['detail'],
      'province_id' => $data['province_id'],
      'regency_id' => $data['regency_id'],
      'api_url' => $data['api_url'],
      'api_key' => $data['api_key'],
      'longitude' => $data['longitude'],
      'latitude' => $data['latitude'],
      'gmaps_link' => $data['gmaps_link'],
      'standard_id' => $data['standard_id'],
    ];

    return $this->mainRepository->updateData($dataValidate, $id);
  }

  public function updateStatus($id, $data)
  {
    return $this->mainRepository->editStatus($id, $data);
  }
}