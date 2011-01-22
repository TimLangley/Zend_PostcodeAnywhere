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
 * Model class for the data returned by the interactive API.
 */
class PostcodeAnywhere_CustomerProfiling_ACORN
{

    /**
     * Data array keys.
     */
    const TYPE = 'AcornType';
    const TYPE_NAME = 'AcornTypeName';
    const GROUP = 'AcornGroup';
    const GROUP_NAME = 'AcornGroupName';
    const CATEGORY = 'AcornCategory';
    const CATEGORY_NAME = 'AcornCategoryName';

    private $_data;

    /**
     * Creates a new ACORN model.
     *
     * @param array $data The model data.
     * @throws PostcodeAnywhere_CustomerProfiling_Exception
     */
    public function __construct(array $data)
    {
        $keys = array(self::TYPE, self::TYPE_NAME, self::GROUP,
        	self::GROUP_NAME, self::CATEGORY, self::CATEGORY_NAME);

        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new PostcodeAnywhere_CustomerProfiling_Interactive_Exception(
                    $key . ' is missing from the data array!'
                );
            }
        }

        $this->_data = $data;
    }

    /**
     * Retrieves the ACORN record's type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->_data[self::TYPE];
    }

    /**
     * Retrieves the ACORN record's type name.
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->_data[self::TYPE_NAME];
    }

    /**
     * Retrieves the ACORN record's group.
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->_data[self::GROUP];
    }

    /**
     * Retrieves the ACORN record's group name.
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->_data[self::GROUP_NAME];
    }

    /**
     * Retrieves the ACORN record's category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->_data[self::CATEGORY];
    }

    /**
     * Retrieves the ACORN record's category name.
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->_data[self::CATEGORY_NAME];
    }

}