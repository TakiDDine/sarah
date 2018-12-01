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

namespace Jnjxp\Pagination;

/**
 * Factory
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 */
class Factory
{
    /**
     * Create new PageIterator
     *
     * @param int $totalItems  total number of items
     * @param int $perPage     number of items per page
     * @param int $currentPage current page displayed
     * @param int $neighbors   number of pages to show next to current
     *
     * @return PageIterator
     *
     * @access public
     */
    public function newIterator(
        int $totalItems,
        int $perPage,
        int $currentPage = 1,
        int $neighbors = 4
    ) : PageIteratorInterface {
        return new PageIterator(
            $totalItems,
            $perPage,
            $currentPage,
            $neighbors
        );
    }

    /**
     * Create new renderable view from iterator
     *
     * @param PageIterator        $iterator The pages to render
     * @param View\UrlInterface   $url      URL Helper
     * @param View\ThemeInterface $theme    Theme definition
     * @param View\HtmlInterface  $html     HTML helper
     *
     * @return View
     *
     * @access public
     */
    public function newView(
        PageIteratorInterface $iterator,
        View\UrlInterface $url = null,
        View\ThemeInterface $theme = null,
        View\HtmlInterface $html = null
    ) : View {
        return new View(
            $iterator,
            $url ?? $this->newUrl(),
            $theme ?? $this->newTheme(),
            $html ?? $this->newHtml()
        );
    }

    /**
     * Create new URL helper
     *
     * @return View\UrlInterface
     *
     * @access public
     */
    public function newUrl() : View\UrlInterface
    {
        return new View\Url();
    }

    /**
     * Create new HTML helper
     *
     * @return View\HtmlInterface
     *
     * @access public
     */
    public function newHtml() : View\HtmlInterface
    {
        return new View\Html();
    }

    /**
     * Create new Paginaiton Theme
     *
     * @return View\ThemeInterface
     *
     * @access public
     */
    public function newTheme() : View\ThemeInterface
    {
        return new View\Theme();
    }
}
