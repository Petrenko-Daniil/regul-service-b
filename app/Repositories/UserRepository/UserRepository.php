<?php

namespace App\Repositories\UserRepository;

use App\DTO\AbstractDTO;
use App\Repositories\AbstractRepository;
use App\Repositories\Traits\ApiFetchable;
use App\Services\CacheService\Traits\Cacheable;

class UserRepository extends AbstractRepository
{
    use Cacheable, ApiFetchable;

    protected string|AbstractDTO $dtoClass = UserDTO::class;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('remote-services.regul-service-a')."/api/users/{id}";
    }
}
