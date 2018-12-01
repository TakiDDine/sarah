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

/**
 *  Interface Pagination Theme
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 *
 * @see ThemeInterface
 */
interface ThemeInterface
{
    /**
     * Get skip text
     *
     * @return string
     *
     * @access public
     */
    public function skip() : string;

    /**
     * Get standard item attributes
     *
     * @return array
     *
     * @access public
     */
    public function item() : array;

    /**
     * Get standard anchor attributes
     *
     * @return array
     *
     * @access public
     */
    public function anchor() : array;

    /**
     * Get disabled attributes
     *
     * @return array
     *
     * @access public
     */
    public function disabled() : array;


    /**
     * Interpolate current page pattern
     *
     * @param mixed $page page number
     *
     * @return string
     *
     * @access public
     */
    public function current($page) : string;

    /**
     * Get previous page link settings
     *
     * @return array
     *
     * @access public
     */
    public function previous() : array;

    /**
     * Get next page link settings
     *
     * @return array
     *
     * @access public
     */
    public function next() : array;

    /**
     * Get attribute array based on page tags
     *
     * @param array $tags page tags
     *
     * @return array
     *
     * @access public
     */
    public function attr(array $tags) : array;

    /**
     * Get menu attributes
     *
     * @return array
     *
     * @access public
     */
    public function menu() : array;
}


