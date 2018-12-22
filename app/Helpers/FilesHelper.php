<?php

namespace App\Helpers;

class File {
    

        
    // Checks the existence of files or directories.
    public function exists($files) {
        $maxPathLength = PHP_MAXPATHLEN - 2;

        foreach ($this->toIterable($files) as $file) {
            if (\strlen($file) > $maxPathLength) {
                throw new IOException(sprintf('Could not check if file exist because path length exceeds %d characters.', $maxPathLength), 0, null, $file);
            }

            if (!file_exists($file)) {
                return false;
            }
        }

        return true;
    }
    
    
    
    
    // Creates a directory recursively.
    public function mkdir($dirs, $mode = 0777) {
        foreach ($this->toIterable($dirs) as $dir) {
            if (is_dir($dir)) {
                continue;
            }
            if (!self::box('mkdir', $dir, $mode, true)) {
                if (!is_dir($dir)) {
                    // The directory was not created by a concurrent process. 
                    // Let's throw an exception with a developer friendly error message if we have one
                    if (self::$lastError) {
                        throw new IOException(sprintf('Failed to create "%s": %s.', $dir, self::$lastError), 0, null, $dir);
                    }
                    throw new IOException(sprintf('Failed to create "%s"', $dir), 0, null, $dir);
                }
            }
        }
    }
    
    
    public static function listFilesAndDirs($rootDir, $filter = null){
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

    
    public static function listFiles(string $rootDir, callable $filter = null) {
        $array = self::listFilesAndDirs($rootDir, function (string $file) {
            return is_file($file);
        });
        return is_callable($filter) ? array_filter($array, $filter) : $array;
    }

    
    public static function listDirs(string $rootDir, callable $filter = null): array{
        $array = self::listFilesAndDirs($rootDir, function (string $file) {
            return is_dir($file);
        });
        return is_callable($filter) ? array_filter($array, $filter) : $array;
    }

    
    public static function delete( $fileOrDir){
        if (is_dir($fileOrDir)) {
            return self::cleanDir($fileOrDir) + (rmdir($fileOrDir) ? 1 : 0);
        }
        return unlink($fileOrDir) ? 1 : 0;
    }

    
    public static function cleanDir( $dir) {
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

    
    /**
     * Atomically dumps content into a file.
     *
     * @param string $filename The file to be written to
     * @param string $content  The data to write into the file
     *
     * @throws IOException if the file cannot be written to
     */
    public function dumpFile($filename, $content)
    {
        $dir = \dirname($filename);

        if (!is_dir($dir)) {
            $this->mkdir($dir);
        }

        if (!is_writable($dir)) {
            throw new IOException(sprintf('Unable to write to the "%s" directory.', $dir), 0, null, $dir);
        }

        // Will create a temp file with 0600 access rights
        // when the filesystem supports chmod.
        $tmpFile = $this->tempnam($dir, basename($filename));

        if (false === @file_put_contents($tmpFile, $content)) {
            throw new IOException(sprintf('Failed to write file "%s".', $filename), 0, null, $filename);
        }

        @chmod($tmpFile, file_exists($filename) ? fileperms($filename) : 0666 & ~umask());

        $this->rename($tmpFile, $filename, true);
    }

    /**
     * Appends content to an existing file.
     *
     * @param string $filename The file to which to append content
     * @param string $content  The content to append
     *
     * @throws IOException If the file is not writable
     */
    public function appendToFile($filename, $content)
    {
        $dir = \dirname($filename);

        if (!is_dir($dir)) {
            $this->mkdir($dir);
        }

        if (!is_writable($dir)) {
            throw new IOException(sprintf('Unable to write to the "%s" directory.', $dir), 0, null, $dir);
        }

        if (false === @file_put_contents($filename, $content, FILE_APPEND)) {
            throw new IOException(sprintf('Failed to write file "%s".', $filename), 0, null, $filename);
        }
    }    
}