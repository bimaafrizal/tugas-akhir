<?php

namespace App\Services\ManajemenUser;

use LaravelEasyRepository\Service;
use App\Repositories\ManajemenUser\ManajemenUserRepository;
use Illuminate\Support\Facades\Hash;

class ManajemenUserServiceImplement extends Service implements ManajemenUserService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(ManajemenUserRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function create($data)
  {
    $dataValidate = [
      'name' => $data['name'],
      'phone_num' => $data['phone_num'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'status' => 1,
      'role_id' => $data['role_id']
    ];
    return $this->mainRepository->store($dataValidate);
  }

  public function update($id, $data)
  {
    return $this->mainRepository->updateData($data, $id);
  }

  public function updateStatus($id, $data)
  {
    return $this->mainRepository->editStatus($id, $data);
  }
}