<?php

/**
 * Query filter
 *
 * @uses Elastica_Filter_Query
 * @category Xodoa
 * @package Elastica
 * @author Nicolas Ruflin <spam@ruflin.com>
 */
class Elastica_Filter_Query extends Elastica_Filter_Abstract
{
    /**
     * Query
     * @var array
     */
    protected $_query;

    /**
     * Construct query filter
     *
     * @param array|Elastica_Query_Abstract $query
     */
    public function __construct($query = null)
    {
        if (!is_null($query)) {
            $this->setQuery($query);
        }
    }

    /**
     * Set query
     *
     * @param  array|Elastica_Query_Abstract $query
     * @return Elastca_Filter_Query          Query object
     * @throws Elastica_Exception_Invalid    Invalid param
     */
    public function setQuery($query)
    {
        if (!$query instanceof Elastica_Query_Abstract && ! is_array($query)) {
            throw new Elastica_Exception_Invalid('expected an array or instance of Elastica_Query_Abstract');
        }

        if ($query instanceof Elastica_Query_Abstract) {
            $query = $query->toArray();
        }

        $this->_query = $query;

        return $this;
    }

    /**
     * @see Elastica_Param::_getName()
     */
    protected function _getName()
    {
        if (empty($this->_params)) {
            return parent::_getName();
        } else {
            return 'fquery';
        }
    }

    /**
     * @see Elastica_Param::toArray()
     */
    public function toArray()
    {
        $data = parent::toArray();

        $name = $this->_getName();
        $filterData = $data[$name];

        if (empty($filterData)) {
            $filterData = $this->_query;
        } else {
            $filterData['query'] = $this->_query;
        }

        $data[$name] = $filterData;

        return $data;
    }
}
