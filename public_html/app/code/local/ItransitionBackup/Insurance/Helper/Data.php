<?php
class Itransition_Insurance_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getInsuranceCost($total, $type, $value)
    {
        switch ($type) {
            case Itransition_Insurance_Model_Source_Type::ABSOLUTE:
                return $value;
                break;

            case Itransition_Insurance_Model_Source_Type::PERCENT:
                return $total / 100 * $value;
                break;
        }

        return 0;
    }
}