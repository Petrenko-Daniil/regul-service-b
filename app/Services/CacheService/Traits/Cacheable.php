<?php

namespace App\Services\CacheService\Traits;

use App\DTO\AbstractDTO;
use App\Services\CacheService\CacheService;

trait Cacheable
{
    protected CacheService $cacheService;

    protected function findCachedById(int $id): ?AbstractDTO
    {
        return $this->cacheService->find(get_class($this->dto), $id);
    }

    protected function updateCached(AbstractDTO $dto): void
    {
        $this->cacheService->put($dto);
    }
}
