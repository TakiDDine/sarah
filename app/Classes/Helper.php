<?php 

namespace App\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
    
/**
 * Created by IntelliJ IDEA.
 * User: hefang
 * Date: 2018/12/4
 * Time: 08:42
 */

    
    
    /**
     * 列出目录内的子目录和文件
     * @param string $rootDir 根目录
     * @param callable|null $filter 过滤器
     *
     * 如只列出'a'开头的文件和目录: function(string $file){return $file{0} === "a";}
     * @return array
     */
    public static function listFilesAndDirs(string $rootDir, callable $filter = null): array
    {
        if (!is_dir($rootDir)) return [];
        $res = [];
        if ($rootDir{strlen($rootDir) - 1} !== DIRECTORY_SEPARATOR) {
            $rootDir = $rootDir . DIRECTORY_SEPARATOR;
        }
        $items = scandir($rootDir);
        foreach ($items as $item) {
            if ($item === "." || $item === "..") continue;
            $file = $rootDir . $item;
            if (!is_callable($filter) || $filter($file)) {
                $res[] = $file;
            }
            if (is_dir($file)) {
                $sub = self::listFilesAndDirs($file);
                if (!empty($sub)) {
                    $res = array_merge($res, $sub);
                }
            }
        }
        return $res;
    }
    /**
     * 列出目录内的所有文件
     * @param string $rootDir 根目录
     * @param callable|null $filter 过滤器
     * @return array
     */
    public static function listFiles(string $rootDir, callable $filter = null): array
    {
        $array = self::listFilesAndDirs($rootDir, function (string $file) {
            return is_file($file);
        });
        return is_callable($filter) ? array_filter($array, $filter) : $array;
    }
    /**
     * 列出目录内的所有子目录
     * @param string $rootDir 根目录
     * @param callable|null $filter 过滤器
     * @return array
     */
    public static function listDirs(string $rootDir, callable $filter = null): array
    {
        $array = self::listFilesAndDirs($rootDir, function (string $file) {
            return is_dir($file);
        });
        return is_callable($filter) ? array_filter($array, $filter) : $array;
    }
    /**
     * 删除文件或目录, 或是文件则直接删除, 若是目录则删除目录本身以及目录内所有文件和子目录
     * @param string $fileOrDir 要删除的文件或目录
     * @return int 删除的文件和目录数
     */
    public static function delete(string $fileOrDir): int
    {
        if (is_dir($fileOrDir)) {
            return self::cleanDir($fileOrDir) + (rmdir($fileOrDir) ? 1 : 0);
        }
        return unlink($fileOrDir) ? 1 : 0;
    }
    /**
     * 清空目录, 不删除目录本身
     * @param string $dir 要清空的目录
     * @return int 删除的文件和子目录数
     */
    public static function cleanDir(string $dir)
    {
        $files = array_reverse(self::listFilesAndDirs($dir));
        $count = 0;
        foreach ($files as $file) {
            if (is_dir($file)) {
                $count += (rmdir($file) ? 1 : 0);
            } else {
                $count += (unlink($file) ? 1 : 0);
            }
        }
        return $count;
    }
    public static function appendDirSeparator(string $dir)
    {
        if ($dir{strlen($dir) - 1} === DIRECTORY_SEPARATOR) return $dir;
        return $dir . DIRECTORY_SEPARATOR;
    }
    /***************************** File Helper End ****************/

    
    
    
    
	/**
	 * Delete a COOKIE
	 *
	 * @param	mixed
	 * @param	string	the cookie domain. Usually: .yourdomain.com
	 * @param	string	the cookie path
	 * @param	string	the cookie prefix
	 * @return	void
	 */
    public function delete_cookie($name, $domain = '', $path = '/', $prefix = '')
	{
		set_cookie($name, '', '', $domain, $path, $prefix);
	}
    
    
    /**
	 * Get "now" time
	 */
    function now()
	{
      return  date("Y-m-d H:i:s");
	}
    

    
