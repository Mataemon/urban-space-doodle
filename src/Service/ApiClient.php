<?php
// src/Service/ApiClient.php
namespace App\Service;

use App\Entity\Mail;
use App\Entity\User;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiClient
{
    private $client;
    //Service url
    private $apiUrl = 'https://sandbox.ar24.fr/api';
    //Service token - secure by storing in external file with read only for wwww user
    private $token = 'xxx';
    //Service key - secure by storing in external file with read only for wwww user
    private $privateKey = 'xxx';
    //Key used in signature
    private $hashedPrivateKey;
    private $serializer;
    const RESULT_SUCCESS = 'SUCCESS';

    /**
     * @param $client HttpClientInterface
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        //Set timezone to match the API's one
        date_default_timezone_set('Europe/Paris');
        //Generate hashed key used in signature
        $this->hashedPrivateKey = hash('sha256', $this->privateKey);

        //initialize serializer
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter()), new ArrayDenormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * Handle the Request
     *
     * @param $method POST | GET
     * @param $endpoint path of the request
     * @param $query additionnal query parameters
     * @param $body post data
     *
     * @return result as an array
     */
    private function sendRequest(string $method, string $endpoint, array $query = null, array $body = null): array
    {
        $date = date('Y-m-d H:i:s');
        // Initialization Vector : First 16 bytes of 2 times hashed private key
        $iv = mb_strcut(hash('sha256', $this->hashedPrivateKey), 0, 16, 'UTF-8');
        $signature = openssl_encrypt($date, 'aes-256-cbc', $this->hashedPrivateKey, false, $iv);

        $params = [
            'headers' => [
                'signature' => $signature,
            ],
        ];
        if (!empty($query)) {
            $params['query'] = $query;
        }
        if (!empty($body)) {
            $body['token'] = $this->token;
            $body['date'] = $date;
            $params['body'] = $body;
        }
        
        $response = $this->client->request(
            $method,
            "{$this->apiUrl}{$endpoint}?token={$this->token}&date={$date}", 
            $params
        );

        try {
            //Errors are in plain string
            $result = $response->toArray();
            return $result;
        }
        catch(DecodingExceptionInterface $e) {
            //Success are crypted
            $key = hash('sha256', $date.$this->privateKey);
            $resp = openssl_decrypt($response->getContent(), 'aes-256-cbc', $key, false, $iv);
            return $this->serializer->decode($resp, 'json');
        }
    }
    /**
     * Get User from id or email
     *
     * @param $userid user id to search for
     * @param $email user email to search for
     *
     * @return User or error message
     */
    public function getUser(string $userid = null, string $email = null): User | string
    {
        $query = [];
        if (!empty($userid))
        {
            $query['id_user'] = $userid;
        }
        if (!empty($email))
        {
            $query['email'] = $email;
        }
        $result = $this->sendRequest('GET', '/user', query: $query);
        //handle result
        if ($result['status'] === self::RESULT_SUCCESS) {
            return $this->serializer->denormalize($result['result'], 'App\Entity\User');
        }
        else {
            return $result['message'];
        }
    }
    /**
     * Get all users
     *
     * @return Array of User or error message
     */
    public function listUsers(): array | string
    {
        $result = $this->sendRequest('GET', '/user/list');
        //handle result
        if ($result['status'] === self::RESULT_SUCCESS) {
            return $this->serializer->denormalize($result['result']['users'], 'App\Entity\User[]');
        }
        else {
            return $result['message'];
        }
    }
    /**
     * Create an User
     *
     * @param $user User object
     *
     * @return the User created or error message
     */
    public function createUser(User $user) : User | string
    {
        //Serialize user for the request
        $data = $this->serializer->normalize($user, 'json', context: [ObjectNormalizer::SKIP_NULL_VALUES => true]);
        $result = $this->sendRequest('POST', '/user', body: $data);
        //handle result
        if ($result['status'] === self::RESULT_SUCCESS) {
            return $this->serializer->denormalize($result['result'], 'App\Entity\User');
        }
        else {
            return $result['message'];
        }
    }
    /**
     * Upload Attachment
     *
     * @param $userid user id to search for
     * @param $filePath
     *
     * @return the Attachment created or error message
     */
    public function uploadAttachment(string $userid, string $filePath) : array | string
    {
        $data = [
            'id_user' => $userid,
            'file' => fopen($filePath, 'r')
        ];
        $result = $this->sendRequest('POST', '/attachment', body: $data);
        
        //handle result
        if ($result['status'] === self::RESULT_SUCCESS) {
            return $result['result'];
        }
        else {
            return $result['message'];
        }
    }
    /**
     * Send Mail
     *
     * @param $mail oject to send
     *
     * @return the Mail created or error message
     */
    public function sendMail(Mail $mail) : Mail | string
    {
        //Serialize user for the request
        $data = $this->serializer->normalize($mail, 'json', context: [ObjectNormalizer::SKIP_NULL_VALUES => true]);
        
        $result = $this->sendRequest('POST', '/mail', body: $data);
        
        //handle result
        if ($result['status'] === self::RESULT_SUCCESS) {
            return $this->serializer->denormalize($result['result'], 'App\Entity\Mail');
        }
        else {
            return $result['message'];
        }
    }
}