<?php

namespace App\DataTransferObjects;

class StoreClientDto
{
    public function __construct(
        private string $name,
        private string $email,
        private string $phone,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

}
