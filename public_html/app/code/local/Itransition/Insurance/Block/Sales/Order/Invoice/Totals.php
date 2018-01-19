<?php
class Itransition_Insurance_Block_Sales_Order_Invoice_Totals extends Mage_Sales_Block_Order_Invoice_Totals
{
    protected $_code = 'it_insurance';

    protected function _initTotals()
    {
        parent::_initTotals();
        $order = $this->getOrder();
        $amount = $order->getItInsurance();
        $this->addTotalBefore(
            new Varien_Object(
                [
                    'code' => $this->getCode(),
                    'value' => $amount,
                    'base_value' => $amount,
                    'label' => $this->helper('insurance')->__('Insurance')
                ],
                'grand_total'
            )
        );

        return $this;
    }
}
