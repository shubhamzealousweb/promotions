<?php
namespace Zealousweb\Promotions\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const IS_ENABLE = 'zealousweb_extensions/promotions_value/plugin';
    const GUEST_ALLOWED = 'zealousweb_extensions/promotions_value/guestcustomer';
    const UI_TYPE = 'zealousweb_extensions/promotions_value/type';
    const IS_EXPIRED = 'zealousweb_extensions/promotions_value/expired';

    protected $_scopeConfigInterface;
    protected $_couponFactory;
    protected $_customer;
    protected $_date;

    public function __construct(
      \Magento\SalesRule\Model\CouponFactory $couponFactory,
      \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
      \Magento\Customer\Model\Session $customer,
      \Magento\Framework\Stdlib\DateTime\DateTime $date
    ){
        $this->_couponFactory = $couponFactory;
        $this->_scopeConfigInterface = $scopeConfigInterface;
        $this->_customer = $customer;
        $this->_date = $date;
    }

    public function getCoupons()
    {
        $couponCollection = $this->_couponFactory->create()->getCollection();
        $couponCollection->getSelect()
            ->join(
                ['sales' => 'salesrule'],
                'main_table.rule_id = sales.rule_id AND sales.show_in_cart = 1',
                ['show_in_cart', 'name', 'description', 'to_date']
            )
            ->where('sales.is_active = ?', 1);
        if(!$this->isExpired()){
            $couponCollection->getSelect()->where('sales.to_date > ?', $this->_date->date('Y-m-d'))->orWhere('sales.to_date IS NULL');
        }
        return $couponCollection;
    }

    public function isEnable()
    {
        return $this->_scopeConfigInterface->getValue(self::IS_ENABLE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isGuestAllowed()
    {
        return $this->_scopeConfigInterface->getValue(self::GUEST_ALLOWED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isExpired()
    {
        return $this->_scopeConfigInterface->getValue(self::IS_EXPIRED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getUiType()
    {
        return $this->_scopeConfigInterface->getValue(self::UI_TYPE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getCustomerSession()
    {
        return $this->_customer;
    }

    public function getIsPopup()
    {
        return ($this->getUiType() == \Zealousweb\Promotions\Model\System\Config\Source\UiType::INOUT) ? 0 : 1;
    }
}