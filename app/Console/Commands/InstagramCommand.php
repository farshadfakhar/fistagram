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
        return User::where(['active' => 1,'insta_error' => 0])->get()->map(function ($user) use($service){
            $this->info("Bot is going to login  $user->insta_user");
            // $instagram = $service->login($user->insta_user, $user->insta_pass);
            $service->setUserAccount($user);
            $service->log("Bot Started",'start');
            $instagram = $service->login();
            if($instagram['status'] == 'error'){
                $this->info("ERROOOOR");
                $this->info($instagram['error']);
                return false;
            }
            else{
                $this->info("User $user->insta_user with password $user->insta_pass logined in $instagram[status] way");
                $queue = $service->checkAndFillQueue($user);
                // $this->info("Going to follow $queue");
                $this->info($service->followFromQueue($queue,$user));
            }
        });
    }
}
