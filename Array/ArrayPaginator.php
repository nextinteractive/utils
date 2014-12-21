<?php
/*
 * Copyright (c) 2011-2014 Lp digital system
 *
 * This file is part of BackBee.
 *
 * BackBee5 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * BackBee is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BackBee. If not, see <http://www.gnu.org/licenses/>.
 */
namespace BackBee\Utils\Array;

/**
 * @author      c.rouillon <charles.rouillon@lp-digital.fr>
 */
class ArrayPaginator implements \Countable, \IteratorAggregate
{

    private $collection;
    private $currentPage;
    private $pageSize;

    public static function paginate(array $collection, $page = 1, $pageSize = 1)
    {
        $self = new ArrayPaginator($collection, $page, $pageSize);
        return $self;
    }

    public function __construct(array $collection, $page, $pageSize)
    {
        $this->pageSize = (int) $pageSize;
        $this->currentPage = (int) $page;
        $this->collection = array_chunk($collection, (int) $pageSize, true);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection[$this->currentPage]);
    }

    /**
     * @return type
     */
    public function count()
    {
        return count($this->collection);
    }

    public function getNextPageNumber()
    {
        if ($this->currentPage + 1 > ($this->count() - 1)) {
            return $this->count() - 1;
        } else {
            return $this->currentPage + 1;
        }
    }

    public function getPreviousPageNumber()
    {
        if ($this->currentPage - 1 < 0) {
            return 0;
        } else {
            return $this->currentPage - 1;
        }
    }

    public function isNextPage()
    {
        if ($this->currentPage + 1 > ($this->count() - 1)) {
            return false;
        } else {
            return true;
        }
    }

    public function isPreviousPage()
    {
        if ($this->currentPage - 1 < 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return type
     */
    public function getCurrentPageNumber()
    {
        return $this->currentPage;
    }
}
