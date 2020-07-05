<?php


namespace App\Traits;


/**
 * This trait defines the primary key as string.
 *
 * Trait PrimaryKeyAsString
 * @package App\Traits
 */
trait PrimaryKeyAsString
{
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
