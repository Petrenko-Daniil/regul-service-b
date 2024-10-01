<?php

namespace App\Repositories\UserRepository;

class UserDTO extends \App\DTO\AbstractDTO
{
    public ?string $name;
    public ?string $email;
    public string $chatId;
}
