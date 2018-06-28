<?php

namespace Cws\CodeGenerator;

/**
 * Interface RenderableInterface
 * @package Cws\CodeGenerator
 */
interface RenderableInterface
{
    /**
     * @param int $indent
     * @param string $delimiter
     * @return string
     */
    public function render($indent = 0, $delimiter = PHP_EOL);
}
