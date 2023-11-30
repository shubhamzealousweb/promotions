<?php
namespace Zealousweb\Promotions\Plugin;

class Coupon
{
    public function afterToHtml(\Magento\Checkout\Block\Cart\Coupon $coupon, $result)
    {
        $child = $coupon->getChildHtml('promotions.cart.coupon');
        return $result.$child;
    }
}