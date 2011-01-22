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

class PostcodeAnywhere_CustomerProfiling_InteractiveTest
    extends PHPUnit_Framework_TestCase
{
    const TEST_RESPONSE = '[{"AcornType":"7","AcornTypeName":"Old people, detached homes","AcornGroup":"B","AcornGroupName":"Affluent Greys","AcornCategory":"1","AcornCategoryName":"Wealthy Achievers"}]';

    /**
     * Tests the constructor method.
     *
     * @return void
     */
    public function testConstructor()
    {
        $caught = false;

        try {
            $foo = new PostcodeAnywhere_CustomerProfiling_Interactive(null);
        } catch (PostcodeAnywhere_CustomerProfiling_Interactive_Exception $e) {
            $this->assertEquals(
                $e->getMessage(),
                'The API key can\'t be empty'
            );

            $caught = true;
        }

        $this->assertTrue($caught, 'Exception wasn\'t rised');
    }

    /**
     * Tests the retrieveByPostcode method.
     *
     * @return void
     */
    public function testRetrieveByPostcode()
    {
        $key = '1232313123';

        $adapter = new Zend_Http_Client_Adapter_Test();

        $response = new Zend_Http_Response(200, array(), self::TEST_RESPONSE);
        $adapter->setResponse($response);

        $client = new Zend_Http_Client(
            null,
            array(
            	'adapter' => $adapter
            )
        );

        $api = new PostcodeAnywhere_CustomerProfiling_Interactive($key, $client);
        $ret = $api->retrieveByPostcode('FOOBAR');

        $uri = 'http://services.postcodeanywhere.co.uk:80/CustomerProfiling/Interactive'
        	. '/RetrieveByPostcode/v1.00/json.ws?&Key=' . $key . '&Postcode=FOOBAR';

    	$this->assertEquals($uri, $client->getUri()->getUri());

    	$this->assertTrue($ret instanceof PostcodeAnywhere_CustomerProfiling_ACORN);

    	$this->assertEquals($ret->getType(), 7);
        $this->assertEquals($ret->getTypeName(), 'Old people, detached homes');
        $this->assertEquals($ret->getGroup(), 'B');
        $this->assertEquals($ret->getGroupName(), 'Affluent Greys');
        $this->assertEquals($ret->getCategory(), 1);
        $this->assertEquals($ret->getCategoryName(), 'Wealthy Achievers');
    }

}
