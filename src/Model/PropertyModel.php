<?php

namespace Cws\CodeGenerator\Model;

use Cws\CodeGenerator\Model\Traits\AccessModifierTrait;
use Cws\CodeGenerator\Model\Traits\DocBlockTrait;
use Cws\CodeGenerator\Model\Traits\StaticModifierTrait;
use Cws\CodeGenerator\Model\Traits\ValueTrait;

/**

 * Class PHPClassProperty
 * @package Cws\CodeGenerator\Model
 */
class PropertyModel extends BasePropertyModel
{
    use AccessModifierTrait;
    use DocBlockTrait;
    use StaticModifierTrait;
    use ValueTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * PropertyModel constructor.
     * @param string $name
     * @param string $access
     * @param mixed|null $value
     */
    public function __construct($name, $access = 'public', $value = null)
    {
        $this->setName($name)
            ->setAccess($access)
            ->setValue($value);
    }

    /**
     * {@inheritDoc}
     */
    public function toLines()
    {
        $lines = [];
        if ($this->docBlock !== null) {
            $lines = array_merge($lines, $this->docBlock->toLines());
        }

        $property = $this->access . ' ';
        if ($this->static) {
            $property .= 'static ';
        }
        $property .= '$' . $this->name;

        if ($this->value !== null) {
            $value = $this->renderValue();
            if ($value !== null) {
                $property .= sprintf(' = %s', $this->renderValue());
            }
        }
        $property .= ';';
        $lines[] = $property;

        return $lines;
    }
}
