<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Data\Bank\BankCode;
use App\Data\Demo\DemoFormId;
use App\Data\Order\DisplayOrderId;
use Tests\TestCase;

class ValueObjectTest extends TestCase
{
    /**
     * @return void
     */
    public function test_demo_form_id(): void
    {
        $this->assertTrue(DemoFormId::tryFromIntString('-1') === null);
        $this->assertTrue(DemoFormId::tryFromIntString('+1') === null);
        $this->assertTrue(DemoFormId::tryFromIntString('0') === null);
        $this->assertTrue(DemoFormId::tryFromIntString('1') === null);
        $this->assertTrue(DemoFormId::tryFromIntString('99') === null);
        $this->assertTrue(DemoFormId::tryFromIntString('100')?->getInt() === 100);
        $this->assertTrue(DemoFormId::tryFromIntString('101')?->getInt() === 101);
        $this->assertTrue(DemoFormId::tryFromIntString('+101') === null);
    }

    /**
     * @return void
     */
    public function test_order_display_id(): void
    {
        $this->assertTrue(DisplayOrderId::tryFromIntString('-1') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('+1') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('0') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('1') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('99') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('100') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('101') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('201006100') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('201006101')?->getInt() === 201006101);
        $this->assertTrue(DisplayOrderId::tryFromIntString('+201006101') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('201006102') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('201999991')?->getInt() === 201999991);
        $this->assertTrue(DisplayOrderId::tryFromIntString('999999991')?->getInt() === 999999991);
        $this->assertTrue(DisplayOrderId::tryFromIntString('999999999') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('1000000000') === null);
        $this->assertTrue(DisplayOrderId::tryFromIntString('1000000001') === null);
        $this->assertTrue(DisplayOrderId::makeWithIncr(0)?->getInt() === (201006101));
        $this->assertTrue(DisplayOrderId::makeWithIncr(1)?->getInt() === (201006111));
        $this->assertTrue(DisplayOrderId::makeWithIncr(100)?->getInt() === (201007101));
        $this->assertTrue(DisplayOrderId::makeWithIncr(100)?->getIncrementInt() === (100));
    }

    /**
     * @return void
     */
    public function test_bank_code(): void
    {
        $this->assertTrue(BankCode::tryFromString('-1') === null);
        $this->assertTrue(BankCode::tryFromString('+1') === null);
        $this->assertTrue(BankCode::tryFromString('0') === null);
        $this->assertTrue(BankCode::tryFromString('1') === null);
        $this->assertTrue(BankCode::tryFromString('99') === null);
        $this->assertTrue(BankCode::tryFromString('100') === null);
        $this->assertTrue(BankCode::tryFromString('101') === null);
        $this->assertTrue(BankCode::tryFromString('201006100') === null);
        $this->assertTrue(BankCode::tryFromString('0000')?->getString() === '0000');
        $this->assertTrue(BankCode::tryFromString('0001')?->getString() === '0001');
        $this->assertTrue(BankCode::tryFromString('0002')?->getString() === '0002');
        $this->assertTrue(BankCode::tryFromString('4567')?->getString() === '4567');
        $this->assertTrue(BankCode::tryFromString('1000')?->getString() === '1000');
        $this->assertTrue(BankCode::tryFromString('9999')?->getString() === '9999');
        $this->assertTrue(BankCode::tryFromString('10000') === null);
        $this->assertTrue(BankCode::tryFromString('-1000') === null);
        $this->assertTrue(BankCode::tryFromString('+1000') === null);
        $this->assertTrue(BankCode::fromNullable(null) === null);
        $this->assertTrue(BankCode::fromNullable(BankCode::from('0000'))?->getString() === '0000');
        $this->assertTrue(BankCode::from(BankCode::from('0000'))->getString() === '0000');
    }
}
