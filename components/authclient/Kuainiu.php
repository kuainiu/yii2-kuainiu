<?php
namespace kuainiu\components\authclient;

use yii\authclient\OAuth2;

class Kuainiu extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = '';
    /**
     * @inheritdoc
     */
    public $tokenUrl = '';

    /**
     * @inheritdoc
     */
    public $apiBaseUrl = '';

    /**
     * 强制通过 header 传递Token,
     * @inheritdoc
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $header = $request->getHeaders();
        $header['Authorization'] = "Bearer ". $accessToken->getToken();
        $request->setHeaders($header);
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $response = $this->api('', 'GET');
        return $response['data'];
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'kuainiu';
    }
    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'Kuainiu';
    }
}
