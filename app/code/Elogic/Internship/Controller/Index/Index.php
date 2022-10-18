<?php

declare(strict_types=1);

namespace Elogic\Internship\Controller\Index;

use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        PageFactory      $pageFactory,
        RequestInterface $request,
        RedirectFactory  $redirectFactory
    ){

        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     *  @inheriDoc
     */
    public function execute()
    {
        $page = $this->pageFactory->create();
        $store = $this->request->getParam('store');

        if (!$store) {
            return $this->redirectFactory->create()->setPath('/');
        }
        if ($store->getData() === null) {
            $page->getConfig()->getTitle()->prepend(__('No such store'));
            return $page;
        }

        $name = $store->getName();
        $page->setHeader('name', $name);
        $page->getConfig()->getTitle()->prepend($name);
        return $page;
    }
}