<?php

namespace App\Jobs\Account;

use App\Models\Account\Profile;
use App\Models\Preferences\Communication;
use App\Models\Preferences\Security;
use App\Models\Security\OTP;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PHPGangsta_GoogleAuthenticator;

class SetupUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ga = new PHPGangsta_GoogleAuthenticator();
        Profile::create(['user_id' => $this->user_id]);
        Communication::create(['user_id' => $this->user_id]);
        Security::create(['user_id' => $this->user_id]);
        OTP::create(['user_id' => $this->user_id, 'secret' => $ga->createSecret()]);
    }
}
