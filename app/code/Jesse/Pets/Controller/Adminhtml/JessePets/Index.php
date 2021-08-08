<?php

namespace Jesse\Pets\Controller\Adminhtml\JessePets;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * JessePets backend index (list) controller.
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     */
    const ADMIN_RESOURCE = 'Jesse_Pets::management';

    /**
     * Execute action based on request and return result.
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Jesse_Pets::management');
        $resultPage->addBreadcrumb(__('JessePets'), __('JessePets'));
        $resultPage->addBreadcrumb(__('Manage JessePetss'), __('Manage JessePetss'));
        $resultPage->getConfig()->getTitle()->prepend(__('JessePets List'));

        return $resultPage;
    }
}
