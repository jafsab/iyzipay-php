<?php

namespace Iyzipay\Tests\Model\Mapper;

use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\Mapper\SubMerchantMapper;
use Iyzipay\Model\Status;
use Iyzipay\Model\SubMerchant;
use Iyzipay\Model\SubMerchantType;
use Iyzipay\Tests\TestCase;

class SubMerchantMapperTest extends TestCase
{
    public function test_should_map_sub_merchant_given_approve_success_raw_result()
    {
        $json = '
            {
                "status":"success",
                "errorCode":null,
                "errorMessage":null,
                "errorGroup":null,
                "locale":"tr",
                "systemTime":"1458545234852",
                "conversationId":"123456",
                "name":"John",
                "email":"email@email.com",
                "gsmNumber":"+905555555555",
                "address":"Address",
                "iban":"iban",
                "swiftCode":"98922",
                "currency":"TRY",
                "taxOffice":"office",
                "contactName":"John",
                "contactSurname":"Doe",
                "legalCompanyTitle":"company inc",
                "subMerchantExternalId":"1234",
                "identityNumber":"4586030",
                "taxNumber":"29389232",
                "subMerchantType":"PERSONAL",
                "subMerchantKey":"O84R/fTnwj/dD15gwL10svQjOgs="

            }';

        $subMerchant = SubMerchantMapper::create($json)->jsonDecode()->mapSubMerchant(new SubMerchant());

        $this->assertNotEmpty($subMerchant);
        $this->assertEquals(Status::SUCCESS, $subMerchant->getStatus());
        $this->assertEmpty($subMerchant->getErrorCode());
        $this->assertEmpty($subMerchant->getErrorMessage());
        $this->assertEmpty($subMerchant->getErrorGroup());
        $this->assertEquals(Locale::TR, $subMerchant->getLocale());
        $this->assertEquals("1458545234852", $subMerchant->getSystemTime());
        $this->assertEquals("123456", $subMerchant->getConversationId());

        $this->assertEquals("John", $subMerchant->getName());
        $this->assertEquals("email@email.com", $subMerchant->getEmail());
        $this->assertEquals("+905555555555", $subMerchant->getGsmNumber());
        $this->assertEquals("Address", $subMerchant->getAddress());
        $this->assertEquals("iban", $subMerchant->getIban());
        $this->assertEquals("98922", $subMerchant->getSwiftCode());
        $this->assertEquals(Currency::TL, $subMerchant->getCurrency());
        $this->assertEquals("office", $subMerchant->getTaxOffice());
        $this->assertEquals("John", $subMerchant->getContactName());
        $this->assertEquals("Doe", $subMerchant->getContactSurname());
        $this->assertEquals("company inc", $subMerchant->getLegalCompanyTitle());
        $this->assertEquals("1234", $subMerchant->getSubMerchantExternalId());
        $this->assertEquals("4586030", $subMerchant->getIdentityNumber());
        $this->assertEquals("29389232", $subMerchant->getTaxNumber());
        $this->assertEquals(SubMerchantType::PERSONAL, $subMerchant->getSubMerchantType());
        $this->assertEquals("O84R/fTnwj/dD15gwL10svQjOgs=", $subMerchant->getSubMerchantKey());
        $this->assertJson($subMerchant->getRawResult());
        $this->assertJsonStringEqualsJsonString($json, $subMerchant->getRawResult());
    }

    public function test_should_map_sub_merchant_given_approve_failure_raw_result()
    {
        $json = '
            {
                "status":"failure",
                "errorCode":10000,
                "errorMessage":"error message",
                "errorGroup":"ERROR_GROUP",
                "locale":"tr",
                "systemTime":"1458545234852",
                "conversationId":"123456"
            }';

        $subMerchant = SubMerchantMapper::create($json)->jsonDecode()->mapSubMerchant(new SubMerchant());

        $this->assertNotEmpty($subMerchant);
        $this->assertEquals(Status::FAILURE, $subMerchant->getStatus());
        $this->assertEquals("10000", $subMerchant->getErrorCode());
        $this->assertEquals("error message", $subMerchant->getErrorMessage());
        $this->assertEquals("ERROR_GROUP", $subMerchant->getErrorGroup());
        $this->assertEquals(Locale::TR, $subMerchant->getLocale());
        $this->assertEquals("1458545234852", $subMerchant->getSystemTime());
        $this->assertEquals("123456", $subMerchant->getConversationId());
        $this->assertJson($subMerchant->getRawResult());
        $this->assertJsonStringEqualsJsonString($json, $subMerchant->getRawResult());
    }
}