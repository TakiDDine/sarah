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

use Traversable;

/**
 * Interface: PageIterator
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     http://jakejohns.net
 */
interface PageIteratorInterface extends Traversable
{

    const PAGE_ONE = 1;

    /**
     * TAGS
     */
    const FIRST   = 'FIRST'; // first page
    const LAST    = 'LAST';  // last page
    const HEAD    = 'HEAD';  // before current page
    const TAIL    = 'TAIL';  // after current page
    const CURRENT = 'CURRENT'; // current page
    const SKIP_BEFORE = 'SKIP_BEFORE'; // skips before this page
    const SKIP_AFTER  = 'SKIP_AFTER';  // skips after this page

    /**
     * Get current page number
     *
     * @return int
     *
     * @access public
     */
    public function currentPage() : int;

    /**
     * Get previous page number
     *
     * @return int|null
     *
     * @access public
     */
    public function previousPage() : ?int;

    /**
     * Get next page number
     *
     * @return int|null
     *
     * @access public
     */
    public function nextPage() : ?int;
}
