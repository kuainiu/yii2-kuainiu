<?php
namespace kuainiu\components\authclient;

use yii\authclient\OAuth2;

class Kuainiu extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://passport.kuainiu.io/auth';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://passport.kuainiu.io/auth/token';

    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://passport.kuainiu.io/api';

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
        $response = $this->api('user/info', 'GET');
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
