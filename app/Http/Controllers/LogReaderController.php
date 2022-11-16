<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\ReadRequest;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\Readable\ReaderFactory;

class LogReaderController extends Controller
{
    public function home()
    {

        return Inertia::render(
            'Logs/Index',
            [
                'data' => []
            ]
        );

        // $data = [];
        // return view('welcome', compact('data'));
    }

    public function read(ReadRequest $request)
    {

        $readerFactory = new ReaderFactory();
        $data = $readerFactory->initialize($request->type, $request->file);

        $pp['total'] = (int)count($data);
        $pp['page'] =(int) 10;
        $pp['number_of_page'] = (int) round(count($data) / 10);
        //  return view('welcome', compact('data'));
        return Inertia::render(
            'Logs/Index',
            [
                'data' => $data,
                'pp' => $pp,
            ]
        );
    }
}
