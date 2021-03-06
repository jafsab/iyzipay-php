<?php

namespace Iyzipay\Tests\Model;

use Iyzipay\Model\InstallmentInfo;
use Iyzipay\Request\RetrieveInstallmentInfoRequest;
use Iyzipay\Tests\IyzipayResourceTestCase;

class InstallmentInfoTest extends IyzipayResourceTestCase
{
    public function test_should_get_installment_info()
    {
        $this->expectHttpPost();

        $refund = InstallmentInfo::retrieve(new RetrieveInstallmentInfoRequest(), $this->options);

        $this->verifyResource($refund);
    }
}