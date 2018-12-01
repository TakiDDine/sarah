<?php
/**
 * Pagination
 *
 * PHP version 5
 *
 * Copyright (C) 2016 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  View
 * @package   Jnjxp\Pagination
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      http://jakejohns.net
 */

namespace Jnjxp\Pagination;

use Iterator;

/**
 * PageIterator
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     http://jakejohns.net
 *
 * @see Iterator
 */
class PageIterator implements Iterator, PageIteratorInterface
{
    /**
     * Position
     *
     * @var int
     *
     * @access protected
     */
    protected $position = 0;

    /**
     * Total Items
     *
     * @var int
     *
     * @access protected
     */
    protected $totalItems;

    /**
     * Current Page
     *
     * @var int
     *
     * @access protected
     */
    protected $currentPage = 1;

    /**
     * Items Per Page
     *
     * @var int
     *
     * @access protected
     */
    protected $perPage;

    /**
     * Number of pages to display beside current
     *
     * @var int
     *
     * @access protected
     */
    protected $neighbors;

    /**
     * Total Pages
     *
     * @var int
     *
     * @access protected
     */
    protected $totalPages;

    /**
     * Minimum neighboring page
     *
     * @var int|null
     *
     * @access protected
     */
    protected $floor;

    /**
     * Maximum neighboring page
     *
     * @var int|null
     *
     * @access protected
     */
    protected $ceiling;


    /**
     * __construct
     *
     * @param int $totalItems  Total items to paginate
     * @param int $perPage     Number of items per page
     * @param int $currentPage Current page number
     * @param int $neighbors   Number of current page neighbors
     *
     * @access public
     */
    public function __construct(
        int $totalItems,
        int $perPage,
        int $currentPage,
        int $neighbors = 4
    ) {
        $this->totalItems  = $totalItems;
        $this->currentPage = $currentPage;
        $this->perPage     = $perPage;
        $this->neighbors   = $neighbors;

        $this->assertValidInput();
        $this->calculate();
    }

    /**
     * Get current page number
     *
     * @return int
     *
     * @access public
     */
    public function currentPage() : int
    {
        return $this->currentPage;
    }

    /**
     * Get previous page number
     *
     * @return int|null
     *
     * @access public
     */
    public function previousPage() : ?int
    {
        $prev = $this->currentPage - 1;
        return $prev > 0 ? $prev : null;
    }

    /**
     * Get next page number
     *
     * @return int|null
     *
     * @access public
     */
    public function nextPage() : ?int
    {
        $next = $this->currentPage + 1;
        return $next <= $this->totalPages ? $next : null;
    }

    /**
     * Assert Valid Input
     *
     * @return void
     *
     * @throws LogicException If `perPage` <= 0
     * @throws LogicException If `neighbors` <= 0
     *
     * @access protected
     */
    protected function assertValidInput() : void
    {
        if ($this->perPage <= 0) {
            throw new \LogicException('Items per page must be at least 1');
        }

        if ($this->neighbors <= 0) {
            throw new \LogicException(
                'Number of neighboring pages must be at least 1'
            );
        }

        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }
    }

    /**
     * Calculate
     *
     * @return void
     *
     * @access protected
     */
    protected function calculate() : void
    {
        $this->totalPages = (int) ceil($this->totalItems / $this->perPage);

        if ($this->currentPage > $this->totalPages) {
            $this->currentPage = $this->totalPages;
        }

        $this->floor   = $this->currentPage - $this->neighbors - 1;
        $this->ceiling = $this->currentPage + $this->neighbors + 1;

        if ($this->floor < 3) {
            $this->floor = null;
        }

        if ($this->ceiling >= $this->totalPages) {
            $this->ceiling = null;
        }
    }

    /**
     * Rewind
     *
     * @return void
     *
     * @access public
     */
    public function rewind() : void
    {
        $this->position = 1;
    }

    /**
     * Current
     *
     * @return array
     *
     * @access public
     */
    public function current() : array
    {
        $tags = [];

        $possible = [
            PageIteratorInterface::FIRST       => PageIteratorInterface::PAGE_ONE,
            PageIteratorInterface::CURRENT     => $this->currentPage,
            PageIteratorInterface::LAST        => $this->totalPages,
            PageIteratorInterface::SKIP_BEFORE => $this->floor,
            PageIteratorInterface::SKIP_AFTER  => $this->ceiling,
        ];

        foreach ($possible as $tag => $condition) {
            if ($this->position == $condition) {
                $tags[] = $tag;
            }
        }

        if ($this->position > $this->currentPage) {
            $tags[] = PageIteratorInterface::TAIL;
        } elseif ($this->position < $this->currentPage) {
            $tags[] = PageIteratorInterface::HEAD;
        }

        return $tags;
    }

    /**
     * Key
     *
     * @return int
     *
     * @access public
     */
    public function key() : int
    {
        return $this->position;
    }

    /**
     * Next
     *
     * @return void
     *
     * @access public
     */
    public function next() : void
    {
        ++$this->position;

        if ($this->floor && $this->position < $this->floor) {
            $this->position = $this->floor;
            return;
        }

        if ($this->ceiling
            && $this->position > $this->ceiling
            && $this->position < $this->totalPages
        ) {
            $this->position = $this->totalPages;
        }
    }

    /**
     * Valid
     *
     * @return bool
     *
     * @access public
     */
    public function valid() : bool
    {
        return $this->position <= $this->totalPages;
    }
}
