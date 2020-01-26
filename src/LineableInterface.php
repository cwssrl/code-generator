<?php

namespace Cws\CodeGenerator;

/**
 * Interface LineableInterface
 * @package Cws\CodeGenerator
 */
interface LineableInterface
{
    /**
     * @return string|string[]
     */
    public function toLines();
}
