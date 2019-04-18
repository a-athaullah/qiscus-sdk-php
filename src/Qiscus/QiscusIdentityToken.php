<?php

namespace Qiscus;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

/**
  *
  */
class QiscusIdentityToken
{

  private $qiscus_sdk_app_id;
  private $qiscus_sdk_secret;
  private $client;

  function __construct($qiscus_sdk_app_id, $qiscus_sdk_secret, $stag = false)
  {
    if (!ini_get('date.timezone')) {
      date_default_timezone_set('GMT');
    }

    $this->qiscus_sdk_app_id = $qiscus_sdk_app_id;
    $this->qiscus_sdk_secret = $qiscus_sdk_secret;

    $base_url = 'https://' . $qiscus_sdk_app_id . '.qiscus.com/';
    if($stag) $base_url = 'https://api.qiscus.com/';
    $this->client = new \GuzzleHttp\Client(['base_uri' => $base_url]);
  }

  public function localMode($local = false, $base_url = 'http://localhost:9000')
  {
    if ($local === true) {
      $this->client = new \GuzzleHttp\Client(['base_uri' => $base_url]);
    }
  }

  public function getNonce()
  {
    try {
      $response = $this->client->request('POST', '/api/v2/auth/nonce',
        [
          'multipart' => [],
          'headers' => [
              'Accept' => 'application/json',
              'QISCUS_SDK_APP_ID' => $this->qiscus_sdk_app_id,
              'QISCUS_SDK_SECRET' => $this->qiscus_sdk_secret
          ]
        ]);

      $response_json = json_decode((string) $response->getBody());
      return $response_json;
    } catch (\GuzzleHttp\Exception\BadResponseException $exception) {
      // docs.guzzlephp.org/en/latest/quickstart.html#exceptions
      // for 500-level errors or 400-level errors
      $response_body = $exception->getResponse()->getBody(true);
      $response_json = json_decode((string) $response_body);
      return $response_json;
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }


  public function generateIdentityToken($nonce, $user_id, $user_name = '', $avatar_url = '', $extras = null)
  {
    // Using HMAC (HS256) signing method
    $signer = new Sha256();

    $now = time();

    $token = (new Builder())
      // Set header
      // Header "alg" has been set to HS256 by library
      // Header "typ" has been set to "JWT" by library
      ->setHeader('ver', 'v2')

      // Set the payload
      // Configures the issuer (iss claim). It is a qiscus app id, can be obtain from dashboard
      ->setIssuer($this->qiscus_sdk_app_id)

      // Configures payload, "prn" is a client provider's internal ID for the authenticating user. Don't copy to header
      ->set('prn', $user_id, false)

      // Configures the time that the token was issue (iat claim)
      ->setIssuedAt($now - 150)

      // Configures the time that the token can be used (nbf claim)
      ->setNotBefore($now - 120)

      // Token expiration set to 2 minutes only (exp claim)
      ->setExpiration($now + 120)

      // nce claim, is a nonce from client
      ->set('nce', $nonce, false)

      // String - Optional - Name of user.
      ->set('name', $user_name, false)

      // String - Optional - Avatar url of user.
      ->set('avatar_url', $avatar_url, false);
    if(!empty($extras)) {
        $token = $token->set('extras', json_encode($extras));
    }

    $token = $token
      // Signing
      // creates a signature using qiscus sdk secret as key
      ->sign($signer, $this->qiscus_sdk_secret)

      // Retrieves the generated token
      ->getToken();

    // var_dump($token->verify($signer, $this->qiscus_sdk_secret));

    return (string) $token;
  }

  public function verifyIdentityToken($identity_token)
  {
    try {
      // building parameters
      $multipart = [];
      $multipart[] = [
        'name' => 'identity_token',
        'contents' => $identity_token
      ];

      $response = $this->client->request('POST', '/api/v2/auth/verify_identity_token',
        [
          'multipart' => $multipart,
          'headers' => [
              'Accept' => 'application/json',
              'QISCUS_SDK_APP_ID' => $this->qiscus_sdk_app_id,
              'QISCUS_SDK_SECRET' => $this->qiscus_sdk_secret
          ]
        ]);

      $response_json = json_decode((string) $response->getBody());
      return $response_json;
    } catch (\GuzzleHttp\Exception\BadResponseException $exception) {
      // docs.guzzlephp.org/en/latest/quickstart.html#exceptions
      // for 500-level errors or 400-level errors
      $response_body = $exception->getResponse()->getBody(true);
      $response_json = json_decode((string) $response_body);
      return $response_json;
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }

}
