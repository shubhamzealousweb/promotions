<?php
namespace Zealousweb\Promotions\Model\System\Config\Source;

class UiType implements \Magento\Framework\Option\ArrayInterface
{
    const POPUP = 'popup';
    const INOUT = 'in-out';

    public function toOptionArray()
    {
        return [
            [
                'value' => SELF::POPUP,
                'label' => 'Popup'
            ],
            [
                'value' => SELF::INOUT,
                'label' => 'Slide In/Slide Out'
            ],
        ];
    }
}