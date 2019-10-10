<?php
namespace Core;

class ValidateHelper
{
    /**
     * validate page input
     * @param $page
     * @return int
     */
    public static function validatePage($page): int
    {
        return $page < 1 || !is_numeric($page) ? 1 : $page;
    }

    /**
     * validate order direction
     * @param $orderDirection
     * @return string
     */
    public static function validateOrderDirection($orderDirection): string
    {
        $orderDirection = strtoupper($orderDirection);

        return $orderDirection != 'DESC' && $orderDirection != 'ASC' ? 'DESC' : $orderDirection;
    }
}