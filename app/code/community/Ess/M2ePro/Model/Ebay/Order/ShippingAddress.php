<?php

/*
 * @copyright  Copyright (c) 2011 by  ESS-UA.
 */

class Ess_M2ePro_Model_Ebay_Order_ShippingAddress extends Ess_M2ePro_Model_Order_ShippingAddress
{
    public function getRawData()
    {
        return array(
            'buyer_name'     => $this->order->getChildObject()->getBuyerName(),
            'recipient_name' => $this->order->getChildObject()->getBuyerName(),
            'email'          => $this->getBuyerEmail(),
            'country_id'     => $this->getData('country_code'),
            'region'         => $this->getData('state'),
            'city'           => $this->getData('city'),
            'postcode'       => $this->getPostalCode(),
            'telephone'      => $this->getPhone(),
            'street'         => array_filter($this->getData('street'))
        );
    }

    private function getBuyerEmail()
    {
        $email = $this->order->getData('buyer_email');

        if (stripos($email, 'Invalid Request') !== false || $email == '') {
            $email = str_replace(' ', '-', strtolower($this->order->getChildObject()->getBuyerUserId()));
            $email .= Ess_M2ePro_Model_Magento_Customer::FAKE_EMAIL_POSTFIX;
        }

        return $email;
    }

    private function getPostalCode()
    {
        $postalCode = $this->getData('postal_code');

        if (stripos($postalCode, 'Invalid Request') !== false || $postalCode == '') {
            $postalCode = '0000';
        }

        return $postalCode;
    }

    private function getPhone()
    {
        $phone = $this->getData('phone');

        if (stripos($phone, 'Invalid Request') !== false || $phone == '') {
            $phone = '0000000';
        }

        return $phone;
    }
}