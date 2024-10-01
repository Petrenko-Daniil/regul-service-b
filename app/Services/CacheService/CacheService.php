<?php

namespace App\Services\CacheService;

use App\Services\AbstractService;
use Illuminate\Support\Facades\Redis;
use ReflectionClass;
use ReflectionException;

class CacheService extends AbstractService
{
    protected const TTL = 86400;

    /**
     * @template T
     * @param class-string<T> $class
     * @return T[]
     */
    public function get(string $class): array
    {
        $pattern = $class.'_*';
        $keys = Redis::keys($pattern);

        $results = [];
        foreach ($keys as $key) {
            $cachedData = Redis::get($key);
            if ($cachedData) {
                $results[] = $this->unserializeToObject($class, unserialize($cachedData));
            }
        }

        return $results;

    }

    /**
     * @template T
     * @param class-string<T> $class
     * @param int $id
     * @return ?T
     */
    public function find(string $class, int $id): ?object
    {
        $key = $this->getKey($class, $id);
        $cachedData = Redis::get($key);

        return $cachedData ? $this->unserializeToObject($class, unserialize($cachedData)) : null;
    }

    public function delete(string $class, int $id): void
    {
        $key = $this->getKey($class, $id);
        Redis::del($key);
    }

    public function put(object $object, ?int $ttl = null): void
    {
        $key = $this->getKey(get_class($object), $object->id);
        Redis::set($key, serialize($object));

        if (!$ttl)
            $ttl = self::TTL;
        Redis::expire($key, $ttl);
    }

    protected function getKey(string $dtoClass, int $id): string
    {
        return "{$dtoClass}_{$id}";
    }

    protected function unserializeToObject(string $class, array $data, int $id = null): ?object
    {
        if (method_exists($class, 'fromArray')) {
            return $class::fromArray($data);
        }

        try {
            $reflection = new ReflectionClass($class);
            $instance = $reflection->newInstanceWithoutConstructor();
        } catch (ReflectionException $e) {
            if ($id){
                $this->delete($class, $id);
            }
            return null;
        }


        foreach ($data as $property => $value) {
            if ($reflection->hasProperty($property)) {
                $propertyRef = $reflection->getProperty($property);
                $propertyRef->setAccessible(true);
                $propertyRef->setValue($instance, $value);
            }
        }

        return $instance;
    }
}
