<?php

namespace App\Jobs;

use File;
use Image;
use App\Models\Design;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $design;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Design $design)
    {
        $this->design = $design;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $disk = $this->design->disk;
        $file_name = $this->design->image;
        $original_file = \storage_path().'/uploads/original'.$file_name;

        try {
            // create the larg image and save to tmp disk
            Image::make($original_file)
            ->fit(800,600 ,function($constraint){
                $constraint->aspectRatio();
            })
            ->save($larg = \storage_path('uploads/larg'.$file_name));
            // create the thumbnail image and save to tmp disk
            Image::make($original_file)
            ->fit(800,600 ,function($constraint){
                $constraint->aspectRatio();
            })
            ->save($thumbnail = \storage_path('uploads/thumbnail'.$file_name));
            // store images to permanent disk
            // original image
            if(Stroage::disk($disk)->put('uploads/designs/original/'.$his->design->image,\fopen($original_file,'r+')))
            File::delete($original_file);

            // thumbnail image
            if(Stroage::disk($disk)->put('uploads/designs/thumbnail/'.$his->design->image,\fopen($thumbnail,'r+')))
            File::delete($thumbnail);

            // larg image
            if(Stroage::disk($disk)->put('uploads/designs/larg/'.$his->design->image,\fopen($larg,'r+')))
            File::delete($larg);

            // update database record with success flag
            $this->design->update(['upload_successfull'=>true]);
        } catch (\Exception $e) {
            //throw $th;
            Log::error($e->getMessage());
        }
    }
}