/**
	 * Unix to "Human"
	 *
	 * Formats Unix timestamp to the following prototype: 2006-08-21 11:35 PM
	 *
	 * @param	int	Unix timestamp
	 * @param	bool	whether to show seconds
	 * @param	string	format: us or euro
	 * @return	string
	 */
	function unix_to_human($time = '', $seconds = FALSE, $fmt = 'us')
	{
		$r = date('Y', $time).'-'.date('m', $time).'-'.date('d', $time).' ';
		if ($fmt === 'us')
		{
			$r .= date('h', $time).':'.date('i', $time);
		}
		else
		{
			$r .= date('H', $time).':'.date('i', $time);
		}
		if ($seconds)
		{
			$r .= ':'.date('s', $time);
		}
		if ($fmt === 'us')
		{
			return $r.' '.date('A', $time);
		}
		return $r;
	}
    
    
    
    
	/**
	 * Fetch an item from the COOKIE array
	 *
	 * @param	string
	 * @param	bool
	 * @return	mixed
	 */
	public function get_cookie($index, $xss_clean = FALSE)
	{
		$prefix = isset($_COOKIE[$index]) ? '' : config_item('cookie_prefix');
		return get_instance()->input->cookie($prefix.$index, $xss_clean);
	}
    
	/**
	 * Set cookie
	 *
	 * Accepts seven parameters, or you can submit an associative
	 * array in the first parameter containing all the values.
	 *
	 * @param	mixed
	 * @param	string	the value of the cookie
	 * @param	int	the number of seconds until expiration
	 * @param	string	the cookie domain.  Usually:  .yourdomain.com
	 * @param	string	the cookie path
	 * @param	string	the cookie prefix
	 * @param	bool	true makes the cookie secure
	 * @param	bool	true makes the cookie accessible via http(s) only (no javascript)
	 * @return	void
	 */
	public function set_cookie($name, $value = '', $expire = 0, $domain = '', $path = '/', $prefix = '', $secure = NULL, $httponly = NULL)
	{
		// Set the config file options
		get_instance()->input->set_cookie($name, $value, $expire, $domain, $path, $prefix, $secure, $httponly);
	}
    
    /**
	 * Create a Directory Map
	 *
	 * Reads the specified directory and builds an array
	 * representation of it. Sub-folders contained with the
	 * directory will be mapped as well.
	 *
	 * @param	string	$source_dir		Path to source
	 * @param	int	$directory_depth	Depth of directories to traverse
	 *						(0 = fully recursive, 1 = current dir, etc)
	 * @param	bool	$hidden			Whether to show hidden files
	 * @return	array
	 */
	public function directory_map($source_dir, $directory_depth = 0, $hidden = FALSE)
	{
		if ($fp = @opendir($source_dir))
		{
			$filedata	= array();
			$new_depth	= $directory_depth - 1;
			$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			while (FALSE !== ($file = readdir($fp)))
			{
				// Remove '.', '..', and hidden files [optional]
				if ($file === '.' OR $file === '..' OR ($hidden === FALSE && $file[0] === '.'))
				{
					continue;
				}
				is_dir($source_dir.$file) && $file .= DIRECTORY_SEPARATOR;
				if (($directory_depth < 1 OR $new_depth > 0) && is_dir($source_dir.$file))
				{
					$filedata[$file] = $this->directory_map($source_dir.$file, $new_depth, $hidden);
				}
				else
				{
					$filedata[] = $file;
				}
			}
			closedir($fp);
			return $filedata;
		}
		return FALSE;
	}
    
    
    
    
  
    
    
    /*
    *    start a session
    */
   public static function start_session(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
        
    
/**
	 * Word Limiter
	 *
	 * Limits a string to X number of words.
	 *
	 * @param	string
	 * @param	int
	 * @param	string	the end character. Usually an ellipsis
	 * @return	string
	 */
	public function word_limiter($str, $limit = 100, $end_char = '&#8230;')
	{
		if (trim($str) === '')
		{
			return $str;
		}
		preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);
		if (strlen($str) === strlen($matches[0]))
		{
			$end_char = '';
		}
		return rtrim($matches[0]).$end_char;
	}


    
    

    
	/**
	 * Character Limiter
	 *
	 * Limits the string based on the character count.  Preserves complete words
	 * so the character count may not be exactly as specified.
	 *
	 * @param	string
	 * @param	int
	 * @param	string	the end character. Usually an ellipsis
	 * @return	string
	 */
	function character_limiter($str, $n = 500, $end_char = '&#8230;')
	{
		if (mb_strlen($str) < $n)
		{
			return $str;
		}
		// a bit complicated, but faster than preg_replace with \s+
		$str = preg_replace('/ {2,}/', ' ', str_replace(array("\r", "\n", "\t", "\v", "\f"), ' ', $str));
		if (mb_strlen($str) <= $n)
		{
			return $str;
		}
		$out = '';
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';
			if (mb_strlen($out) >= $n)
			{
				$out = trim($out);
				return (mb_strlen($out) === mb_strlen($str)) ? $out : $out.$end_char;
			}
		}
	}



/**
	 * Phrase Highlighter
	 *
	 * Highlights a phrase within a text string
	 *
	 * @param	string	$str		the text string
	 * @param	string	$phrase		the phrase you'd like to highlight
	 * @param	string	$tag_open	the openging tag to precede the phrase with
	 * @param	string	$tag_close	the closing tag to end the phrase with
	 * @return	string
	 */
	public function highlight_phrase($str, $phrase, $tag_open = '<mark>', $tag_close = '</mark>')
	{
		return ($str !== '' && $phrase !== '')
			? preg_replace('/('.preg_quote($phrase, '/').')/i'.(UTF8_ENABLED ? 'u' : ''), $tag_open.'\\1'.$tag_close, $str)
			: $str;
	}
    

