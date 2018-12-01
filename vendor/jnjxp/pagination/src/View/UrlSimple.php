<?php
/**
 * Pagination helper
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
 * Url Helper
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 *
 * @see UrlInterface
 */
class UrlSimple implements UrlInterface
{
    /**
     * URL Prefix
     *
     * @var string
     *
     * @access protected
     */
    protected $url = '?';

    /**
     * Generate a url for a page number
     *
     * @param int|null $page page number ot generate URL for
     *
     * @return string
     *
     * @access public
     */
    public function generate($page = null) : string
    {
        if (! $page) {
            return '#';
        }
        return $this->url . http_build_query(['page' => $page]);
    }
}
