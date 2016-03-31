<?php

/**
 * eGlobe IT Solutions (P)Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.eglobeits.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hello@eglobeits.com so we can send you a copy immediately.
 *
 * =================================================================
 *                     MAGENTO USAGE NOTICE
 * =================================================================
 * This package designed & developed for Magento COMMUNITY edition
 * eGits does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * eGits does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   Egits
 * @package    Egits_GoogleTagManager
 * @version    0.1.0
 * @copyright  Copyright (c) 2015-2016 eGlobe IT Solutions (P)Ltd. (http://www.eglobeits.com/)
 * @author     eGits Team <hello@eglobeits.com>
 * @license    http://ecommerce.eglobeits.com/license.txt
 */

class Egits_GoogleTagManager_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED                  = 'egits_gtm/general/active';
    const XML_PATH_ENABLE_CONTAINER         = 'egits_gtm/general/container_enabled';
    const XML_PATH_CONTAINER                = 'egits_gtm/general/container';
    const XML_PATH_CONTAINER_ID             = 'egits_gtm/general/container_id';
    const XML_PATH_ENABLE_REMARKETING       = 'egits_gtm/remarketing/active';
    const XML_PATH_ENABLE_TRANSACTION       = 'egits_gtm/transaction/active';
    const XML_PATH_TRANSACTION_AFFILIATION  = 'egits_gtm/transaction/affiliation';

    /**
     * Return module status
     *
     * @return mixed
     */
    public function isActive()
    {
        return Mage::getStoreConfig(self::XML_PATH_ENABLED);
    }

    /**
     * Return container id
     *
     * @return mixed
     */
    public function getContainerId()
    {
        return Mage::getStoreConfig(self::XML_PATH_CONTAINER_ID);
    }
    
    /**
     * Return container enabled
     *
     * @return mixed
     */
    public function isContainerEnabled()
    {
        return Mage::getStoreConfig(self::XML_PATH_ENABLE_CONTAINER);
    }
    
    /**
     * Return container id
     *
     * @return mixed
     */
    public function getContainer()
    {
        return Mage::getStoreConfig(self::XML_PATH_CONTAINER);
    }

    /**
     * Return remarketing status
     *
     * @return mixed
     */
    public function isActiveRemarketing()
    {
        return Mage::getStoreConfig(self::XML_PATH_ENABLE_REMARKETING);
    }

    /**
     * Return transaction status
     *
     * @return mixed
     */
    public function isActiveTransaction()
    {
        return Mage::getStoreConfig(self::XML_PATH_ENABLE_TRANSACTION);
    }

    /**
     * Return transaction affiliation
     *
     * @return string
     */
    public function getTransactionAffiliation()
    {
        return Mage::getStoreConfig(self::XML_PATH_TRANSACTION_AFFILIATION);
    }
}