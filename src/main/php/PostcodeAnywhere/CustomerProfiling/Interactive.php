<?php
/**
 * PostcodeAnywhere
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/canddi/Zend_RabbitMQ/blob/master/LICENSE.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hello@canddi.com so we can send you a copy immediately.
 *
 */

/**
 * Library class to interact with PostcodeAnywhere's customer profiling
 * interactive API.
 */
class PostcodeAnywhere_CustomerProfiling_Interactive {

    private $_apiKey;

    /**
     * @var Zend_Http_Client
     */
    private $_client;
    /*
     * TODO: Maybe this should be refactored if more API methods are
     * implemented.
     */
    const BASE_URL =
        'http://services.postcodeanywhere.co.uk/CustomerProfiling/Interactive';

    const RETRIEVE_BY_POSTCODE = '/RetrieveByPostcode/v1.00/json.ws?';
    const API_KEY_KEY = 'Key';
    const POSTCODE_KEY = 'Postcode';

    /**
     * Error response keys.
     */
    const ERROR = 'Error';
    const DESCRIPTION = 'Description';
    const CAUSE = 'Cause';
    const RESOLUTION = 'Resolution';

    /**
     * Creates a new instance of the API library.
     *
     * @param string           $apiKey The PostcodeAnywhere API key.
     * @param Zend_Http_Client $client Http client to use. Meant for testing.
     */
    public function __construct($apiKey, Zend_Http_Client $client = null)
    {
        if (empty($apiKey)) {
            throw new PostcodeAnywhere_CustomerProfiling_Interactive_Exception(
            	'The API key can\'t be empty'
            );
        }

        $this->_apiKey = $apiKey;

        if (is_null($client)) {
            $this->_client = new Zend_Http_Client();
        }

    }

    /**
     * Returns the ACORN data for the given postcode.
     *
     * @param string $postcode The postcode.
     * @see http://www.postcodeanywhere.co.uk/support/webservices/CustomerProfiling/Interactive/RetrieveByPostcode/v1/default.aspx
     *
     * @return mixed The API call result.
     */
    public function retrieveByPostcode($postcode)
    {
        $url = $this->_joinUrl(
            self::RETRIEVE_BY_POSTCODE,
            array(
                self::API_KEY_KEY => urlencode($this->_apiKey),
                self::POSTCODE_KEY => urlencode($postcode)
            )
        );

        $this->_client->setUri($url);

        $data = Zend_Json::decode($this->_client->request()->getBody());
        $data = $data[0];

        if (isset($data[self::ERROR])) {
            $msg = $data[self::ERROR] . ' - ' . $data[self::DESCRIPTION]
                . ' - ' . $data[self::CAUSE] . ' - ' . $data[self::RESOLUTION];

            throw new PostcodeAnywhere_CustomerProfiling_Interactive_Exception(
                $msg
            );
        }

        return new PostcodeAnywhere_CustomerProfiling_ACORN($data);
    }

    /**
     * Helper method to avoid future code duplication. Joins urls.
     *
     * @param string $base The base to add to the PostCodeanywhere url
     *                     (it should be relative)
     * @param array  $args The url arguments to use.
     *
     * @return string The formed url.
     */
    private function _joinUrl($base, array $args)
    {
        $ret = self::BASE_URL . $base;

        /**
         * This will put a & at the begining of the "arg part" of the url, but
         * it doesn't matter.
         */
        foreach ($args as $arg => $value) {
            $ret .= '&' . $arg . '=' . $value;
        }

        return $ret;
    }

}