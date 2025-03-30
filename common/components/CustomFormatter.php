<?php

namespace common\components;

use yii\i18n\Formatter;

class CustomFormatter extends Formatter
{
    public function asCurrency($value, $currency = null, $options = [], $textOptions = [])
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        $normalizedValue = $this->normalizeNumericValue($value);

        $currency = $currency ?: $this->currencyCode;

        if ($currency === 'UAH') {
            return $this->asDecimal($normalizedValue, 0, $options, $textOptions) . ' грн.';
        }

        if ($currency === 'USD') {
            return '$' . $this->asDecimal($normalizedValue, 2, $options, $textOptions);
        }

        if ($currency === 'EUR') {
            return $this->asDecimal($normalizedValue, 2, $options, $textOptions) . '€';
        }

        return parent::asCurrency($value, $currency, $options, $textOptions);
    }
}
