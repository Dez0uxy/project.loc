<?php

namespace frontend\components;

use yz\shoppingcart\CartActionEvent;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CostCalculationEvent;
use yz\shoppingcart\ShoppingCart as ShoppingCartOrig;


class ShoppingCart extends ShoppingCartOrig
{

    /**
     * Return full cart cost as a sum of the individual positions costs
     * @param $withDiscount
     * @return int
     */
    public function getCost($withDiscount = false)
    {
        $cost = 0;
        foreach ($this->_positions as $position) {
            $cost += $position->getCost($withDiscount) * $position->getQuantity();
        }
        $costEvent = new CostCalculationEvent([
            'baseCost' => $cost,
        ]);
        $this->trigger(self::EVENT_COST_CALCULATION, $costEvent);
        if ($withDiscount) {
            $cost = max(0, $cost - $costEvent->discountValue);
        }
        return $cost;
    }
}
