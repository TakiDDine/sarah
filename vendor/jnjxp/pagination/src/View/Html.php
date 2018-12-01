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
 * Html
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 *
 * @see HtmlInterface
 */
class Html implements HtmlInterface
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
    public function anchor(string $content, string $url, array $attr = []) : string
    {
        $attr['href'] = $url;
        return $this->element('a', $content, $attr);
    }

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
    public function item(string $content, array $attr = []) : string
    {
        return $this->element('li', $content, $attr);
    }

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
    public function menu(array $items, array $attr = []) : string
    {
        return $this->element(
            'ul',
            "\n" . implode("\n", $items) . "\n",
            $attr
        );
    }

    /**
     * Create an HTML element
     *
     * @param string $tag     HTML tag
     * @param string $content text content
     * @param array  $attr    attribute array
     *
     * @return string
     *
     * @access protected
     */
    protected function element(string $tag, string $content, array $attr = [])
    {
        return sprintf(
            '<%s %s>%s</%1$s>',
            $tag, $this->attr($attr), $content
        );
    }

    /**
     * Create an attribute string form an array
     *
     * @param array $data attribute array
     *
     * @return string
     *
     * @access protected
     */
    protected function attr(array $data = []) : string
    {
        if (! $data) {
            return '';
        }

        $attr = array_map(
            function ($key) use ($data) {
                if (is_bool($data[$key])) {
                    return $data[$key] ? $key : '';
                }
                $val = is_array($data[$key])
                    ? implode(' ', $data[$key])
                    : $data[$key];
                return sprintf('%s="%s"', $key, $val);
            },
            array_keys($data)
        );

        return implode(' ', $attr);
    }
}
