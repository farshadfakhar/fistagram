<?php 
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

use App\Http\Services\InstagramService;

use App\User;

class InstagramCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'instagram:login';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Serve the application on the PHP development server";
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    { }
    /**
     * Get the console command options.
     *
     * @return array
     */

    public function handle()
    {
        $service = new InstagramService();
        // $this->info($service->startBot());
        return User::all()->map(function ($user) use($service){
            $instagram = $service->login($user->insta_user, $user->insta_pass);
            $queue = $service->checkAndFillQueue($user);
            $this->info($service->followFromQueue($queue));
        });
    }
}
