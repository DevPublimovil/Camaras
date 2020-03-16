<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use League\Flysystem\Plugin\ListWith;
use App\Country;

class MediaController extends Controller
{
    /** @var string */
    private $filesystem;

    /** @var string */
    private $directory = '';

    public function __construct()
    {
        $this->filesystem = config('voyager.storage.disk');
    }

    public function index()
    {
        $paises = Country::orderBy('name','ASC')->get();
        return view('Media.galeria', compact('paises'));
    }

    public function files(Request $request)
    {
        $country = Country::select('id','name')->where('id',$request->country)->first();
        $folder = $request->folder;
        if ($folder == '/') {
            $folder = '';
        }
        
        $dir = $this->directory.$folder;
        $files = [];
        $storage = Storage::disk($this->filesystem)->addPlugin(new ListWith());
        $storageItems = $storage->listWith(['mimetype'], $dir);
        
        foreach ($storageItems as $item) {
            if ($item['type'] == 'dir') {
                $files[] = [
                    'name'          => $item['basename'],
                    'type'          => 'folder',
                    'path'          => Storage::disk($this->filesystem)->url($item['path']),
                    'relative_path' => $item['path'],
                    'items'         => '',
                    'last_modified' => '',
                ];
            } else {
                if (empty(pathinfo($item['path'], PATHINFO_FILENAME)) && !config('voyager.hidden_files')) {
                    continue;
                }
                $files[] = [
                    'name'          => $item['basename'],
                    'filename'      => $item['filename'],
                    'type'          => $item['mimetype'] ?? 'file',
                    'path'          => Storage::disk($this->filesystem)->url($item['path']),
                    'relative_path' => $item['path'],
                    'size'          => $item['size'],
                    'last_modified' => $item['timestamp'],
                ];
            }
        }

        return response()->json([
            'files' => $files,
            'country' => $country,
            'current_folder' => $dir
        ]);
    }
    public function store(Request $request)
    {
        $files = $request->file('image');
        $uploads  = [];
        if($request->hasFile('image')):
            foreach ($files as $key => $file):
                $img = Image::make(\file_get_contents($file))->encode($file->getClientOriginalExtension(),30);
                Storage::disk('public')->put('uploads/'.$file->getClientOriginalName(),$img);
                $uploads[] = 'uploads/'.$file->getClientOriginalName();
            endforeach;
        endif;

        return response()->json($uploads, 200);
    }

}
