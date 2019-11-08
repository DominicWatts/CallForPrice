<?php

namespace Xigen\CallForPrice\Plugin\Magento\Catalog\Model;

/**
 * Product Plugin
 */
class Product
{
    const CALL_FOR_PRICE_ENABLED = 'call_for_price/call_for_price/enabled';
    const CALL_FOR_PRICE_TEXT = 'call_for_price/call_for_price/telephone';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $_scopeConfig;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Product constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    /**
     * plugin to change price.
     * @param \Magento\Catalog\Model\Product $product
     * @param float $result
     * @return mixed
     */
    public function afterGetPrice(
        \Magento\Catalog\Model\Product $product,
        $result
    ) {
        if ($this->getCallForPriceEnabled() && $product->getCallForPrice()) {
            return;
        }

        return $result;
    }

    /**
     * plugin to change is saleable.
     * @param \Magento\Catalog\Model\Product $product
     * @param bool $result
     * @return mixed
     */
    public function afterGetIsSaleable(
        \Magento\Catalog\Model\Product $product,
        $result
    ) {
        if ($this->getCallForPriceEnabled() && $product->getCallForPrice()) {
            return false;
        }

        return $result;
    }

    /**
     * plugin to change is saleable.
     * @param \Magento\Catalog\Model\Product $product
     * @param bool $result
     * @return mixed
     */
    public function afterIsSaleable(
        \Magento\Catalog\Model\Product $product,
        $result
    ) {
        if ($this->getCallForPriceEnabled() && $product->getCallForPrice()) {
            return false;
        }

        return $result;
    }

    /**
     * Get store identifier.
     * @return int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Call for price enabled.
     * @return void
     */
    public function getCallForPriceEnabled()
    {
        $callForPriceEnabled = $this->_scopeConfig->getValue(
            self::CALL_FOR_PRICE_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );

        return $callForPriceEnabled;
    }

    /**
     * Cal for price text.
     * @return void
     */
    public function getCallForPriceText()
    {
        $callForPriceText = $this->_scopeConfig->getValue(
            self::CALL_FOR_PRICE_TEXT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );

        return $callForPriceText;
    }
}
