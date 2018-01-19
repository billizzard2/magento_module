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

    public function adminhtml_block_system_config_init_tab_sections_before($observer) {
        /** @var Mage_Core_Model_Config_Element $section */
        $section = $observer->getSection();
        $label = $section->label;

        if ($section->label == 'Shipping Methods') {
            $groups = $section->groups;
            /** @var Mage_Core_Model_Config_Element $group */

                $groups->ups->fields->addChild('insuranceEnable');
                $groups->ups->fields->insuranceEnable->addChild('label', 'difjdifd');
                $groups->ups->fields->insuranceEnable->addChild('frontend_type', 'select');
                $groups->ups->fields->insuranceEnable->addChild('source_model', 'adminhtml/system_config_source_yesno');
                $groups->ups->fields->insuranceEnable->addChild('sort_order', '105');
                $groups->ups->fields->insuranceEnable->addChild('show_in_default', '1');
                $groups->ups->fields->insuranceEnable->addChild('show_in_website', '1');
                $groups->ups->fields->insuranceEnable->addChild('show_in_store', '0');
                //$groups->ups->fields->insuranceEnable->addChild('show_in_store', '0');

            $xmlModel = new Varien_Simplexml_Element('<node></node>');
            //$section->($xmlModel);
        }
        $a = '3';
        $b = $a;

    }

}