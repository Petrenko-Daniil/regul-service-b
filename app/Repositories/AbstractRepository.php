<?php

namespace App\Repositories;

use App\DTO\AbstractDTO;
use App\Services\CacheService\Traits\Cacheable;


/**
 * @method findCachedById(int $id)
 * @method updateCached(AbstractDTO $dto)
 */
abstract class AbstractRepository
{
    public string|AbstractDTO $dtoClass;

    public function findById(int $id, bool $useCache = true): ?AbstractDTO
    {
        $cacheable = in_array(Cacheable::class, class_uses($this));
        /** @var ?AbstractDTO $dto */
        $dto = null;
        if ($cacheable && $useCache) {
            $dto = $this->findCachedById($id);
            if ($dto)
                return $dto;
        }
        $dto = $this->fetchById($id);
        if ($dto && $cacheable && $useCache){
            $this->updateCached($dto);
        }
        return $dto;
    }

    abstract public function fetchById(int $id): ?AbstractDTO;
}
