<?php

namespace Cws\CodeGenerator\Model;

use Cws\CodeGenerator\Exception\ValidationException;

/**
 * Class VirtualPropertyModel
 * @package Cws\CodeGenerator\Model
 */
class VirtualPropertyModel extends BasePropertyModel
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var boolean
     */
    protected $readable = true;

    /**
     * @var
     */
    protected $writable = true;

    /**
     * @var bool
     */
    protected $nullable = true;

    /**
     * VirtualPropertyModel constructor.
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type = null, $nullable = true)
    {
        $this->setName($name)
            ->setType($type)
            ->setNullable($nullable);
    }

    /**
     * {@inheritDoc}
     */
    public function toLines()
    {
        if ($this->type !== null) {
            $type = null;
            switch ($this->type) {
                case "string":
                    $type = "string";
                    break;
                case "int":
                    $type = "integer";
                    break;
                case "integer":
                    $type = "integer";
                    break;
                case "boolean":
                    $type = "boolean";
                    break;
                case "mixed":
                    $type = "array";
                    break;
                case "float":
                    $type = "number";
                    break;

            }
            if (!empty($type)) {
                $property = '@OA\Property(';
                $property .= 'property="' . $this->name . '", ';
                $property .= 'description="' . $this->name . '", ';
                $property .= 'type="' . $type . '", ';
                $property .= 'nullable="' . ($this->nullable ? "true" : "false") . '", ';
                if ($type === "array") {
                    $property .= ('@OA\Items(type="object"), ');
                }
                //readOnly - writeOnly
                if (!$this->readable) {
                    $property .= 'writeOnly=true, ';
                } elseif (!$this->writable) {
                    $property .= 'readOnly=true, ';
                }
                $property = (trim($property, ", ") . "),");
                //$property .= ' ' . $this->type;


                return $property;
            }
        }
        return "";
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function getNullable()
    {
        return $this->nullable;
    }

    /**
     * @param bool $type
     *
     * @return $this
     */
    public function setNullable($nullable)
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isReadable()
    {
        return $this->readable;
    }

    /**
     * @param boolean $readable
     *
     * @return $this
     */
    public function setReadable($readable = true)
    {
        $this->readable = $readable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWritable()
    {
        return $this->writable;
    }

    /**
     * @param mixed $writable
     *
     * @return $this
     */
    public function setWritable($writable = true)
    {
        $this->writable = $writable;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function validate()
    {
        if (!$this->readable && !$this->writable) {
            throw new ValidationException('Property cannot be unreadable and unwritable at the same time');
        }
    }
}
