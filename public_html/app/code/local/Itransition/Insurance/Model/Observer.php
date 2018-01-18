<?php

class Itransition_Insurance_Model_Observer
{
    public function checkout_controller_onepage_save_shipping_method(Varien_Event_Observer $observer)
    {
        $isAccepted = Mage::app()->getRequest()->getParam('s_insurance');
        $address = $observer->getQuote()->getShippingAddress();
        if ($isAccepted) {
            $shippingMethod = $address->getShippingMethod();
            if ($shippingMethod) {
                $shippingMethod = explode('_', $shippingMethod)[0];
                $isEnabled = (bool)Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceEnable');
                if ($isEnabled) {
                    $type = Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceType');
                    $value = Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceValue');
                    $insuranceCost = Itransition_Insurance_Helper_Data::getInsuranceCost($address->getSubtotal(), $type, $value);
                    $quote = $address->getQuote();
                    $quote->setItInsurance($insuranceCost);
                    $address->setItInsurance($insuranceCost);
                }
            }
        }
        return $this;
    }



//    public function checkout_controller_onepage_save_shipping_method1(Varien_Event_Observer $observer)
//    {
//        $isAddInsurance = Mage::app()->getRequest()->getParam('s_insurance');
//        /** @var Itransition_Insurance_Helper_Data $helper */
//        $helper = Mage::helper('insurance');
//        $shippingMethod = $this->getShippingMethod();
//
//        if ($isAddInsurance) {
//            $isEnable = (bool) Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceEnable');
//            $type = Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceType');
//            $value =  Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceValue');
//            if ($isEnable) {
//                $total = Mage::getModel('checkout/cart')->getQuote()->getBaseSubtotal();
//                $cost = $helper->getInsuranceCost($total, $type, $value);
//            }
//        }
//
//        return $this;
//    }
//
//    private function getShippingMethod1()
//    {
//        $cart = Mage::getModel('checkout/cart');
//        /** @var Mage_Sales_Model_Quote $quote */
//        $shippingMethod = explode('_', $cart->getQuote()->getShippingAddress()->getShippingMethod())[0];
//
//        return $shippingMethod;
//    }
}