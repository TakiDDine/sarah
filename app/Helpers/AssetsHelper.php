<?php

/**
 * This is an asset helper file that is built to assist in easier loading of
 * your assets, relative to the baseURL
 *
 * @package  Helpers
 * @author   Jason Napolitano <jnapolitanoit@gmail.com>
 * @updated  11.26.2018
 *
 * @license  MIT License
 *
 * @link     https://codeigniter4.github.io/CodeIgniter4/general/helpers.html
 * @link     https://opensource.org/licenses/MIT
 */

// If the function does not exist, let's create it!
if (!function_exists('assets_url')) {
    /**
     * A syntactic sugar function for grabbing the `/assets/*` path and an
     * [optional] asset `$file`
     *
     * @param  string $file [Default: null]
     * @param  string $path [Default base_url('assets')]
     *
     * @see    \assets_url()
     *
     * @return string
     */
    function assets_url(string $file = null, string $path = 'assets')
    {
        return base_url($path . _DS_ . $file);
    }
}

// ----------------------------------------------------------------------------

// If the function does not exist, let's create it!
if (!\function_exists('load_css')) {
    /**
     * A syntactic sugar function for loading a stylesheet from `/assets/css`
     *
     * @param  string $file Note: The .css extension is not needed
     * @param  string $path [Default assets_url('css')]
     *
     * @see    \assets_url()
     *
     * @return string
     */
    function load_css(string $file, string $path = 'css')
    {
        return '<link type="text/css" rel="stylesheet" href="' . assets_url($path . _DS_ . $file . ".css") . '" />';
    }
}

// ----------------------------------------------------------------------------

// If the function does not exist, let's create it!
if (!\function_exists('load_js')) {
    /**
     * A syntactic sugar function for loading a script from `/assets/js`
     *
     * @param  string      $file Note: The .js extension is not needed
     * @param  string|null $path [Default assets_url('js')]
     *
     * @see    \assets_url()
     *
     * @return string
     *
     */
    function load_js(string $file, ?string $path = 'js')
    {
        return '<script type="text/javascript" src="' . assets_url($path . _DS_ . $file . ".js") . '"></script>';
    }
}

// ----------------------------------------------------------------------------

// If the function does not exist, let's create it!
if (!\function_exists('load_favicon')) {
    /**
     * A syntactic sugar function for loading a favicon from `/assets/`
     *
     * @param  string      $file      .ico is used if no argument is passed
     * @param  string|null $path      [Default base_url('/')]
     * @param  string|null $extension default: 'ico'
     *
     * @see    \assets_url()
     *
     * @return string
     */
    function load_favicon(string $file, ?string $path = '', ?string $extension = null)
    {
        $fileExtension = $extension ?? 'ico';
        return '<link rel="shortcut icon" type="image/' . $fileExtension . '" href="' . assets_url($path . _DS_ . $file . ".{$fileExtension}") . '"/>';
    }
}

// ----------------------------------------------------------------------------

// If the function does not exist, let's create it!
if (!\function_exists('load_image')) {
    /**
     * A syntactic sugar function for loading an image from `/assets/images`
     *
     * @param  string $file Note: The extension IS required
     * @param  string $path [Default assets_url('images')]
     * @param  string $html
     *
     * @see    \assets_url()
     *
     * @return string
     */
    function load_image(string $file, string $path = 'images', string $html = '')
    {
        return '<img src="' . assets_url($path . _DS_ . $file) . '" ' . $html . ' />';
    }
}

// ----------------------------------------------------------------------------

// If the function does not exist, let's create it!
// ...


// ----------------------------------------------------------------------------