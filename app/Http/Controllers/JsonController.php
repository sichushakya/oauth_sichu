<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class JsonController extends Controller
{
    /**
     * Show the Json upload form.
     *
     * @return null
     */
    public function index()
    {

        $files = Storage::files('public/uploads'); //returns path with names
        $json_filenames = array_map('basename', $files); //returns names


        return view('json.index', compact('json_filenames'));
    }

    /**
     * Upload the Json.
     *
     * @param Request $request
     */
    public function uploadJson(Request $request)
    {
       // dd($request->file('jsonFile')->getMimeType());

        //Since validation for one field only, I have validated the data in this controller itself rather than validating in a separate Form Request Class
        $request->validate([
            'jsonFile' => 'required|file|mimes:json,txt|max:4096', // JSON file, max size 4MB
        ]);

        if ($request->file('jsonFile')->isValid()) {

            $filename = $request->file('jsonFile')->getClientOriginalName();

            //stores in storage/app/public/uploads
           $request->file('jsonFile')->storeAs('uploads', $filename ,'public');

            $notification = [
                'message' => 'Json file sucessfully uploaded !',
                'color' => '#3b3'
            ];

            return redirect()->route('form')->with(compact('notification'));
        }

        $notification = [
            'message' => 'Upload failed',
            'color' => 'red'
        ];

        return redirect()->route('form')->with(compact('notification'));
    }

    /**
     *  Export Json file to Excel.
     *
     * @param Request $request
     *
     */
    public function exportJson()
    {
       // return Excel::download(new UsersExport, 'users.xlsx'); //syntax for when using Excel facade

        /**  Exporting to client's computer WITHOUT queueing. */
        //return (new UsersExport())->download('users.xlsx'); //syntax for when using Exportable trait



        /** Exporting to storage/app/exports WITH queue */
         (new UsersExport())->queue('exports/users.xlsx'); //takes a bit of time

        $notification = [
            'message' => 'Export has started',
            'color' => '#3b3'
        ];

        return redirect()->route('form')->with(compact('notification'));
    }


}
