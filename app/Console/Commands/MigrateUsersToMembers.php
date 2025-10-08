<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\User;
use Illuminate\Console\Command;

class MigrateUsersToMembers extends Command
{
    protected $signature = 'migrate:users-to-members';

    protected $description = 'Migrate existing users into members and link them properly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNotNull('company_id')->get();
        $count = 0;

        foreach ($users as $user) {
            $this->line("Migration #{$user->id} - {$user->email}");

            Member::create([
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'phone_number' => $user->phone_number,
            ]);

            $count++;
        }

        $this->info("{$count} users successful migrated ...");
        return Command::SUCCESS;
    }
}
