<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductSubtotalTest extends TestCase
{
    public function test_product_subtotal_is_calculated_correctly(): void
    {
        $price = 100000;
        $quantity = 3;

        $subtotal = $price * $quantity;

        $this->assertEquals(300000, $subtotal);
    }
}