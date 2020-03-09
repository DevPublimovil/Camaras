<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use League\Flysystem\Plugin\ListWith;

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
        return view('Media.galeria');
    }

    public function files(Request $request)
    {
        $folder = $request->folder;
        
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
                    'thumbnails'    => [],
                ];
            }
        }

        return response()->json($files);
    }
}
