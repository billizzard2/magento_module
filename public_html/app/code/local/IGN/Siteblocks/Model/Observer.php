<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12.1.18
 * Time: 11.38
 */

class IGN_Siteblocks_Model_Observer extends Mage_Core_Model_Abstract
{
    /**
     * После добавления товара в корзину
     * @param $observer Varien_Event_Observer
     */
    public function checkout_cart_product_add_after($observer) {
        //var_dump($observer->getEvent()->getData('quote_item')->getData()); die();
    }
}