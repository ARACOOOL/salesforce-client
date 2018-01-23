<?php


namespace SalesForce\Soql;

use InvalidArgumentException;

/**
 * Interface Builder
 * @package Neat\Salesforce\Soql
 */
class Builder
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var array
     */
    private $select;
    /**
     * @var array
     */
    private $where = [];

    /**
     * Builder constructor.
     * @param string $type
     * @return Builder
     */
    public function from($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param array $fields
     * @return Builder
     */
    public function select(array $fields)
    {
        $this->select = $fields;
        return $this;
    }

    /**
     * @param array $conditions
     * @return Builder
     */
    public function where(array $conditions)
    {
        $this->where = $conditions;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        if (is_null($this->type)) {
            throw new InvalidArgumentException('Tape was not set');
        }

        if (is_null($this->select)) {
            throw new InvalidArgumentException('Fields for selection were not set');
        }

        $where = $this->where;
        foreach ($where as $key => $val) {
            if (is_string($val) && !strtotime($val)) {
                $where[$key] = "$key='$val'";
            } elseif (is_bool($val)) {
                $where[$key] = $key . '=' . ($val ? 'TRUE' : 'FALSE');
            } else {
                $where[$key] = "$key=$val";
            }

        }

        return '/services/data/v20.0/query/?q=SELECT+' . implode(',', $this->select) . '+from+' . $this->type . ((count($where)) ? '+where+' . implode('+AND+', $where) : '');
    }
}