<?php
class Itransition_Insurance_Helper_Data extends Mage_Core_Helper_Abstract {

    public static function getInsuranceCost($total, $type, $value)
    {
        switch ($type) {
            case Itransition_Insurance_Model_Source_Type::ABSOLUTE:
                return $value;
                break;

            case Itransition_Insurance_Model_Source_Type::PERCENT:
                return round($total / 100 * $value, 2);
                break;
        }

        return 0;
    }

    public function getTypePostfix($absolutePostfix)
    {
        return [
            Itransition_Insurance_Model_Source_Type::ABSOLUTE => $absolutePostfix,
            Itransition_Insurance_Model_Source_Type::PERCENT => '%',
        ];
    }

    public function getMessage($cost, $currency, $insuranceValue, $postfix = null, $status = null)
    {
        $description = '';

        if ($status && $postfix) {
            $description = ' (' . $status . ': ' . $insuranceValue . ' ' . $postfix . ')';
        }

        return 'Cost: ' . $cost . ' ' . $currency . $description;
    }

    public function getIsEnabled($shippingMethod)
    {
        return (bool) Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceEnable');
    }

    public function getType($shippingMethod)
    {
        return Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceType');
    }

    public function getValue($shippingMethod)
    {
        return Mage::getStoreConfig('carriers/' . $shippingMethod . '/insuranceValue');
    }


}