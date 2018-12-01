<?php
/**
 * Pagination Helper
 *
 * PHP version 5
 *
 * Copyright (C) 2018 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  View
 * @package   Jnjxp\Pagination
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2018 Jake Johns
 * @license   http://jnj.mit-license.org/2018 MIT License
 * @link      http://jakejohns.net
 */

namespace Jnjxp\Pagination\View;

use Jnjxp\Pagination\PageIteratorInterface as PageIterator;

/**
 * Pagination Theme
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 *
 * @see ThemeInterface
 */
class Theme implements ThemeInterface
{
    /**
     * Skip text
     *
     * @var string
     *
     * @access protected
     */
    protected $skip = '&hellip;';

    /**
     * Item Attributes
     *
     * @var array
     *
     * @access protected
     */
    protected $item = ['class' => 'page-item'];

    /**
     * Anchor Attributes
     *
     * @var array
     *
     * @access protected
     */
    protected $anchor = ['class' => 'page-link'];

    /**
     * Disabled Attributes
     *
     * @var array
     *
     * @access protected
     */
    protected $disabled = ['class' => 'disabled'];

    /**
     * Current page pattern
     *
     * @var string
     *
     * @access protected
     */
    protected $current  = '%s <span class="sr-only">(current)</span>';

    /**
     * Previous link data
     *
     * @var array
     *
     * @access protected
     */
    protected $previous = [
        'content' => '<span aria-hidden="true">&laquo;</span>',
        'anchor'  => ['aria-label' => 'Previous'],
        'item'    => ['class' => 'page-rel-previous']
    ];

    /**
     * Next link data
     *
     * @var array
     *
     * @access protected
     */
    protected $next = [
        'content' => '<span aria-hidden="true">&raquo;</span>',
        'anchor'  => ['aria-label' => 'Next'],
        'item'    => ['class' => 'page-rel-next']
    ];

    /**
     * Lookup for tag attributes
     *
     * @var array
     *
     * @access protected
     */
    protected $attrs = [
        PageIterator::FIRST       => ['class' => 'pager_first'],
        PageIterator::LAST        => ['class' => 'pager_last'],
        PageIterator::HEAD        => ['class' => 'pager_head'],
        PageIterator::TAIL        => ['class' => 'pager_tail'],
        PageIterator::CURRENT     => ['class' => 'pager_current active'],
        PageIterator::SKIP_BEFORE => ['class' => 'pager_ceiling'],
        PageIterator::SKIP_AFTER  => ['class' => 'pager_floor'],
    ];

    /**
     * Menu attributes
     *
     * @var array
     *
     * @access protected
     */
    protected $menu = ['class' => 'pagination'];



    /**
     * Get skip text
     *
     * @return string
     *
     * @access public
     */
    public function skip() : string
    {
        return $this->skip;
    }

    /**
     * Get standard item attributes
     *
     * @return array
     *
     * @access public
     */
    public function item() : array
    {
        return $this->item;
    }

    /**
     * Get standard anchor attributes
     *
     * @return array
     *
     * @access public
     */
    public function anchor() : array
    {
        return $this->anchor;
    }

    /**
     * Get disabled attributes
     *
     * @return array
     *
     * @access public
     */
    public function disabled() : array
    {
        return $this->disabled;
    }


    /**
     * Interpolate current page pattern
     *
     * @param mixed $page page number
     *
     * @return string
     *
     * @access public
     */
    public function current($page) : string
    {
        return sprintf($this->current, $page);
    }

    /**
     * Get previous page link settings
     *
     * @return array
     *
     * @access public
     */
    public function previous() : array
    {
        return $this->previous;
    }

    /**
     * Get next page link settings
     *
     * @return array
     *
     * @access public
     */
    public function next() : array
    {
        return $this->next;
    }

    /**
     * Get attribute array based on page tags
     *
     * @param array $tags page tags
     *
     * @return array
     *
     * @access public
     */
    public function attr(array $tags) : array
    {
        $attrs = [];

        foreach ($this->attrs as $tag => $attr) {
            if (in_array($tag, $tags)) {
                $attrs = array_merge_recursive($attrs, $attr);
            }
        }
        return $attrs;
    }

    /**
     * Get menu attributes
     *
     * @return array
     *
     * @access public
     */
    public function menu() : array
    {
        return $this->menu;
    }
}

