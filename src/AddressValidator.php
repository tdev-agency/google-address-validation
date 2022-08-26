<?php

namespace TDevAgency\GoogleAddressValidation;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use TDevAgency\GoogleAddressValidation\Entities\ResultsEntity;
use TDevAgency\GoogleAddressValidation\Entities\SearchEntity;
use TDevAgency\GoogleAddressValidation\Entities\ValidatorEntity;
use TDevAgency\GoogleAddressValidation\Enums\GoogleResponseStatusEnum;
use TDevAgency\GoogleAddressValidation\Exceptions\GoogleResponseException;
use TDevAgency\GoogleAddressValidation\Exceptions\WrongApiKeyException;

class AddressValidator
{
    protected const GOOGLE_API_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiKey = null;

    /**
     * @var ResultsEntity
     */
    protected $responseEntity;

    /**
     * @var Validator
     */
    protected $validator;

    public function __construct(string $key)
    {
        if (\strlen($key) < 10) {
            throw new WrongApiKeyException('Invalid google API key. Please read documentation https://developers.google.com/maps/documentation/geocoding/start?hl=de#get-a-key');
        }
        $this->apiKey = $key;
        $this->validator = new Validator();
        $this->client = new Client([
            'base_uri' => static::GOOGLE_API_URL,
            'defaults' => [
                'query' => [
                    'key' => $key,
                ],
            ],
        ]);
    }

    public function validate(SearchEntity $entity): ValidatorEntity
    {
        $entity->validateInputs();

        return ($this->validator)($this->getData($entity), $entity);
    }

    /**
     * @throws GoogleResponseException
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function getData(SearchEntity $entity): ResultsEntity
    {
        $query = [
            'address' => sprintf(
                '%s+%s,+%s,+%s',
                str_replace(['  ', '+'], '+', $entity->getHouseNumber()),
                str_replace(['  ', '+'], '+', $entity->getStreetName()),
                str_replace(['  ', '+'], '+', $entity->getCity()),
                $entity->getCountry()
            ),
            'region' => mb_strtolower($entity->getCountry()),
            'components' => sprintf('country:%s|locality:%s', $entity->getCountry(), $entity->getCity()),
            'language' => $entity->getLanguage(),
            'key' => $this->apiKey,
        ];

        $response = $this->client->request('GET', '', ['query' => $query]);

        return $this->parseData($response);
    }

    /**
     * @throws GoogleResponseException
     * @throws JsonException
     */
    protected function parseData(ResponseInterface $response): ResultsEntity
    {
        /**
         * @var array{
         *     status: string,
         *     results: array,
         *     error_message: string
         * } $decodedContents
         */
        $decodedContents = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (GoogleResponseStatusEnum::REQUEST_DENIED()->getValue() === $decodedContents['status']) {
            throw new WrongApiKeyException($decodedContents['error_message']);
        }

        if (!empty($decodedContents['error_message'])) {
            throw new GoogleResponseException($decodedContents['error_message']);
        }

        return (new ResultsEntity())->setResults($decodedContents['results'])->setStatus($decodedContents['status']);
    }
}
