<?php

namespace App\Http\Interfaces\Readable;

use App\Http\Interfaces\Readable\ReadableInterface;


class Path implements ReadableInterface
{

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function read()
    {
        //  log.txt in public folder
        $fileContent = file_get_contents(public_path($this->file));

        if (empty($fileContent)) {
            return response()->json([
                'success' => false,
                'message' => 'empty  log file  '
            ]);
        }

        $pattern = "\n";

        $fileContent = explode($pattern, trim($fileContent));

        return $fileContent;
    }
}
