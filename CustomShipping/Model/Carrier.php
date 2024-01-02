<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Customshipping
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Ceymox\CustomShipping\Model;

use Magento\Quote\Model\Quote\Address\RateResult\Error;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Simplexml\Element;

class Carrier extends AbstractCarrier implements CarrierInterface
{
    const CODE = 'wkcustomshipping';
    protected $_code = self::CODE;
    
    public function __construct(
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        protected \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        protected \Psr\Log\LoggerInterface $logger,
        protected \Magento\Shipping\Model\Rate\ResultFactory $rateFactory,
        protected \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        protected \Magento\Shipping\Model\Tracking\ResultFactory $trackFactory,
        protected \Magento\Shipping\Model\Tracking\Result\ErrorFactory $trackErrorFactory,
        protected \Magento\Shipping\Model\Tracking\Result\StatusFactory $trackStatusFactory,
        protected \Magento\Directory\Model\RegionFactory $regionFactory,
        protected \Magento\Directory\Model\CountryFactory $countryFactory,
        protected \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        protected \Magento\Directory\Helper\Data $directoryData,
        protected \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        protected \Magento\Framework\Locale\FormatInterface $localeFormat,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function getAllowedMethods()
    {
    }
    
    /**
     * Collect and get rates
     *
     * @param RateRequest $request
     * @return Result|bool|null
     */
    public function collectRates(RateRequest $request)
    {   


        $specificCountry = 'IN';
        $specificState = 586;

        //testing
        $countryId = $request->getDestCountryId();
        $regionId = $request->getDestRegionId();

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('test');
        $logger->info($countryId);
        $logger->info($regionId);



        //testing

        if ($countryId == $specificCountry && $specificState == $regionId) {
            $result = $this->rateFactory->create();
            $method = $this->rateMethodFactory->create();
            $method->setCarrier($this->_code);
            $method->setCarrierTitle('Webkul custom Shipping');
            /* Set method name */
            $method->setMethod($this->_code);
            $method->setMethodTitle('Webkul Custom Shipping');
            $method->setCost(10);
            /* Set shipping charge */
            $method->setPrice(10);
            $result->append($method);
            return $result; 
        }

    }

//     /**
//  * Collect and get rates
//  *
//  * @param RateRequest $request
//  * @return Result|bool|null
//  */
// public function collectRates(RateRequest $request)
// {   

//     $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
//     $logger = new \Zend_Log($writer);
    
//     $logger->info('testxddd');

//     // Check if the specific country and state are set in the request
//     $shippingAddress = $request->getShippingAddress();
//     $specificCountry = 'IN';
//     $specificState = 'KL';

//     $regionId = $shippingAddress->getRegionId();
//     $countryId = $shippingAddress->getCountryId();


//     $destCountryId = $request->getDestCountryId();
//     $destState = $request->getDestRegionCode();
//     $destCity = $request->getDestCity();

//     $logger->info(print_r($shippingAddress, true));

//     $logger->info('Region ID: ' . $destCity);
//     $logger->info('Country ID: ' . $destCountryId);
//     $logger->info('Country ID: ' . $destState);



//     if ($shippingAddress && $shippingAddress->getCountryId() == $specificCountry && $shippingAddress->getRegionId() == $specificState) {

//         $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
//         $logger = new \Zend_Log();
//         $logger->addWriter($writer);
//         $logger->info('test1');

//         // The custom shipping method should be available for the specific country and state
//         $result = $this->rateFactory->create();
//         $method = $this->rateMethodFactory->create();
//         $method->setCarrier($this->_code);
//         $method->setCarrierTitle('Webkul custom Shipping');
//         $method->setMethod($this->_code);
//         $method->setMethodTitle('Webkul Custom Shipping');
//         $method->setCost(10);
//         $method->setPrice(10);
//         $result->append($method);

//         return $result;
//     }

//     // If not the specific country and state, return null to indicate that the method is not available
//     return null;
// }

    
    /**
     * Processing additional validation to check is carrier applicable.
     *
     * @param \Magento\Framework\DataObject $request
     * @return $this|bool|\Magento\Framework\DataObject
     */
    public function proccessAdditionalValidation(\Magento\Framework\DataObject $request) {
        return true;
    }
}