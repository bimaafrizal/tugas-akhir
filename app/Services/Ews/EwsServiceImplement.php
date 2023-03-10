<?php

namespace App\Services\Ews;

use LaravelEasyRepository\Service;
use App\Repositories\Ews\EwsRepository;

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
    return $this->mainRepository->store($data);
  }

  public function update($id, $data)
  {
    $dataValidate = [
      'name' => $data['name'],
      'location' => $data['location'],
      'api_url' => $data['api_url'],
      'api_key' => $data['api_key'],
      'longitude' => $data['longitude'],
      'latitude' => $data['latitude'],
      'gmaps_link' => $data['gmaps_link'],
    ];

    return $this->mainRepository->updateData($dataValidate, $id);
  }

  public function updateStatus($id, $data)
  {
    return $this->mainRepository->editStatus($id, $data);
  }
}
