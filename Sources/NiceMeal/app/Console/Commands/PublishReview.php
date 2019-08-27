<?php

namespace App\Console\Commands;

use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PublishReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'review:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish review after 24h not confirm';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $today = new Carbon();
            $today->addHours(-24);
            $number = Review::where('published',0)->whereIn('status',[0,1])->where('created_at' ,'<', $today->format('Y-m-d H:i:s'))->update(array('status'=> 2,'published'=> 1));
            $this->info($number .' Reviews published successfully');
        } catch (\Exception $exception) {
            $this->error('Error ' . $exception . ' when publish reviews.');
        }
    }
}
