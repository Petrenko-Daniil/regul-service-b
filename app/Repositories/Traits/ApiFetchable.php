<?php

namespace App\Repositories\Traits;

use App\DTO\AbstractDTO;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use LogicException;
use RuntimeException;
use Throwable;

trait ApiFetchable
{
    public function fetchById(int $id): ?AbstractDTO
    {
        if (!property_exists($this, 'apiUrl'))
            throw new LogicException('apiUrl property must be set for ApiFetchable trait');
        $url = str_replace('{id}', $id, $this->apiUrl);

        try {
            $client = new Client();
            $response = $client->get($url);
            if ($response->getStatusCode() !== 200) {
                throw $this->getApiException(
                    new Exception($response->getReasonPhrase())
                );
            }

            $data = json_decode($response->getBody()->getContents(), true);

            return $this->dtoClass::fromArray($data);

        } catch (GuzzleException $exception) {
            throw $this->getApiException($exception);
        }
    }

    private function getApiException(Throwable $exception): RuntimeException
    {
        return new RuntimeException("API request failed: {$exception->getMessage()}");
    }
}
