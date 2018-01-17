<?php

class Itransition_Insurance_Model_Observer
{
    public function checkout_controller_onepage_save_shipping_method(Varien_Event_Observer $observe)
    {
        $params = Mage::app()->getRequest()->getParams();
        /** @var Itransition_Insurance_Helper_Data $helper */
        $helper = Mage::helper('insurance');
        $shippingMethod = $this->getShippingMethod();

        if (isset($params['s_insurance'])) {
            $isEnable = (bool) Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceEnable');
            $type = Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceType');
            $value =  Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceValue');
            if ($isEnable) {
                $total = Mage::getModel('checkout/cart')->getQuote()->getBaseSubtotal();
                $cost = $helper->getInsuranceCost($total, $type, $value);
            }
        }

        return $this;
    }

    private function getShippingMethod()
    {
        $cart = Mage::getModel('checkout/cart');
        /** @var Mage_Sales_Model_Quote $quote */
        $shippingMethod = explode('_', $cart->getQuote()->getShippingAddress()->getShippingMethod())[0];

        return $shippingMethod;
    }
}