public function highlight_code($str)
	{
		/* The highlight string function encodes and highlights
		 * brackets so we need them to start raw.
		 *
		 * Also replace any existing PHP tags to temporary markers
		 * so they don't accidentally break the string out of PHP,
		 * and thus, thwart the highlighting.
		 */
		$str = str_replace(
			array('&lt;', '&gt;', '<?', '?>', '<%', '%>', '\\', '</script>'),
			array('<', '>', 'phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
			$str
		);
		// The highlight_string function requires that the text be surrounded
		// by PHP tags, which we will remove later
		$str = highlight_string('<?php '.$str.' ?>', TRUE);
		// Remove our artificially added PHP, and the syntax highlighting that came with it
		$str = preg_replace(
			array(
				'/<span style="color: #([A-Z0-9]+)">&lt;\?php(&nbsp;| )/i',
				'/(<span style="color: #[A-Z0-9]+">.*?)\?&gt;<\/span>\n<\/span>\n<\/code>/is',
				'/<span style="color: #[A-Z0-9]+"\><\/span>/i'
			),
			array(
				'<span style="color: #$1">',
				"$1</span>\n</span>\n</code>",
				''
			),
			$str
		);
		// Replace our markers back to PHP tags.
		return str_replace(
			array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
			array('&lt;?', '?&gt;', '&lt;%', '%&gt;', '\\', '&lt;/script&gt;'),
			$str
		);
	}





    
    /**
     * Normalizes a file/directory path.
     * 
     *
     * The normalization does the following work:
     *
     * - Convert all directory separators into `DIRECTORY_SEPARATOR` (e.g. "\a/b\c" becomes "/a/b/c")
     * - Remove trailing directory separators (e.g. "/a/b/c/" becomes "/a/b/c")
     * - Turn multiple consecutive slashes into a single one (e.g. "/a///b/c" becomes "/a/b/c")
     * - Remove ".." and "." based on their meanings (e.g. "/a/./b/../c" becomes "/a/c")
     *
     * @param string $path the file/directory path to be normalized
     * @param string $ds the directory separator to be used in the normalized result. Defaults to `DIRECTORY_SEPARATOR`.
     * @return string the normalized file/directory path
     */
    public static function normalizePath($path, $ds = DIRECTORY_SEPARATOR)
    {
        $path = rtrim(strtr($path, '/\\', $ds . $ds), $ds);
        if (strpos($ds . $path, "{$ds}.") === false && strpos($path, "{$ds}{$ds}") === false) {
            return $path;
        }
        // the path may contain ".", ".." or double slashes, need to clean them up
        if (strpos($path, "{$ds}{$ds}") === 0 && $ds == '\\') {
            $parts = [$ds];
        } else {
            $parts = [];
        }
        foreach (explode($ds, $path) as $part) {
            if ($part === '..' && !empty($parts) && end($parts) !== '..') {
                array_pop($parts);
            } elseif ($part === '.' || $part === '' && !empty($parts)) {
                continue;
            } else {
                $parts[] = $part;
            }
        }
        $path = implode($ds, $parts);
        return $path === '' ? '.' : $path;
    }
    
    
    
    
      /**
     * Determines the MIME type based on the extension name of the specified file.
     * This method will use a local map between extension names and MIME types.
     * @param string $file the file name.
     * @param string $magicFile the path (or alias) of the file that contains all available MIME type information.
     * If this is not set, the file specified by [[mimeMagicFile]] will be used.
     * @return string|null the MIME type. Null is returned if the MIME type cannot be determined.
     */
    public static function getMimeTypeByExtension($file, $magicFile = null)
    {
        $mimeTypes = static::loadMimeTypes($magicFile);
        if (($ext = pathinfo($file, PATHINFO_EXTENSION)) !== '') {
            $ext = strtolower($ext);
            if (isset($mimeTypes[$ext])) {
                return $mimeTypes[$ext];
            }
        }
        return null;
    }
    
    
        /**
     * Get usage memory
     *
     * @param bool $isPeak
     * @return string
     */
    public function getMemory($isPeak = true)
    {
        if ($isPeak) {
            $memory = memory_get_peak_usage(false);
        } else {
            $memory = memory_get_usage(false);
        }
        return $this->format($memory);
    }
    
    
    
    /**
 * Extract only digit characters
* 
 * @param $value
 * @return mixed
 */
function strToDigit($value)
{
	$value = preg_replace('/[^0-9]/', '', $value);
	
	return $value;
}
    
    
     /**
     * Quickest way for getting first file line
     *
     * @param string $filepath
     * @return string|null
     */
    public static function firstLine($filepath)
    {
        if (file_exists($filepath)) {
            $cacheRes = fopen($filepath, 'rb');
            $firstLine = fgets($cacheRes);
            fclose($cacheRes);
            return $firstLine;
        }
        return null;
    }
    
    
    /**
     * Check is current path regular file
     *
     * @param string $path
     * @return bool
     */
    public static function isFile($path): bool
    {
        return file_exists($path) && is_file($path);
    }
    
    
    
    /**
     * Copies a whole directory as another one.
     * The files and sub-directories will also be copied over.
     * @param string $src the source directory
     * @param string $dst the destination directory
     * @param array $options options for directory copy. Valid options are:
     *
     * - dirMode: integer, the permission to be set for newly copied directories. Defaults to 0775.
     * - fileMode:  integer, the permission to be set for newly copied files. Defaults to the current environment setting.
     * - filter: callback, a PHP callback that is called for each directory or file.
     *   The signature of the callback should be: `function ($path)`, where `$path` refers the full path to be filtered.
     *   The callback can return one of the following values:
     *
     *   * true: the directory or file will be copied (the "only" and "except" options will be ignored)
     *   * false: the directory or file will NOT be copied (the "only" and "except" options will be ignored)
     *   * null: the "only" and "except" options will determine whether the directory or file should be copied
     *
     * - only: array, list of patterns that the file paths should match if they want to be copied.
     *   A path matches a pattern if it contains the pattern string at its end.
     *   For example, '.php' matches all file paths ending with '.php'.
     *   Note, the '/' characters in a pattern matches both '/' and '\' in the paths.
     *   If a file path matches a pattern in both "only" and "except", it will NOT be copied.
     * - except: array, list of patterns that the files or directories should match if they want to be excluded from being copied.
     *   A path matches a pattern if it contains the pattern string at its end.
     *   Patterns ending with '/' apply to directory paths only, and patterns not ending with '/'
     *   apply to file paths only. For example, '/a/b' matches all file paths ending with '/a/b';
     *   and '.svn/' matches directory paths ending with '.svn'. Note, the '/' characters in a pattern matches
     *   both '/' and '\' in the paths.
     * - caseSensitive: boolean, whether patterns specified at "only" or "except" should be case sensitive. Defaults to true.
     * - recursive: boolean, whether the files under the subdirectories should also be copied. Defaults to true.
     * - beforeCopy: callback, a PHP callback that is called before copying each sub-directory or file.
     *   If the callback returns false, the copy operation for the sub-directory or file will be cancelled.
     *   The signature of the callback should be: `function ($from, $to)`, where `$from` is the sub-directory or
     *   file to be copied from, while `$to` is the copy target.
     * - afterCopy: callback, a PHP callback that is called after each sub-directory or file is successfully copied.
     *   The signature of the callback should be: `function ($from, $to)`, where `$from` is the sub-directory or
     *   file copied from, while `$to` is the copy target.
     * - copyEmptyDirectories: boolean, whether to copy empty directories. Set this to false to avoid creating directories
     *   that do not contain files. This affects directories that do not contain files initially as well as directories that
     *   do not contain files at the target destination because files have been filtered via `only` or `except`.
     *   Defaults to true. This option is available since version 2.0.12. Before 2.0.12 empty directories are always copied.
     * @throws InvalidArgumentException if unable to open directory
     */
    public static function copyDirectory($src, $dst, $options = [])
    {
        $src = static::normalizePath($src);
        $dst = static::normalizePath($dst);
        if ($src === $dst || strpos($dst, $src . DIRECTORY_SEPARATOR) === 0) {
            throw new InvalidArgumentException('Trying to copy a directory to itself or a subdirectory.');
        }
        $dstExists = is_dir($dst);
        if (!$dstExists && (!isset($options['copyEmptyDirectories']) || $options['copyEmptyDirectories'])) {
            static::createDirectory($dst, isset($options['dirMode']) ? $options['dirMode'] : 0775, true);
            $dstExists = true;
        }
        $handle = opendir($src);
        if ($handle === false) {
            throw new InvalidArgumentException("Unable to open directory: $src");
        }
        if (!isset($options['basePath'])) {
            // this should be done only once
            $options['basePath'] = realpath($src);
            $options = static::normalizeOptions($options);
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $from = $src . DIRECTORY_SEPARATOR . $file;
            $to = $dst . DIRECTORY_SEPARATOR . $file;
            if (static::filterPath($from, $options)) {
                if (isset($options['beforeCopy']) && !call_user_func($options['beforeCopy'], $from, $to)) {
                    continue;
                }
                if (is_file($from)) {
                    if (!$dstExists) {
                        // delay creation of destination directory until the first file is copied to avoid creating empty directories
                        static::createDirectory($dst, isset($options['dirMode']) ? $options['dirMode'] : 0775, true);
                        $dstExists = true;
                    }
                    copy($from, $to);
                    if (isset($options['fileMode'])) {
                        @chmod($to, $options['fileMode']);
                    }
                } else {
                    // recursive copy, defaults to true
                    if (!isset($options['recursive']) || $options['recursive']) {
                        static::copyDirectory($from, $to, $options);
                    }
                }
                if (isset($options['afterCopy'])) {
                    call_user_func($options['afterCopy'], $from, $to);
                }
            }
        }
        closedir($handle);
    }

    
    
    
    
  /**
     * Removes a file or symlink in a cross-platform way
     *
     * @param string $path
     * @return bool
     *
     * @since 2.0.14
     */
    public static function unlink($path)
    {
        $isWindows = DIRECTORY_SEPARATOR === '\\';
        if (!$isWindows) {
            return unlink($path);
        }
        if (is_link($path) && is_dir($path)) {
            return rmdir($path);
        }
        try {
            return unlink($path);
        } catch (ErrorException $e) {
            // last resort measure for Windows
            if (function_exists('exec') && file_exists($path)) {
                exec('DEL /F/Q ' . escapeshellarg($path));
                return !file_exists($path);
            }
            return false;
        }
    }

    
    
    /**
     * Returns the files found under the specified directory and subdirectories.
     * @param string $dir the directory under which the files will be looked for.
     * @param array $options options for file searching. Valid options are:
     *
     * - `filter`: callback, a PHP callback that is called for each directory or file.
     *   The signature of the callback should be: `function ($path)`, where `$path` refers the full path to be filtered.
     *   The callback can return one of the following values:
     *
     *   * `true`: the directory or file will be returned (the `only` and `except` options will be ignored)
     *   * `false`: the directory or file will NOT be returned (the `only` and `except` options will be ignored)
     *   * `null`: the `only` and `except` options will determine whether the directory or file should be returned
     *
     * - `except`: array, list of patterns excluding from the results matching file or directory paths.
     *   Patterns ending with slash ('/') apply to directory paths only, and patterns not ending with '/'
     *   apply to file paths only. For example, '/a/b' matches all file paths ending with '/a/b';
     *   and `.svn/` matches directory paths ending with `.svn`.
     *   If the pattern does not contain a slash (`/`), it is treated as a shell glob pattern
     *   and checked for a match against the pathname relative to `$dir`.
     *   Otherwise, the pattern is treated as a shell glob suitable for consumption by `fnmatch(3)`
     *   with the `FNM_PATHNAME` flag: wildcards in the pattern will not match a `/` in the pathname.
     *   For example, `views/*.php` matches `views/index.php` but not `views/controller/index.php`.
     *   A leading slash matches the beginning of the pathname. For example, `/*.php` matches `index.php` but not `views/start/index.php`.
     *   An optional prefix `!` which negates the pattern; any matching file excluded by a previous pattern will become included again.
     *   If a negated pattern matches, this will override lower precedence patterns sources. Put a backslash (`\`) in front of the first `!`
     *   for patterns that begin with a literal `!`, for example, `\!important!.txt`.
     *   Note, the '/' characters in a pattern matches both '/' and '\' in the paths.
     * - `only`: array, list of patterns that the file paths should match if they are to be returned. Directory paths
     *   are not checked against them. Same pattern matching rules as in the `except` option are used.
     *   If a file path matches a pattern in both `only` and `except`, it will NOT be returned.
     * - `caseSensitive`: boolean, whether patterns specified at `only` or `except` should be case sensitive. Defaults to `true`.
     * - `recursive`: boolean, whether the files under the subdirectories should also be looked for. Defaults to `true`.
     * @return array files found under the directory, in no particular order. Ordering depends on the files system used.
     * @throws InvalidArgumentException if the dir is invalid.
     */
    public static function findFiles($dir, $options = [])
    {
        $dir = self::clearDir($dir);
        $options = self::setBasePath($dir, $options);
        $list = [];
        $handle = self::openDir($dir);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (static::filterPath($path, $options)) {
                if (is_file($path)) {
                    $list[] = $path;
                } elseif (is_dir($path) && (!isset($options['recursive']) || $options['recursive'])) {
                    $list = array_merge($list, static::findFiles($path, $options));
                }
            }
        }
        closedir($handle);
        return $list;
    }
    
     /**
     * Creates a new directory.
     *
     * This method is similar to the PHP `mkdir()` function except that
     * it uses `chmod()` to set the permission of the created directory
     * in order to avoid the impact of the `umask` setting.
     *
     * @param string $path path of the directory to be created.
     * @param int $mode the permission to be set for the created directory.
     * @param bool $recursive whether to create parent directories if they do not exist.
     * @return bool whether the directory is created successfully
     * @throws \yii\base\Exception if the directory could not be created (i.e. php error due to parallel changes)
     */
    public static function createDirectory($path, $mode = 0775, $recursive = true)
    {
        if (is_dir($path)) {
            return true;
        }
        $parentDir = dirname($path);
        // recurse if parent dir does not exist and we are not at the root of the file system.
        if ($recursive && !is_dir($parentDir) && $parentDir !== $path) {
            static::createDirectory($parentDir, $mode, true);
        }
        try {
            if (!mkdir($path, $mode)) {
                return false;
            }
        } catch (\Exception $e) {
            if (!is_dir($path)) {// https://github.com/yiisoft/yii2/issues/9288
                throw new \yii\base\Exception("Failed to create directory \"$path\": " . $e->getMessage(), $e->getCode(), $e);
            }
        }
        try {
            return chmod($path, $mode);
        } catch (\Exception $e) {
            throw new \yii\base\Exception("Failed to change permissions for directory \"$path\": " . $e->getMessage(), $e->getCode(), $e);
        }
    }
    
    
        /**
     * Removes an item from an array and returns the value. If the key does not exist in the array, the default value
     * will be returned instead.
     *
     * Usage examples,
     *
     * ```php
     * // $array = ['type' => 'A', 'options' => [1, 2]];
     * // working with array
     * $type = \yii\helpers\ArrayHelper::remove($array, 'type');
     * // $array content
     * // $array = ['options' => [1, 2]];
     * ```
     *
     * @param array $array the array to extract value from
     * @param string $key key name of the array element
     * @param mixed $default the default value to be returned if the specified key does not exist
     * @return mixed|null the value of the element if found, default value otherwise
     */
    public static function ArrayRemove(&$array, $key, $default = null)
    {
        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            $value = $array[$key];
            unset($array[$key]);
            return $value;
        }
        return $default;
    }    
    
    /*
    *    Create a Random String
    */
    public function str_random($length = 20) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    
    /*
    *   Get a Folder size in bytes
    */
    public function folderSize ($dir){
        $size = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }
    

    /*
    *   Format bytes to kilobytes, megabytes, gigabytes
    */
    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'kb', 'mb', 'gb', 'tb');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }


    
  /**
     * Nice formatting for computer sizes (Bytes).
     *
     * @param   integer|float $bytes    The number in bytes to format
     * @param   integer       $decimals The number of decimal points to include
     * @return  string
     */
    public function format($bytes, $decimals = 2): string
    {
        $exp = 0;
        $value = 0;
        $symbol = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $bytes = (float)$bytes;
        if ($bytes > 0) {
            $exp = floor(log($bytes) / log(1024));
            $value = ($bytes / (1024 ** floor($exp)));
        }
        if ($symbol[$exp] === 'B') {
            $decimals = 0;
        }
        return number_format($value, $decimals, '.', '') . ' ' . $symbol[$exp];
    }
    
    
    
    
    
    
    
    
    
    
    
    /*
    *   Format bytes to kilobytes, megabytes, gigabytes
    */
    public static function calc($size, $digits=2){
        $unit= array('','K','M','G','T','P');
        $base= 1024;
        $i = floor(log($size,$base));
        $n = count($unit);
        if($i >= $n){
            $i=$n-1;
        }
        return round($size/pow($base,$i),$digits).' '.$unit[$i] . 'B';
    }
    
    // This function will return the Server Memory Usage:
    public function get_server_memory_usage(){

        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2]/$mem[1]*100;

        return $memory_usage;
    }
    
     // This function will return the Server CPU Usage:
     public function get_server_cpu_usage(){
        $load = \sys_getloadavg();
        return $load[0];
     }
    
    
    
    
 public function getSystemMemInfo() 
{       
    $data = explode("\n", file_get_contents("/proc/meminfo"));
    $meminfo = array();
    foreach ($data as $line) {
        list($key, $val) = explode(":", $line);
        $meminfo[$key] = trim($val);
    }
    return $meminfo;
}
    
    
    
    // 
    public static function is_mobile($mobile) {
        return strlen($mobile) == 11 && preg_match("/^1[3-9]\d{9}$/", $mobile);
    }
    
    
    /*
    *    this function has been tested , it works like a charm
    */
    public function download($file){
        
        if (!file_exists($file)){
            header("Content-type: text/html; charset=utf-8");
            echo "File not found!";
            exit;
        } 
            
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
    
    public function get_ext($file){
        return substr($file, strrpos($file, '.')+1);
    }
    
 


    
    
    /*
    *  Check Email is Valid
    */
    public function valid_email($email){
        
        // Check if is it a real email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        
        // check if is not from banned list
        $file = INC_ROOT.'/app/Libraries/domains.json';
        
        // Check if File Exists
        if(file_exists($file)){
            $bannedEmails = json_decode(file_get_contents());
            if (in_array(strtolower(explode('@', $email)[1]), $bannedEmails)) {
                return false;
            }
        }
        return true;
    }
    
    
    /*
    *  Get User IP
    *  this function is tested & it works perfectly
    */
    public function get_ip_address(){ 
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
    
    
    /*
    *    Clean the Inputs
    */
    public function clean($data) {
        // Strip HTML Tags
        $clear = strip_tags($data);
        // Clean up things like &amp;
        $clear = html_entity_decode($clear);
        // Strip out any url-encoded stuff
        $clear = urldecode($clear);
        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);
        // Trim the string of leading/trailing space
        $clear = trim($clear);
        return $clear;
    }
    
    
    /*
    *    Check if a variable is only numbers and letters
    */
    public function is_alphanumeric ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    /*
    *    Check if is a string is small
    */
    public function is_small ($input){
        if(strlen($input)< 3) {
            return false;
        } else {
            return true;
        }
    }   
    
    /*
    *   check a url if it is gravatar
    */
    public function is_gravatar($url){
        if ( false!==stripos($url, 'gravatar') ) {
            return true;
        }
        return false;
    } 
    
    /*
    *    check if a string is an email
    */
    public function is_Email($input){
       if(!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true; 
        }else {
            return false;
        }
    }  
    
    
    /*
    *   is unique
    */
    public function is_Unique ($field,$table,$value) {
        $result = $this->container->db->table($table)->where($field, $value)->value($field);
        if($result) {
            return false;
        } else {
            return true;
        }
    }
    
    
    /*
    *   Get time of now  year-month-day Hour:minutes:seconds
    *   Return time
    */
    public function get_Time_Now(){
        $now = new \DateTime();
        return $now->format('Y-m-d H:i:s');
    }
    
    /*
    *   example : contact us page --to--> contact-us-page
    *   remove all whitespace and replace with -
    *   Return srting 
    */
    public function string_To_Uri($string){
      return  preg_replace('/\s+/', '-', $string);
    }
    
    
    /*
    *    Count the words of a string
    */
    public function count_words($word){
        return str_word_count($word);
    }
    
    
    public function is_slug ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._-]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    
    /*
    *   Deleting all files in a folder ( and the hidden files also)
    */
    public function delete_folders_files($path){
        $path = rtrim($path, '/').'/{,.}*';
        $files = glob($path, GLOB_BRACE); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
    }
    
    
    /*
    *     Get the current page url
    */
    public function get_page_url(){
      return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
      );
    }

  
   public function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }

  /*
    *   Function to Get Snippet from a string , 
    *   @str = the text you want to get snippet from
    *   @$wordCount = the number of words 
    *   usage example get_snippet($text,15,' [...] ');
    */
    public function get_snippet( $str, $wordCount = 10 , $car = ' ' ) {
        $text = implode( 
        '', 
            array_slice( 
              preg_split(
                '/([\s,\.;\?\!]+)/', 
                $str, 
                $wordCount*2+1, 
                PREG_SPLIT_DELIM_CAPTURE
              ),
              0,
              $wordCount*2-1
            )
        );
        
        return $text.$car;
    }
    
    /*
    *    Check if a string is empty
    */ 
    public function is_empty($string){
        if(empty($string)){
            return true;
        }else {
            return false;
        }
    }
    
