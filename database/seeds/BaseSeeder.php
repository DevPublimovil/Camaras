<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;
use Intervention\Image\ImageManager;

abstract class BaseSeeder extends Seeder
{
    /**
     * The filesystem instance
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Import rows from json file to table.
     * @return void
     */
    protected function import($table)
    {
        $this->command->info("Begin table: {$table}");
        $file = database_path("import/{$table}.json");
        $rows = json_decode($this->container['files']->get($file), true);

        collect($rows)->each(function ($row) use ($table) {
            $exists = false;
            $data   = $this->row($this->makeRow($row, $table));

            if (isset($row['id'])) {
                $exists = $this->container['db']->table($table)
                    ->where('id', $row['id'])
                    ->count() > 0;
            }

            if ($exists) {
                $this->container['db']->table($table)
                    ->where('id', $row['id'])
                    ->update($data);
            } else {
                $row['id'] = $this->container['db']->table($table)
                    ->insertGetId($data);
            }
        });
        $this->command->info("Done table: {$table}");
    }

    /**
     * Parse the input data into a
     * @param  array   $row
     * @param  string  $table
     * @return array
     */
    protected function makeRow(array $row, $table)
    {
        $now = Carbon::now();
        $row = collect(array_merge([
            'created_at' => $now,
            'updated_at' => $now,
        ], $row));

        $new_row = $row->map(function ($value, $column) use ($table, $row) {
            if (is_array($value)) {
                if (isset($value['file'])) {
                    switch (true) {
                        case $value['file'] === 'video':
                            $job          = $this->saveVideo($value, $table);
                            $row['thumb'] = "{$table}/{$job->thumbnail()}";
                            $row['share'] = "{$table}/{$job->shareImage()}";
                            return "{$table}/{$job->destination()}";
                            break;

                        case $value['file'] === 'file':
                            return json_encode([
                                [
                                    'download_link' => $this->saveFile($value['path'], $table),
                                    'original_name' => basename($value['path']),
                                ]
                            ]);
                            break;
                        case $value['file'] === 'image':
                            $save_value = $this->saveFile($value['path'], $table);

                            if (isset($value['thumbnails'])) {
                                $this->saveThumbnails($value['thumbnails'], $save_value);
                            }

                            return $save_value;
                            break;
                        case $value['file'] === 'images':
                            $save_value = [];

                            foreach ($value['paths'] as $path) {
                                $image = $this->saveFile($path, $table);
                                $save_value []= $image;

                                if (isset($value['thumbnails'])) {
                                    $this->saveThumbnails($value['thumbnails'], $image);
                                }
                            }

                            return json_encode($save_value);
                            break;
                        default:
                            return $this->saveFile($value['path'], $table);
                    }
                }

                if (isset($value['html'])) {
                    return nl2p($value['value']);
                }

                if (isset($value['slug'])) {
                    $row['slug'] = str_slug($value['value']);
                    return $value['value'];
                }

                if (isset($value['route'])) {
                    return route($value['route']);
                }
            }

            return $value;
        });

        return array_merge($row->toArray(), $new_row->toArray());
    }

    /**
     * Save a files
     * @param  array $value
     * @return string
     */
    protected function saveFile($path, $table)
    {
        $files      = $this->getFilesystem();
        $extension  = $files->extension($from = $path);
        $now        = Carbon::now();
        $directory  = "{$table}/{$now->format('Y-m-d')}";
        $filename   = str_random(20) . ".{$extension}";
        $save_value = "{$directory}/" . $filename;
        $to         = storage_path("app/public/{$save_value}");

        if (!$files->exists($folder = dirname($to))) {
            $files->makeDirectory($folder, 0755, true, true);
        }

        if (!starts_with($from, ['http:', 'https:'])) {
            $files->copy(base_path($from), $to);
        } else {
            $options = [];

            if (starts_with($from, 'https:')) {
                $options['ssl'] = [
                    'verify_peer'      => false,
                    'verify_peer_name' => false,
                ];
            }

            $this->command->info("downloading: {$from}");
            $data = fopen($from, 'rb', false, stream_context_create($options));
            file_put_contents($to, $data);
            $this->command->info("downloaded as: {$to}");
        }

        return $save_value;
    }

    /**
     * Save a video file
     * @param  array $value
     * @return \App\Jobs\UploadVideoAdmin
     */
    protected function saveVideo(array $value, $table)
    {
        $file   = $this->saveFile($value['path'], $table);
        $source = storage_path("app/public/{$file}");
        $job    = new UploadVideoAdmin($source);

        dispatch($job->path($table));

        return $job;
    }

    public function saveThumbnails(array $thumbnails, $source)
    {
        $source = storage_path("app/public/{$source}");
        foreach ($thumbnails as $name => $resize) {
            if (isset($resize['crop'])) {
                $image = app(ImageManager::class)
                    ->make($source)
                    ->fit($resize['crop']['width'], $resize['crop']['height'])
                    ->save(
                        preg_replace(
                            '/\.([a-zA-Z]+)$/',
                            "-{$name}.\$1",
                            $source
                        )
                    );
            }
            if (isset($resize['contain'])) {
                $logo = app(ImageManager::class)
                    ->make($source)
                    ->resize($resize['contain']['width'], $resize['contain']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                app(ImageManager::class)
                    ->canvas($resize['contain']['width'], $resize['contain']['height'], '#ffffff')
                    ->insert($logo, 'center')
                    ->save(
                        preg_replace(
                            '/\.([a-zA-Z]+)$/',
                            "-{$name}.\$1",
                            $source
                        )
                    );
            }
        }
    }

    /**
     * Modify a row before insert
     * @param  array  $row
     * @return array
     */
    protected function row(array $row)
    {
        return $row;
    }

    /**
     * Get the current filesystem
     * @return \Illuminate\Filesystem\Filesystem
     */
    protected function getFilesystem()
    {
        if (!$this->filesystem) {
            $this->filesystem = app('files');
        }

        return $this->filesystem;
    }
}
