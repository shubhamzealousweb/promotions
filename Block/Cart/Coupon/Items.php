<?php
namespace Zealousweb\Promotions\Block\Cart\Coupon;

class Items extends \Magento\Framework\View\Element\Template
{
    protected $_postDataHelper;
    protected $_cart;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Checkout\Model\Cart $cart
    ) {
        parent::__construct($context);
        $this->_postDataHelper = $postDataHelper;
        $this->_cart = $cart;
    }

    public function getActionUrl($coupon, $remove)
    {
        return $this->_postDataHelper->getPostData($this->escapeUrl($this->getUrl('checkout/cart/couponPost')), ['coupon_code' => $coupon, 'remove' => $remove, 'form_key' => $this->getFormKey()]);
    }

    public function getCouponCode()
    {
        $cartQuote = $this->_cart->getQuote();
        return $cartQuote->getCouponCode();
    }

    public function getToDateFormat($date)
    {
        return (new \DateTime($date))->format('M d, Y');
    }
}