/* return Operating System */
    public function get_os(){
    if ( isset( $_SERVER ) ) {
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }
    else {
        global $HTTP_SERVER_VARS;
        if ( isset( $HTTP_SERVER_VARS ) ) {
            $agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
        }
        else {
            global $HTTP_USER_AGENT;
            $agent = $HTTP_USER_AGENT;
        }
    }
    $ros[] = array('Windows XP', 'Windows XP');
    $ros[] = array('Windows NT 5.1|Windows NT5.1)', 'Windows XP');
    $ros[] = array('Windows 2000', 'Windows 2000');
    $ros[] = array('Windows NT 5.0', 'Windows 2000');
    $ros[] = array('Windows NT 4.0|WinNT4.0', 'Windows NT');
    $ros[] = array('Windows NT 5.2', 'Windows Server 2003');
    $ros[] = array('Windows NT 6.0', 'Windows Vista');
    $ros[] = array('Windows NT 7.0', 'Windows 7');
    $ros[] = array('Windows CE', 'Windows CE');
    $ros[] = array('(media center pc).([0-9]{1,2}\.[0-9]{1,2})', 'Windows Media Center');
    $ros[] = array('(win)([0-9]{1,2}\.[0-9x]{1,2})', 'Windows');
    $ros[] = array('(win)([0-9]{2})', 'Windows');
    $ros[] = array('(windows)([0-9x]{2})', 'Windows');
    // Doesn't seem like these are necessary...not totally sure though..
    //$ros[] = array('(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'Windows NT');
    //$ros[] = array('(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})', 'Windows NT'); // fix by bg
    $ros[] = array('Windows ME', 'Windows ME');
    $ros[] = array('Win 9x 4.90', 'Windows ME');
    $ros[] = array('Windows 98|Win98', 'Windows 98');
    $ros[] = array('Windows 95', 'Windows 95');
    $ros[] = array('(windows)([0-9]{1,2}\.[0-9]{1,2})', 'Windows');
    $ros[] = array('win32', 'Windows');
    $ros[] = array('(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})', 'Java');
    $ros[] = array('(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}', 'Solaris');
    $ros[] = array('dos x86', 'DOS');
    $ros[] = array('unix', 'Unix');
    $ros[] = array('Mac OS X', 'Mac OS X');
    $ros[] = array('Mac_PowerPC', 'Macintosh PowerPC');
    $ros[] = array('(mac|Macintosh)', 'Mac OS');
    $ros[] = array('(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'SunOS');
    $ros[] = array('(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'BeOS');
    $ros[] = array('(risc os)([0-9]{1,2}\.[0-9]{1,2})', 'RISC OS');
    $ros[] = array('os/2', 'OS/2');
    $ros[] = array('freebsd', 'FreeBSD');
    $ros[] = array('openbsd', 'OpenBSD');
    $ros[] = array('netbsd', 'NetBSD');
    $ros[] = array('irix', 'IRIX');
    $ros[] = array('plan9', 'Plan9');
    $ros[] = array('osf', 'OSF');
    $ros[] = array('aix', 'AIX');
    $ros[] = array('GNU Hurd', 'GNU Hurd');
    $ros[] = array('(fedora)', 'Linux - Fedora');
    $ros[] = array('(kubuntu)', 'Linux - Kubuntu');
    $ros[] = array('(ubuntu)', 'Linux - Ubuntu');
    $ros[] = array('(debian)', 'Linux - Debian');
    $ros[] = array('(CentOS)', 'Linux - CentOS');
    $ros[] = array('(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - Mandriva');
    $ros[] = array('(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - SUSE');
    $ros[] = array('(Dropline)', 'Linux - Slackware (Dropline GNOME)');
    $ros[] = array('(ASPLinux)', 'Linux - ASPLinux');
    $ros[] = array('(Red Hat)', 'Linux - Red Hat');
    // Loads of Linux machines will be detected as unix.
    // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
    //$ros[] = array('X11', 'Unix');
    $ros[] = array('(linux)', 'Linux');
    $ros[] = array('(amigaos)([0-9]{1,2}\.[0-9]{1,2})', 'AmigaOS');
    $ros[] = array('amiga-aweb', 'AmigaOS');
    $ros[] = array('amiga', 'Amiga');
    $ros[] = array('AvantGo', 'PalmOS');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}', 'Linux');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}', 'Linux');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})', 'Linux');
    $ros[] = array('[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})', 'Linux');
    $ros[] = array('(webtv)/([0-9]{1,2}\.[0-9]{1,2})', 'WebTV');
    $ros[] = array('Dreamcast', 'Dreamcast OS');
    $ros[] = array('GetRight', 'Windows');
    $ros[] = array('go!zilla', 'Windows');
    $ros[] = array('gozilla', 'Windows');
    $ros[] = array('gulliver', 'Windows');
    $ros[] = array('ia archiver', 'Windows');
    $ros[] = array('NetPositive', 'Windows');
    $ros[] = array('mass downloader', 'Windows');
    $ros[] = array('microsoft', 'Windows');
    $ros[] = array('offline explorer', 'Windows');
    $ros[] = array('teleport', 'Windows');
    $ros[] = array('web downloader', 'Windows');
    $ros[] = array('webcapture', 'Windows');
    $ros[] = array('webcollage', 'Windows');
    $ros[] = array('webcopier', 'Windows');
    $ros[] = array('webstripper', 'Windows');
    $ros[] = array('webzip', 'Windows');
    $ros[] = array('wget', 'Windows');
    $ros[] = array('Java', 'Unknown');
    $ros[] = array('flashget', 'Windows');
    // delete next line if the script show not the right OS
    //$ros[] = array('(PHP)/([0-9]{1,2}.[0-9]{1,2})', 'PHP');
    $ros[] = array('MS FrontPage', 'Windows');
    $ros[] = array('(msproxy)/([0-9]{1,2}.[0-9]{1,2})', 'Windows');
    $ros[] = array('(msie)([0-9]{1,2}.[0-9]{1,2})', 'Windows');
    $ros[] = array('libwww-perl', 'Unix');
    $ros[] = array('UP.Browser', 'Windows CE');
    $ros[] = array('NetAnts', 'Windows');
    $file = count ( $ros );
    $os = '';
    for ( $n=0 ; $n<$file ; $n++ ){
        if ( preg_match('/'.$ros[$n][0].'/i' , $agent, $name)){
            $os = @$ros[$n][1].' '.@$name[2];
            break;
        }
    }
    return trim ( $os );
}
    
    
    
    
  
    
    
    
    
     /*
    *   remove http://, www and slash from URL
    *   example : http://www.google.com/exampleUri  --> google.com 
    */
    public function urlToDomain ($input){
        
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $input = trim($input, '/');

        // If scheme not included, prepend it
        if (!preg_match('#^http(s)?://#', $input)) {
            $input = 'http://' . $input;
        }

        $urlParts = parse_url($input);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);

        return $domain;
    }
    
    
    
    
    
     /*
    *    Get the full Url of the current Page
    */
    public function Get_Full_Url(){
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;

    }
    
    
    
        
    public function meta_redirect($sec,$page){
        echo '<meta http-equiv="refresh" content="'.$sec.'; URL='.$page.'"/>';
    }
    
    
    /**
     * Mulit-byte Unserialize (http://stackoverflow.com/questions/2853454/php-unserialize-fails-with-non-encoded-characters)
     *
     * UTF-8 will screw up a serialized string
     *
     * @access private
     * @param string
     * @return string
     */
    public function mb_unserialize($string) {
        $string = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $string);
        return unserialize($string);
    }
    
    
 /*
        *     get youtube Video ID From the URL
        */
      public  function getYoutubeIdFromUrl($url) {
            $parts = parse_url($url);
            if(isset($parts['query'])){
                parse_str($parts['query'], $qs);
                if(isset($qs['v'])){
                    return $qs['v'];
                }else if(isset($qs['vi'])){
                    return $qs['vi'];
                }
            }
            if(isset($parts['path'])){
                $path = explode('/', trim($parts['path'], '/'));
                return $path[count($path)-1];
            }
            return false;
        }


        /*
        *       Iframe youtube video
        */
       public function iframeVideo($url){  
            $videoID = getYoutubeIdFromUrl($url);
            echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src=" https://www.youtube.com/embed/'.$videoID .'" allowfullscreen></iframe></div>' ;
        }
    
    
    
    
    
    
