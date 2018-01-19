<?php

class Itransition_Insurance_Model_Quote_Address_Total_Insurance extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'it_insurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }

        if ($address->getItInsurance()) {
            $address->setGrandTotal($address->getGrandTotal() + $address->getItInsurance());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getItInsurance());
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amt = $address->getItInsurance();
        $address->addTotal(
            array (
                'code' => $this->getCode(),
                'title'=>Mage::helper('insurance')->__('Shipping Insurance'),
                'value' => $amt
            )
        );

        return $this;
    }

    /**
     * @param \Mage_Sales_Model_Quote_Address $address
     * @return float|int
     */
//    protected function countInsuranceValue(Mage_Sales_Model_Quote_Address $address)
//    {
//        $type = Mage::getStoreConfig(
//            'shippinginsurance_options/insurance/insurance_type'
//        );
//        $value = Mage::getStoreConfig(
//            'shippinginsurance_options/insurance/insurance_value'
//        );
//        $subTotal = floatval($address->getSubtotal());
//        $countedValue = 0;
//
//        if ($type == 1) {
//            $countedValue = round($value, 4, PHP_ROUND_HALF_UP);
//        }
//        elseif ($type == 0) {
//            $countedValue = round(
//                $subTotal * ($value / 100),
//                4,
//                PHP_ROUND_HALF_UP
//            );
//        }
//
//        return $countedValue;
//    }

    /**
     * @param \Mage_Sales_Model_Quote_Address $address
     * @param $insuranceValue
     */
//    protected function setInsuranceValue(Mage_Sales_Model_Quote_Address $address, $insuranceValue)
//    {
//        $quote = $address->getQuote();
//        $quote->setShippingInsurance($insuranceValue);
//        $address->setShippingInsurance($insuranceValue);
//
//        if ($address->getInsuranceShippingMethod()) {
//            $address->setGrandTotal(
//                $address->getGrandTotal() + $address->getShippingInsurance()
//            );
//            $address->setBaseGrandTotal(
//                $address->getBaseGrandTotal() + $address->getShippingInsurance()
//            );
//        }
//    }
}
