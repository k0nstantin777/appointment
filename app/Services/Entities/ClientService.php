<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreClientDto;
use App\Models\Client;
use App\Services\BaseService;

class ClientService extends BaseService
{
    public function getById(int $id) : Client
    {
        return Client::findOrFail($id);
    }

    public function store(StoreClientDto $dto) : Client
    {
        return Client::create([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'phone' => $dto->getPhone(),
        ]);
    }

    public function update(int $id, StoreClientDto $dto) : Client
    {
        return tap($this->getById($id))->update([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'phone' => $dto->getPhone(),
        ]);

    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }
}
