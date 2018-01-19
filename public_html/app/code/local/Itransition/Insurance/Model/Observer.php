<?php

class Itransition_Insurance_Model_Observer
{
    public function checkout_controller_onepage_save_shipping_method(Varien_Event_Observer $observer)
    {
        $isAccepted = (bool) Mage::app()->getRequest()->getParam('s_insurance');
        $isMethod = (bool) Mage::app()->getRequest()->getParam('shipping_method');
        $params = Mage::app()->getRequest()->getParams();
        $address = $observer->getQuote()->getShippingAddress();
        if ($isMethod) {
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
            } else {
                $quote = $address->getQuote();
                $quote->setItInsurance(0);
                $address->setItInsurance(0);
            }
        }
        return $this;
    }

}