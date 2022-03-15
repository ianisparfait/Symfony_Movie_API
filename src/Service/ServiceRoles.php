<?php

namespace App\Service;

use App\Repository\RolesRepository;

class ServiceRoles
{

  protected $r_repo;

  public function __construct(RolesRepository $r_repo)
  {
      $this->r_repo = $r_repo;
  }
  public function getRole(int $id)
  {
      $role = $this->r_repo->find($id);

      return $role;
  }

  public function getRoleByValue($value)
  {
    $role = $this->r_repo->findOneBy(['value' => $value]);

    return $role;
  }
}
