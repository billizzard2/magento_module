<?php
class Itransition_Insurance_Block_Mycontent extends Mage_Core_Block_Template
{
    private $_shippingMethod;
    private $_isEnabled;
    private $_type;
    private $_value;

    public function getBlocks()
    {
        $isEnabled = Mage::getStoreConfig('carriers/flatrate/insuranceEnable');
        $totalItems = Mage::getModel('checkout/cart');
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = $totalItems->getQuote();
        $total = $quote->getBaseGrandTotal();
        if ($isEnabled) {

        }

        return 'dfdfdfdfd';
    }

    public function isInsuranceEnabled()
    {
        return $this->getIsEnabled($this->getShippingMethod());
    }

    public function getInsuranceType()
    {
        $statuses = Mage::getModel('insurance/source_type')->toArray();
        $type = $this->getType($this->getShippingMethod());
        return isset($statuses[$type]) ? $statuses[$type] : null;
    }

    public function getInsuranceValue()
    {
        return $this->getValue($this->getShippingMethod());
    }

    public function getTypePostfix()
    {
        $quote = Mage::getModel('checkout/session')->getQuote();
        $data = $quote->getData();
        return (int)$this->getType($this->getShippingMethod()) === Itransition_Insurance_Model_Source_Type::PERCENT
            ? '%'
            : $data['quote_currency_code'];
    }


    public function getInsuranceCost()
    {
        $quote = Mage::getModel('checkout/session')->getQuote();
        $data = $quote->getData();
        switch ($this->getType($this->getShippingMethod())) {
            case Itransition_Insurance_Model_Source_Type::ABSOLUTE:
                return $this->getInsuranceValue() . ' ' . $data['quote_currency_code'];
                break;

            case Itransition_Insurance_Model_Source_Type::PERCENT:
                return ($data['base_subtotal'] / 100 * $this->getInsuranceValue()) . ' ' . $data['quote_currency_code'];
                break;
        }

        return 0;
    }

    private function getShippingMethod()
    {
        if (!$this->_shippingMethod) {
            $cart = Mage::getModel('checkout/cart');
            /** @var Mage_Sales_Model_Quote $quote */
            $this->_shippingMethod = explode('_', $cart->getQuote()->getShippingAddress()->getShippingMethod())[0];

        }
        return $this->_shippingMethod;
    }

    private function getIsEnabled($shippingMethod)
    {
        if (!$this->_isEnabled && $shippingMethod) {
            $this->_isEnabled = (bool) Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceEnable');
        }
        return $this->_isEnabled;
    }

    private function getType($shippingMethod)
    {
        if (!$this->_type && $shippingMethod) {
            $this->_type = Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceType');
        }
        return $this->_type;
    }

    private function getValue($shippingMethod)
    {
        if (!$this->_value && $shippingMethod) {
            $this->_value = Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceValue');
        }
        return $this->_value;
    }
}