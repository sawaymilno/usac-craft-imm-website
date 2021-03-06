<?php

namespace Dukt\OAuth\Providers;

use Craft\UrlHelper;
use Craft\Oauth_ResourceOwnerModel;

class Facebook extends BaseProvider
{
    // Public Methods
    // =========================================================================

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return 'Facebook';
    }

    /**
     * Get Icon URL
     *
     * @return string
     */
    public function getIconUrl()
    {
        return UrlHelper::getResourceUrl('oauth/providers/facebook.svg');
    }

    /**
     * Get OAuth Version
     *
     * @return int
     */
    public function getOauthVersion()
    {
        return 2;
    }

    /**
     * Create Facebook Provider
     *
     * @return League\OAuth2\Client\Provider\Facebook
     */
    public function createProvider()
    {
        $graphApiVersion = 'v2.12';

        if(!empty($this->providerInfos->config['graphApiVersion']))
        {
            $graphApiVersion = $this->providerInfos->config['graphApiVersion'];
        }

        $config = [
            'clientId' => $this->providerInfos->clientId,
            'clientSecret' => $this->providerInfos->clientSecret,
            'redirectUri' => $this->getRedirectUri(),
            'graphApiVersion' => $graphApiVersion
        ];

        return new \League\OAuth2\Client\Provider\Facebook($config);
    }

    /**
     * Get API Manager URL
     *
     * @return string
     */
    public function getManagerUrl()
    {
        return 'https://developers.facebook.com/apps';
    }

    /**
     * Get Scope Docs URL
     *
     * @return string
     */
    public function getScopeDocsUrl()
    {
        return 'https://developers.facebook.com/docs/facebook-login/permissions';
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUri()
    {
        $url = parent::getRedirectUri();
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);

            $query = http_build_query($query);

            return $parsedUrl['scheme'].'://'.$parsedUrl['host'].$parsedUrl['path'].'?'.$query;
        }

        return $url;
    }
}