function human_time_diff( $from, $to = '' ) {
    if ( empty( $to ) ) {
        $to = time();
    }
 
    $diff = (int) abs( $to - $from );
 
    if ( $diff < HOUR_IN_SECONDS ) {
        $mins = round( $diff / MINUTE_IN_SECONDS );
        if ( $mins <= 1 )
            $mins = 1;
        /* translators: Time difference between two dates, in minutes (min=minute). 1: Number of minutes */
        $since = sprintf( _n( '%s min', '%s mins', $mins ), $mins );
    } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
        $hours = round( $diff / HOUR_IN_SECONDS );
        if ( $hours <= 1 )
            $hours = 1;
        /* translators: Time difference between two dates, in hours. 1: Number of hours */
        $since = sprintf( _n( '%s hour', '%s hours', $hours ), $hours );
    } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
        $days = round( $diff / DAY_IN_SECONDS );
        if ( $days <= 1 )
            $days = 1;
        /* translators: Time difference between two dates, in days. 1: Number of days */
        $since = sprintf( _n( '%s day', '%s days', $days ), $days );
    } elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
        $weeks = round( $diff / WEEK_IN_SECONDS );
        if ( $weeks <= 1 )
            $weeks = 1;
        /* translators: Time difference between two dates, in weeks. 1: Number of weeks */
        $since = sprintf( _n( '%s week', '%s weeks', $weeks ), $weeks );
    } elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
        $months = round( $diff / MONTH_IN_SECONDS );
        if ( $months <= 1 )
            $months = 1;
        /* translators: Time difference between two dates, in months. 1: Number of months */
        $since = sprintf( _n( '%s month', '%s months', $months ), $months );
    } elseif ( $diff >= YEAR_IN_SECONDS ) {
        $years = round( $diff / YEAR_IN_SECONDS );
        if ( $years <= 1 )
            $years = 1;
        /* translators: Time difference between two dates, in years. 1: Number of years */
        $since = sprintf( _n( '%s year', '%s years', $years ), $years );
    }
 
    /**
     * Filters the human readable difference between two timestamps.
     *
     * @since 4.0.0
     *
     * @param string $since The difference in human readable text.
     * @param int    $diff  The difference in seconds.
     * @param int    $from  Unix timestamp from which the difference begins.
     * @param int    $to    Unix timestamp to end the time difference.
     */
    return apply_filters( 'human_time_diff', $since, $diff, $from, $to );
}
    
    
    
    
    
    
    

    
	/**
	 * Returns true if $number is an integer or integer string
	 *
	 * PHP's native is_int() functions returns false on strings like '23' or '1'.
	 * I will evaluate those integer strings to true.
	 *
	 * For example:
	 *
	 *     is_int(1);        // returns true
	 *     Num::isInt(1);    // returns true
	 *
	 *     is_int('1');      // returns false
	 *     Num::isInt('1');  // returns true
	 *
	 * @since  0.1.0
	 *
	 * @param  int|float  $number  the number to test
	 *
	 * @return  bool  true if $number is an integer or integer string
	 */
	public function isInt($number) 
	{	
		return is_numeric($number) && is_int(+$number);
	}
    
    
    
    
  public function is_json($string, $return = false)
    {
        if (!is_string($string) || empty($string)) {
            return false;
        }
        $decoded = json_decode($string, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            return false;
        }
        return ($return ? $decoded : true);
    }    
    
