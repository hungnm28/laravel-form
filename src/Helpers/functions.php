<?php
if (!function_exists('lfIcon')) {
    function lfIcon($name, $width = 18, $height = 0, $viewBox = "0 0 24 24", $attribute = null)
    {
        if ($height == 0) $height = $width;
        return '
            <svg width="' . $width . 'px" height="' . $height . 'px"  viewBox="' . $viewBox . '" class="mcon" ' . $attribute . ' fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="' . env('ASSET_ICON', 'assets') . '/images/icons.svg#' . $name . '"/>
            </svg>
        ';
    }
}

function lfForm(){
    return new \Hungnm28\LaravelForm\Facades\LaravelForm();
}
