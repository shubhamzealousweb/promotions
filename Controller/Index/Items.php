<?php
namespace Zealousweb\Promotions\Controller\Index;

class Items extends \Magento\Framework\App\Action\Action
{
    protected $_jsonFactory;
    protected $_helper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Zealousweb\Promotions\Helper\Data $helper
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];

        try {
            $data = $this->_helper->getCoupons();
        } catch (\Exception $e) {
            $error = true;
        }

        return $resultJson->setData(
            [
                'error' => $error,
                'data' => json_encode($data->getData())
            ]
        );
    }
}