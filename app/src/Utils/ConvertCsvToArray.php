<?php

namespace App\Utils;

use SplFileObject;

class ConvertCsvToArray
{
    /**
     * @param $filename
     * @return void
     */
    private static function checks($filename)
    {
        if(!file_exists($filename)) {
            throw new \RuntimeException('File not exists: '. $filename);
        }

        if(!is_readable($filename)) {
            throw new \RuntimeException('File is not readable!');
        }
    }

    /**
     * @param $filename
     * @return int
     */
    public static function countLines($filename){
        static::checks($filename);
        $file = new SplFileObject($filename, 'r');
        $file->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::READ_AHEAD |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );

        $file->seek(PHP_INT_MAX);

        $cnt = $file->key() - 1;
        $file->rewind();
        return $cnt;
    }

    /**
     * @param $filename
     * @param string $delimiter
     * @param string $enclosure
     * @return array|bool
     */
    public static function convertIteration($filename, $delimiter = ',', $enclosure = '"')
    {
        static::checks($filename);

        $header = null;
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== false) {
                if(!$header) {
                    $header = $row;
                } else {
                    yield array_combine($header, $row);
                }
            }
            fclose($handle);
        }
    }
}