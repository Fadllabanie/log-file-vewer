<?php

namespace App\Http\Interfaces\Readable;

use App\Http\Interfaces\Readable\Path;
use App\Http\Interfaces\Readable\Upload;

class ReaderFactory
{
    public function initialize(string $type, $file)
    {
        switch ($type) {
            case 'upload':
                $class =  new Upload($file);
                $data = $class->read();
                return $data;
            case 'path':
                $class =  new Path($file);
                $data = $class->read();
                return $data;
            default:
                throw new \Exception("read method not supported");
                break;
        }
    }
}
