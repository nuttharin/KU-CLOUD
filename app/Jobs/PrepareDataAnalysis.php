<?php

namespace App\Jobs;

use App\Weka\ConvertJsonToArff;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrepareDataAnalysis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data_id;
    public $pathArray;
    public $name;
    public $convert;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data_id, $pathArray, $name)
    {
        $this->data_id = $data_id;
        $this->pathArray = $pathArray;
        $this->name = $name;
        $this->convert = new ConvertJsonToArff();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->convert->convertToAttr($this->pathArray, $this->name, $this->data_id);
    }
}
