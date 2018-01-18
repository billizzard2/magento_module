<?php
class Itransition_Insurance_Model_Sales_Quote_Address_Total_Block extends Mage_Sales_Model_Quote_Address_Total_Abstract{
    protected $_code = 'insurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }

        $quote = $address->getQuote();

        if(Itransition_Insurance_Model_Fee::canApply($address)){ //your business logic
            $exist_amount = $quote->getFeeAmount();
            $fee = Itransition_Insurance_Model_Block::getFee();
            $balance = $fee - $exist_amount;
            $address->setItInsurance($balance);

            $quote->setItInurance($balance);

            $address->setGrandTotal($address->getGrandTotal() + $address->getItInsurance());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getItInsurance());
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amt = $address->getItInsurance();
        $address->addTotal(array(
            'code'=>$this->getCode(),
            'title'=>Mage::helper('insurance')->__('Fee'),
            'value'=> $amt
        ));

        return $this;
    }
}