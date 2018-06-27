<?php

namespace Krlove\CodeGenerator\Model\Traits;

/**
 * Trait PHPValueTrait
 * @package Krlove\CodeGenerator\Model\Traits
 */
trait ValueTrait
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    protected function renderValue()
    {
        return $this->renderTyped($this->value);
    }

    /**
     * @param mixed $value
     * @return string|null
     */
    protected function renderTyped($value)
    {
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
                $value = $value ? 'true' : 'false';

                break;
            case 'int':
                // do nothing

                break;
            case 'string':
                $value = sprintf('\'%s\'', addslashes($value));

                break;
            case 'array':
                $parts = [];
                $isAssociative = ($this->isAssociative($value) && $this->hasStringKeys($value));
                if ($isAssociative) {
                    $tempValue = '['.PHP_EOL;
                    foreach ($value as $key => $item) {
                        $tempValue .= "\t\t'" . $key . "' => " . $this->renderTyped($item) . ',' . PHP_EOL;
                        $parts[$key] = $this->renderTyped($item);
                    }
                    $tempValue = rtrim($tempValue, ",");
                    $value = $tempValue . "\t]";

                } else {
                    foreach ($value as $item) {
                        $parts[] = $this->renderTyped($item);
                    }
                    $value = '['.PHP_EOL."\t\t" . implode(', '.PHP_EOL."\t\t", $parts) . PHP_EOL."\t]";
                }

                break;
            default:
                $value = null; // TODO: how to render null explicitly?
        }

        return $value;
    }

    private function isAssociative(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private function hasStringKeys(array $arr)
    {
        if (array() === $arr) return false;
        if (!count($arr)) return false;
        $hasKey = true;
        foreach ($arr as $key => $value) {
            return !is_numeric($key);
        }
    }
}
