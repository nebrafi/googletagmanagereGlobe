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

class Egits_GoogleTagManager_Block_Remarketing extends Egits_GoogleTagManager_Block_Tag 
{
    /**
     * Checking GTM and Remarketting data enabled
     * 
     * @return boolean
     */
    public function isRemarketingEnabled()
    {
        if($this->isActive() && 
            $this->helper('egits_gtm')->isActiveRemarketing()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Preaparing remarketing data
     * 
     * @return string json string
     */
    public function getRemarketingData() 
    {
        $result = array(
            'event' => 'fireRemarketingTag',
            'google_tag_params' => array()
        );

        $pageType = $this->getPageType();

        switch ($pageType) {
            case 'home':
                $result['google_tag_params'] = array(
                    'ecomm_pagetype' => $pageType
                );
                break;
            case 'searchresults':
            case 'category':
                $products = Mage::getBlockSingleton('catalog/product_list')->getLoadedProductCollection();
                $ids = '';
                foreach ($products as $item) {
                    if ($ids !== '') {
                        $ids .= ', ';
                    }
                    $ids .= "'" . $item->getSku() . "'";
                }
                $result['google_tag_params'] = array(
                    'ecomm_prodid' => '[' . $ids . ']',
                    'ecomm_pagetype' => $pageType
                );
                break;
            case 'product':
                $product = Mage::registry('current_product');
                $price = $product->getPrice();
                if ($product->getTypeId() === Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
                    $price = Mage::getModel('bundle/product_price')->getTotalPrices($product, 'min', 1);
                }
                $result['google_tag_params'] = array(
                    'ecomm_prodid' => $product->getSku(),
                    'ecomm_pagetype' => $pageType,
                    'ecomm_totalvalue' => round($price, 2),
                );
                break;
            case 'cart':
                $quote = Mage::getSingleton('checkout/cart')->getQuote();
                $grandTotal = $quote->getGrandTotal();
                $products = $quote->getAllItems();
                $ids = '';
                foreach ($products as $item) {
                    if ($ids !== '') {
                        $ids .= ', ';
                    }
                    $ids .= "'" . $item->getSku() . "'";
                }
                $result['google_tag_params'] = array(
                    'ecomm_prodid' => '[' . $ids . ']',
                    'ecomm_pagetype' => $pageType,
                    'ecomm_totalvalue' => round($grandTotal, 2),
                );
                break;
            case 'purchase':
                $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
                if ($orderId) {
                    $order = Mage::getModel('sales/order')->loadByAttribute('increment_id', $orderId);
                    $items = $order->getAllItems();
                    $ids = array();
                    foreach ($items as $item) {
                        $ids[] = $item->getProductId();
                    }
                    $products = Mage::getModel('catalog/product')
                            ->getCollection()
                            ->addAttributeToSelect('sku')
                            ->addIdFilter($ids);
                    $ids = '';
                    foreach ($products as $item) {
                        if ($ids !== '') {
                            $ids .= ', ';
                        }
                        $ids .= "'" . $item->getSku() . "'";
                    }
                    $result['google_tag_params'] = array(
                        'ecomm_prodid' => '[' . $ids . ']',
                        'ecomm_pagetype' => $pageType,
                        'ecomm_totalvalue' => round($order->getGrandTotal(), 2),
                    );
                }
                break;
            default:
                $result['google_tag_params'] = array(
                    'ecomm_pagetype' => 'siteview'
                );
                break;
        }
        
        return json_encode($result);
    }
}
