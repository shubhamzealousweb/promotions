<?php
namespace Zealousweb\Promotions\Block\Cart\Coupon;

class Discount extends \Magento\Framework\View\Element\Template
{
    protected $_helper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Zealousweb\Promotions\Helper\Data $helper
    ) {
        parent::__construct($context);
        $this->_helper = $helper;
    }

    public function getIsModuleEnable()
    {
        return $this->_helper->isEnable();
    }

    public function getIsGuestCustomerAllowed()
    {
        return $this->_helper->isGuestAllowed();
    }

    public function getIsPopup()
    {
        return $this->_helper->getIsPopup();
    }
}