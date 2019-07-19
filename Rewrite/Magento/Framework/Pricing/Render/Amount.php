<?php

namespace Xigen\CallForPrice\Rewrite\Magento\Framework\Pricing\Render;

/**
 * Amount renderer
 */
class Amount extends \Magento\Framework\Pricing\Render\Amount
{
    const CALL_FOR_PRICE_ENABLED = 'call_for_price/call_for_price/enabled';
    const CALL_FOR_PRICE_TEXT = 'call_for_price/call_for_price/telephone';

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->getCallForPriceEnabled() &&
            $this->getCallForPriceText() &&
            $this->getAmount()->getBaseAmount() == 0) {
            return '<p class="call-for-price">' . $this->getCallForPriceText() . '</p>';
        }
        $adjustmentRenders = $this->getAdjustmentRenders();
        if ($adjustmentRenders) {
            $adjustmentHtml = $this->getAdjustments($adjustmentRenders);
            if (!$this->hasSkipAdjustments() ||
                ($this->hasSkipAdjustments() && $this->getSkipAdjustments() == false)) {
                $this->adjustmentsHtml = $adjustmentHtml;
            }
        }
        $html = parent::_toHtml();

        return $html;
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
