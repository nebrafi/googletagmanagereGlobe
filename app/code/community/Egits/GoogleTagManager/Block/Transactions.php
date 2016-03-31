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

class Egits_GoogleTagManager_Block_Transactions extends Egits_GoogleTagManager_Block_Tag
{
    protected $_orderId = 0;

    /**
     * Constructor
     */
    function __construct()
    {
        $this->_orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
    }
    
    /**
     * Checking GTM and Transaction enabled
     * 
     * @return boolean
     */
    public function isTranactionsEnabled()
    {
        if($this->isActive() && 
            $this->helper('egits_gtm')->isActiveTransaction()) {
            return true;
        }
        
        return false;
    }

    /**
     * Preparing transaction data
     * 
     * @return string json transaction data
     */
    public function getTransactionsData()
    {
        $helper = $this->helper('egits_gtm');
        $data = array();

        if ($this->_orderId) {
            $order = Mage::getModel('sales/order')->loadByAttribute('increment_id', $this->_orderId);
            $items = $order->getAllVisibleItems();
            $products = $this->_getProducts($items);
            $priceAll = 0;
            foreach ($products as $item) {
                $priceAll += $item['price'] * $item['quantity'];
            }

            $data = array(
                'transactionId'          => $order->getIncrementId(),
                'transactionAffiliation' => $helper->getTransactionAffiliation(),
                'transactionTotal'       => $priceAll,
                'transactionTax'         => '',
                'transactionShipping'    => round($order->getShippingAmount(), 2),
                'transactionProducts'    => $products
            );
        }

        return json_encode($data);
    }

    /**
     * Preaparing order data from cart or order items
     * 
     * @param object cart or order items in magento
     * @return array Mage_Catalog_Product objests
     */
    protected function _getProducts($items)
    {
        $products = array();
        foreach ($items as $orderItem) {
            if (intval($orderItem->getPrice()) === 0) {
                continue;
            }
            $price = $orderItem->getPrice();
            $product = Mage::getModel('catalog/product')->load($orderItem->getProductId());
            $categoryIds = $product->getCategoryIds();
            $category = Mage::getModel('catalog/category')->load($categoryIds[0]);
            $products[] = array(
                'sku'      => $orderItem->getSku(),
                'name'     => $orderItem->getName(),
                'category' => $category->getName(),
                'price'    => round($price, 2),
                'quantity' => (int)$orderItem->getQty_ordered()
            );
        }

        return $products;
    }
}
