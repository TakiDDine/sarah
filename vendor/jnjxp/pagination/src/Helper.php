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
 * Pagination Helper
 *
 * @category View
 * @package  Jnjxp\Pagination
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 */
class Helper
{
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
     * Number of pages to show beside current page
     *
     * @var int
     *
     * @access protected
     */
    protected $neighbors = 4;

    /**
     * URL Helper
     *
     * @var View\UrlInterface
     *
     * @access protected
     */
    protected $url;

    /**
     * Theme definition
     *
     * @var View\ThemeInterface
     *
     * @access protected
     */
    protected $theme;

    /**
     * HTML Helper
     *
     * @var View\HtmlInterface
     *
     * @access protected
     */
    protected $html;

    /**
     * Pagination Factory
     *
     * @var Factory
     *
     * @access protected
     */
    protected $factory;


    /**
     * Create Pagination Helper
     *
     * @param Factory|null $factory pagination factory
     *
     * @access public
     */
    public function __construct(Factory $factory = null)
    {
        $this->factory = $factory ?? new Factory();
    }

    /**
     * Configure pagiantion
     *
     * @param array $settings settings to change
     *
     * @return self
     *
     * @access public
     */
    public function __invoke(array $settings = []) : self
    {
        foreach ($settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }

    /**
     * Set total items
     *
     * @param int $total total items
     *
     * @return self
     *
     * @access public
     */
    public function totalItems(int $total) : self
    {
        $this->totalItems = $total;
        return $this;
    }

    /**
     * Set number of items per page
     *
     * @param int $perPage number of items per page
     *
     * @return self
     *
     * @access public
     */
    public function perPage(int $perPage) : self
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Set current page number
     *
     * @param int $page current page
     *
     * @return self
     *
     * @access public
     */
    public function currentPage(int $page) : self
    {
        $this->currentPage = $page;
        return $this;
    }

    /**
     * Set number of neighbors
     *
     * @param int $neighbors number of neighbors
     *
     * @return self
     *
     * @access public
     */
    public function neighbors(int $neighbors) : self
    {
        $this->neighbors = $neighbors;
        return $this;
    }

    /**
     * Set URL helper
     *
     * @param View\UrlInterface $url URL Helper
     *
     * @return self
     *
     * @access public
     */
    public function url(View\UrlInterface $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set Theme
     *
     * @param View\ThemeInterface $theme theme definition
     *
     * @return mixed
     *
     * @access public
     */
    public function theme(View\ThemeInterface $theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Set HTML helper
     *
     * @param View\HtmlInterface $html HTML Helper
     *
     * @return mixed
     *
     * @access public
     */
    public function html(View\HtmlInterface $html)
    {
        $this->html = $html;
    }

    /**
     * Get Page Iterator
     *
     * @return PageIterator
     *
     * @access public
     */
    public function getPages() : PageIterator
    {
        return $this->factory->newIterator(
            $this->totalItems,
            $this->perPage,
            $this->currentPage,
            $this->neighbors
        );
    }

    /**
     * Get pagination view
     *
     * @return View
     *
     * @access public
     */
    public function getView() : View
    {
        $pages = $this->getPages();
        $view  = $this->factory->newView(
            $pages,
            $this->url,
            $this->theme,
            $this->html
        );
        return $view;
    }

    /**
     * __toString
     *
     * @return string
     *
     * @access public
     */
    public function __toString() : string
    {
        return (string) $this->getView();
    }
}
