<?php

if (!function_exists('unmaskValue')) {
    /**
     * Removes the mask from the document.
     *
     * @param string $document
     * @return string
     */
    function unmaskValue(string $document): string
    {
        return preg_replace('/[^0-9]/', '', $document);
    }
}