/**
	 * Returns a string in camel case
	 *
	 * For example:
	 *
	 *     Str::strtocamelcase('Hello world');   // returns "helloWorld"
	 *     Str::strtocamelcase('H3LLO WORLD!');  // returns "helloWorld"
	 *     Str::strtocamelcase('hello_world');   // returns "helloWorld"
	 * 
	 * @since  0.1.0
	 *
	 * @param  string  $string  the string to camel-case
	 *
	 * @return  string  the camel-cased string
	 *
	 * @throws  \BadMethodCallException    if $string is empty
	 * @throws  \InvalidArgumentException  if $string is not a string
	 */
	public function strtocamelcase($string)
	{		
		// if $string is given
		if ($string !== null) {
			// if $string is actually a string
			if (is_string($string)) {
				// if $string is not empty
				if (strlen($string)) {
					// trim the string
					$string = trim($string);
			
					// replace underscores ("_") and hyphens ("-") with spaces (" ")
					$string = str_replace(array('-', '_'), ' ', $string);
					
					// lower-case everything
					$string = strtolower($string);
			
					// capitalize each word
					$string = ucwords($string);
			
					// remove spaces
					$string = str_replace(' ', '', $string);
			
					// lower-case the first word
					$string = lcfirst($string);
			
					// remove any non-alphanumeric characters
					$string = preg_replace("#[^a-zA-Z0-9]+#", '', $string);
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__." expects the first parameter, the string, to be a string"
				);
			}
		} else {
			throw new \BadMethodCallException(
				__METHOD__." expects one parameter, a string to camel-case"
			);
		}
		return $string;
	} 
    
    
}