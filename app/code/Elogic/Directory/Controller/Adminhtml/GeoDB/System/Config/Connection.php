<?php
declare(strict_types=1);

namespace Elogic\Directory\Controller\Adminhtml\GeoDB\System\Config;

use Elogic\Directory\Api\ClientInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Connection implements HttpPostActionInterface
{
    /**
     * @var Validator
     */
    private Validator $validator;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonResultFactory;

    /**
     * @param Validator $validator
     * @param RequestInterface $request
     * @param ClientInterface $client
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Validator            $validator,
        RequestInterface     $request,
        ClientInterface      $client,
        JsonFactory          $jsonFactory
    ){
        $this->validator = $validator;
        $this->request = $request;
        $this->client = $client;
        $this->jsonResultFactory = $jsonFactory;
    }

    /**
     * @return ResponseInterface|Json|ResultInterface|void
     */
    public function execute()
    {
        $result = $this->jsonResultFactory->create();

        if(!$this->validator->validate($this->request))
        {
            $result->setData(['success' => false]);
            return $result;
        }

        $response =  $this->client->testConnection(
            $this->request->getParam('x-rapidapi-key'),
            $this->request->getParam('x-rapidapi-host')
        );

        if($response)
        {
            $output = ['success' => $response,
                'message' => 'The connection is established successfully'
                ];
            $result->setData($output);
            return $result;
        }
    }
}
