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
 * Interface: Html
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 */
interface HtmlInterface
{
    /**
     * Create an anchor
     *
     * @param string $content text content
     * @param string $url     url
     * @param array  $attr    attribute array
     *
     * @return string
     *
     * @access public
     */
    public function anchor(string $content, string $url, array $attr = []) : string;

    /**
     * Create a list item
     *
     * @param string $content text content
     * @param array  $attr    attribute array
     *
     * @return string
     *
     * @access public
     */
    public function item(string $content, array $attr = []) : string;

    /**
     * Create a menu
     *
     * @param array $items menu items
     * @param array $attr  attribute array
     *
     * @return string
     *
     * @access public
     */
    public function menu(array $items, array $attr = []) : string;

}
