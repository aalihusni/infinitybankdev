<?php
namespace App\Classes;

use Storage;

class S3Class
{
    public static function url($path)
    {
        $region = config('filesystems.disks')['s3']['region'];
        $bucket = config('filesystems.disks')['s3']['bucket'];
        //return asset($path);
        return trim("https://".$bucket.".s3-".$region.".amazonaws.com/".$path);
    }

    public static function syncLocalS3()
    {
        $local = Storage::disk('local')->files('/profiles');
        foreach ($local as $file)
        {
            $image = Storage::disk('local')->get($file);
            if (!Storage::exists($file)) {
                Storage::put($file, $image);
                echo $file."<br>";
            }
        }

        $local = Storage::disk('local')->files('/private/id_verify');
        foreach ($local as $file)
        {
            $image = Storage::disk('local')->get($file);
            if (!Storage::exists($file)) {
                Storage::put($file, $image);
                echo $file."<br>";
            }
        }

        $local = Storage::disk('local')->files('/private/photo_verify');
        foreach ($local as $file)
        {
            $image = Storage::disk('local')->get($file);
            if (!Storage::exists($file)) {
                Storage::put($file, $image);
                echo $file."<br>";
            }
        }
    }

    public static function syncS3Local()
    {
        $local = Storage::files('/profiles');
        foreach ($local as $file)
        {
            $image = Storage::get($file);
            if (!Storage::disk('local')->exists($file)) {
                Storage::disk('local')->put($file, $image);
                echo $file."<br>";
            }
        }

        $local = Storage::disk('local')->files('/private/id_verify');
        foreach ($local as $file)
        {
            $image = Storage::get($file);
            if (!Storage::disk('local')->exists($file)) {
                Storage::disk('local')->put($file, $image);
                echo $file."<br>";
            }
        }

        $local = Storage::disk('local')->files('/private/photo_verify');
        foreach ($local as $file)
        {
            $image = Storage::get($file);
            if (!Storage::disk('local')->exists($file)) {
                Storage::disk('local')->put($file, $image);
                echo $file."<br>";
            }
        }
    }

    public static function purgeLocal()
    {
        $local = Storage::disk('local')->files('/profiles');
        foreach ($local as $file)
        {
            Storage::disk('local')->delete($file);
        }

        $local = Storage::disk('local')->files('/private/id_verify');
        foreach ($local as $file)
        {
            Storage::disk('local')->delete($file);
        }

        $local = Storage::disk('local')->files('/private/photo_verify');
        foreach ($local as $file)
        {
            Storage::disk('local')->delete($file);
        }
    }
}