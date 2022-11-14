<?php

namespace App\Http\Interfaces\Readable;

use App\Http\Interfaces\Readable\ReadableInterface;


class Upload implements ReadableInterface
{

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function read()
    {
        $fileContent = file_get_contents($this->file);
      


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
