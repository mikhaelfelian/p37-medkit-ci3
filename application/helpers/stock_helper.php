<?php
function validate_stock_movement($current_stock, $movement_qty, $operation = 'subtract') {
    $current_stock = (float)$current_stock;
    $movement_qty = (float)$movement_qty;
    
    if ($operation === 'subtract') {
        if ($movement_qty > $current_stock) {
            return false;
        }
        return $current_stock - $movement_qty;
    } else {
        return $current_stock + $movement_qty;
    }
} 