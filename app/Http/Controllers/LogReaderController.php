<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\Readable\ReaderFactory;

class LogReaderController extends Controller
{
    public function home()
    {
        $data = [];
        return view('welcome', compact('data'));
    }

    public function read(Request $request)
    {
     
        $readerFactory = new ReaderFactory();
        $data = $readerFactory->initialize($request->type, $request->file);
        return view('welcome', compact('data'));
    }
}
