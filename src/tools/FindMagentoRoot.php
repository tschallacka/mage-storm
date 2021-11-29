<?php namespace Tschallacka\MageStorm\tools;

use Exception;
class FindMagentoRoot
{
    /**
     * @return string
     * @throws Exception
     */
    public function getPathToMagentoRoot()
    {
        $env_root = getenv('MAGENTO_ROOT');
        if ($env_root !== false) {
            return $env_root;
        }
        $paths = [__DIR__, dirname($_SERVER['SCRIPT_FILENAME'])];
        foreach ($paths as $path) {
            $path = $this->findRoot($path);
            if ($path) {
                return $path;
            }
        }
        throw new \Exception("Cannot find Magento root in parent directories. Starting directories '" . implode($paths, ', ') . "'. Use the MAGENTO_ROOT " .
            "environment variable to set the path to the Magento root directory.");
    }

    /**
     * @param $path The path to test wether it is a Magento root directory
     * @return string|null Path to Magento root
     * @throws Exception when no Magento root was found and the root folder was encountered.
     */
    function findRoot($path): ?string
    {
        if ($this->validateDirectoryAsRootDir($path)) {
            return realpath($path);
        }
        if (!$this->isSystemRoot($path)) {
            return $this->findRoot($path . DIRECTORY_SEPARATOR . '..');
        }
        return null;
    }

    /**
     * Test if the given path is the system's root directory
     * @return bool false when it is not the system's root directory
     * @throws Exception When a match with the systems root directory is found
     */
    function isSystemRoot($path): bool
    {
        if (realpath($path) == DIRECTORY_SEPARATOR) {
            return true;
        }
        return false;
    }

    /**
     * @param $path The path to validate
     * @return bool true when it's a a Magento root directory, false when not.
     */
    function validateDirectoryAsRootDir($path): bool
    {
        static $root_identity = [
            'app',
            'bin',
            'dev',
            'lib',
            'pub',
            'setup',
            'var',
            'vendor',
            'vendor/magento/framework',
        ];
        foreach ($root_identity as $identity) {
            if (!is_dir($path . DIRECTORY_SEPARATOR . $identity)) {
                return false;
            }
        }
        return true;
    }
}