<?php



namespace App\Helpers;

 class Zip {
    
    public static function unCompress(string $zipFile, string $extractTo, string $password = null) {
        self::checkEnv();
        if (!file_exists($zipFile) || !is_dir($extractTo) || !is_writable($extractTo)) {
            return false;
        }
        $zip = new \ZipArchive();
        if ($zip->open(\ZipArchive::ER_OPEN) !== true) {
            return false;
        }
        if (!StringHelper::isNullOrBlank($password)) {
            $zip->setPassword($password);
        }
        $res = $zip->extractTo($extractTo);
        $zip->close();
        return $res;
    }

    
    public static function compress(
        string $srcFileOrDir,
        string $destFile,
        string $password = null,
        string $comment = null)
    {
        self::checkEnv();
        if (!file_exists($srcFileOrDir)) {
            return false;
        }

        $zip = new \ZipArchive();
        if ($zip->open($destFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            return false;
        }
        $hasPassword = !StringHelper::isNullOrBlank($password);
        $supportPassword = $hasPassword && version_compare(PHP_VERSION, "7.2.0", ">=");
        if ($supportPassword) {
            $zip->setPassword($password);
        }

        if (!StringHelper::isNullOrBlank($comment)) {
            $zip->setArchiveComment($comment);
        }
        if (is_dir($srcFileOrDir)) {
            if ($srcFileOrDir{strlen($srcFileOrDir) - 1} != DIRECTORY_SEPARATOR) {
                $srcFileOrDir = $srcFileOrDir . DIRECTORY_SEPARATOR;
            }
            $files = FileHelper::listFilesAndDirs($srcFileOrDir);
            foreach ($files as $file) {
                $name = str_replace($srcFileOrDir, "", $file);
                if (is_dir($file)) {
                    $zip->addEmptyDir($name);
                } else {
                    $zip->addFile($file, $name);
                }
                if ($supportPassword) {
                    $zip->setEncryptionName($name, \ZipArchive::EM_AES_128);
                }
            }
        } else {
            $zip->addFile($srcFileOrDir, str_replace(dirname($srcFileOrDir) . DIRECTORY_SEPARATOR, "", $srcFileOrDir));
        }
        return $zip->close();
    }


    private static function checkEnv() {
        if (!extension_loaded("zip")) {
            throw new ExtensionNotLoadException("zip");
        }
    }

    
}