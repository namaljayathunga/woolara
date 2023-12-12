<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DownloadProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $src;
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, string $src)
    {
        $this->id = $id;
        $this->src = $src;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contents = file_get_contents($this->src);
        $filename = uuid_create() . ".jpg";
        Storage::disk("public")->put($filename, $contents);

        Product::where('id', $this->id)->update(['image_filename' => $filename]);
    }
}
