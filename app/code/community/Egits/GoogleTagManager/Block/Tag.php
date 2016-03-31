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

class Egits_GoogleTagManager_Block_Tag extends Mage_Core_Block_Template
{
    /**
     * Return module status
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->helper('egits_gtm')->isActive();
    }

    /**
     * Return container id
     *
     * @return mixed
     */
    public function getContainerId()
    {
        if (!$this->helper('egits_gtm')->isContainerEnabled() && 
                $this->helper('egits_gtm')->getContainerId()) {
            return $this->helper('egits_gtm')->getContainerId();            
        }
        
        return false;
    }
    
    /**
     * Return container script
     *
     * @return string
     */
    public function getContainer()
    {
        return $this->helper('egits_gtm')->getContainer();
    }
}
