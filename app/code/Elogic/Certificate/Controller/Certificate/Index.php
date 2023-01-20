<?php
declare(strict_types=1);

namespace Elogic\Certificate\Controller\Certificate;

use Exception;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $page;

    /**
     * @param PageFactory $page
     */
    public function __construct(
        PageFactory $page
    ){
        $this->page = $page;
    }

    /**
     * Execute action based on request and return result
     *
     * @return Page
     * @throws Exception
     */
    public function execute()
    {
        $page = $this->page->create();

        $page->getConfig()->getTitle()->set("Elogic Validate Certificate");

        return $page;
    }
}
