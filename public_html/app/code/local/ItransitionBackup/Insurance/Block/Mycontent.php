<?php
class Itransition_Insurance_Block_Mycontent extends Mage_Core_Block_Template
{

    public function getInsuranceData()
    {
        $info = [];
        $data = Mage::getModel('checkout/session')->getQuote()->getData();

        $statuses = Mage::getModel('insurance/source_type')->toArray();

        $typePostfixes = [
            Itransition_Insurance_Model_Source_Type::ABSOLUTE => $data['quote_currency_code'],
            Itransition_Insurance_Model_Source_Type::PERCENT => '%',
        ];

        $activeMethods = Mage::getSingleton('shipping/config')->getActiveCarriers();
        /** @var Itransition_Insurance_Helper_Data $helper */
        $helper = Mage::helper('insurance');

        foreach ($activeMethods as $key => $activeMethod) {
            $isEnabled = $this->_getIsEnabled($key);
            $type = $this->_getType($key);
            $value = $this->_getValue($key);
            $cost = $helper->getInsuranceCost($data['base_subtotal'], $type, $value);
            $description = '';

            if (isset($statuses[$type]) && isset($typePostfixes[$type])) {
                $description = ' (' . $statuses[$type] . ': ' . $value . ' ' . $typePostfixes[$type] . ')';
            }

            $info[] = [
                'method' => $key,
                'isEnabled' => $isEnabled,
                'message' => 'Cost: ' . $cost . ' ' . $data['quote_currency_code'] . $description
            ];
        }

        return $info;
    }



//    public function isInsuranceEnabled()
//    {
//        return $this->getIsEnabled($this->getShippingMethod());
//    }

//    public function getInsuranceType()
//    {
//        $statuses = Mage::getModel('insurance/source_type')->toArray();
//        $type = $this->getType($this->getShippingMethod());
//        return isset($statuses[$type]) ? $statuses[$type] : null;
//    }
//
//    public function getInsuranceValue()
//    {
//        return $this->getValue($this->getShippingMethod());
//    }
//
//    public function getTypePostfix()
//    {
//        $quote = Mage::getModel('checkout/session')->getQuote();
//        $data = $quote->getData();
//        return (int)$this->getType($this->getShippingMethod()) === Itransition_Insurance_Model_Source_Type::PERCENT
//            ? '%'
//            : $data['quote_currency_code'];
//    }

//    public function getBlocks()
//    {
//        $isEnabled = Mage::getStoreConfig('carriers/flatrate/insuranceEnable');
//        $totalItems = Mage::getModel('checkout/cart');
//        /** @var Mage_Sales_Model_Quote $quote */
//        $quote = $totalItems->getQuote();
//        $total = $quote->getBaseGrandTotal();
//
//        if ($isEnabled) {
//
//        }
//
//        return 'dfdfdfdfd';
//    }
//    public function getInsuranceCost1($total, $type, $value)
//    {
//        $quote = Mage::getModel('checkout/session')->getQuote();
//        $data = $quote->getData();
//        switch ($this->getType($shippingMethod)) {
//            case Itransition_Insurance_Model_Source_Type::ABSOLUTE:
//                return $this->getInsuranceValue() . ' ' . $data['quote_currency_code'];
//                break;
//
//            case Itransition_Insurance_Model_Source_Type::PERCENT:
//                return ($data['base_subtotal'] / 100 * $this->getInsuranceValue()) . ' ' . $data['quote_currency_code'];
//                break;
//        }
//
//        return 0;
//    }

    private function _getIsEnabled($shippingMethod)
    {
        return (bool) Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceEnable');
    }

    private function _getType($shippingMethod)
    {
        return Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceType');
    }

    private function _getValue($shippingMethod)
    {
        return Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceValue');
    }
}