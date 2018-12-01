<?php
/**
 * Pagiantion Helper
 *
 * PHP version 5
 *
 * Copyright (C) 2018 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  View
 * @package   Jnjxp\Pagaintion
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2018 Jake Johns
 * @license   http://jnj.mit-license.org/2018 MIT License
 * @link      http://jakejohns.net
 */

namespace Jnjxp\Pagination;

use Jnjxp\Pagination\PageIteratorInterface as PageIterator;

/**
 * Render a pagination navigation element
 *
 * @category View
 * @package  Jnjxp\Pagaintion
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  https://jnj.mit-license.org/ MIT License
 * @link     https://jakejohns.net
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class View
{
    /**
     * Url Helper
     *
     * @var View\UrlInterface
     *
     * @access protected
     */
    protected $url;

    /**
     * Html Helper
     *
     * @var View\HtmlInterface
     *
     * @access protected
     */
    protected $html;

    /**
     * Theme Settings
     *
     * @var View\ThemeInterface
     *
     * @access protected
     */
    protected $theme;

    /**
     * PageIterator
     *
     * @var PageIteratorInterface
     *
     * @access protected
     */
    protected $pages;

    /**
     * HTML list items
     *
     * @var array
     *
     * @access protected
     */
    protected $items = [];

    /**
     * Create a Pagiation view
     *
     * @param PageIteratorInterface $pages page collcetion
     * @param View\UrlInterface     $url   url helper
     * @param View\ThemeInterface   $theme theme helper
     * @param View\HtmlInterface    $html  html helper
     *
     * @access public
     */
    public function __construct(
        PageIteratorInterface $pages,
        View\UrlInterface $url = null,
        View\ThemeInterface $theme = null,
        View\HtmlInterface $html = null
    ) {
        $this->pages = $pages;
        $this->url   = $url ?? new View\Url();
        $this->html  = $html ?? new View\Html();
        $this->theme = $theme ?? new View\Theme();
    }

    /**
     * Output HTML pagination
     *
     * @return string
     *
     * @access public
     */
    public function __toString() : string
    {
        return $this->render();
    }

    /**
     * Render HTML pagination
     *
     * @return string
     *
     * @access public
     */
    public function render() : string
    {
        $this->items = [];
        $this->addPages();

        return $this->html->menu(
            $this->items,
            $this->theme->menu()
        );
    }

    /**
     * Add pages to menu
     *
     * @return void
     *
     * @access protected
     */
    protected function addPages() : void
    {
        foreach ($this->pages as $page => $tags) {
            $this->add($page, $tags);
        }
    }

    /**
     * Add a page and adjacent meta with attributes based on tags
     *
     * @param int   $page page number
     * @param array $tags page tags
     *
     * @return void
     *
     * @access protected
     */
    protected function add(int $page, array $tags) : void
    {
        if ($this->isTagged(PageIterator::FIRST, $tags)) {
            $this->addRelPrev();
        }

        if ($this->isTagged(PageIterator::SKIP_BEFORE, $tags)) {
            $this->addSkip();
        }

        $this->addPage($page, $tags);

        if ($this->isTagged(PageIterator::SKIP_AFTER, $tags)) {
            $this->addSkip();
        }

        if ($this->isTagged(PageIterator::LAST, $tags)) {
            $this->addRelNext();
        }
    }

    /**
     * Ad rel previous link
     *
     * @return void
     *
     * @access protected
     */
    protected function addRelPrev() : void
    {
        $page = $this->pages->previousPage();
        $this->addRel($page, $this->theme->previous());
    }

    /**
     * Add rel next link
     *
     * @return void
     *
     * @access protected
     */
    protected function addRelNext() : void
    {
        $page = $this->pages->nextPage();
        $this->addRel($page, $this->theme->next());
    }

    /**
     * Add relative navigation link
     *
     * @param int|null $page page number
     * @param array    $data link settings
     *
     * @return void
     *
     * @access protected
     */
    protected function addRel(int $page = null, array $data) : void
    {
        $href = $this->url->generate($page);
        $link = $this->anchor($data['content'], $href, $data['anchor']);

        $attr = $data['item'];

        if (! $page) {
            $attr = array_merge_recursive($attr, $this->theme->disabled());
        }

        $this->item($link, $attr);
    }

    /**
     * Add a page item
     *
     * @param int   $page page number
     * @param array $tags page tags
     *
     * @return void
     *
     * @access protected
     */
    protected function addPage(int $page, array $tags) : void
    {
        $url     = $this->url->generate($page);
        $content = $this->isTagged(PageIterator::CURRENT, $tags)
            ? $this->theme->current($page)
            : (string) $page;

        $link = $this->anchor($content, $url);
        $attr = $this->theme->attr($tags);
        $this->item($link, $attr);
    }

    /**
     * Add skip item
     *
     * @return void
     *
     * @access protected
     */
    protected function addSkip() : void
    {
        $anchor = $this->anchor($this->theme->skip(), '#');
        $this->item($anchor, $this->theme->disabled());
    }

    /**
     * Build an anchor
     *
     * @param string $content text content
     * @param string $href    href
     * @param array  $attr    attributes
     *
     * @return string
     *
     * @access protected
     */
    protected function anchor(
        string $content, string $href, array $attr = []
    ) : string {
        $attr = array_merge_recursive($attr, $this->theme->anchor());
        return $this->html->anchor($content, $href, $attr);
    }

    /**
     * Add an item
     *
     * @param string $link text content
     * @param array  $attr attributes
     *
     * @return void
     *
     * @access protected
     */
    protected function item(string $link, array $attr = []) : void
    {
        $attr = array_merge_recursive($attr, $this->theme->item());
        $this->items[] = $this->html->item($link, $attr);
    }

    /**
     * Is tag in tags?
     *
     * @param string $tag  tag to check for
     * @param array  $tags tags to search
     *
     * @return bool
     *
     * @access protected
     */
    protected function isTagged(string $tag, array $tags) : bool
    {
        return in_array($tag, $tags);
    }
}
