<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersFromExistingData extends Command
{
    protected $signature = 'users:create-from-old-data';
    protected $description = 'Create users login from existing agents, resellers, and affiliates';

    public function handle()
    {
        $this->info('Creating users for Agents...');
        $agents = Agent::all();
        foreach ($agents as $agent) {
            if (!$agent->user_id) {
                $user = User::create([
                    'name' => $agent->name,
                    'email' => $agent->email ?? $agent->name.'@example.com',
                    'role' => 'agent',
                    'password' => Hash::make('defaultpassword123'),
                    'perumahan_id' => $agent->perumahan_id ?? null,
                ]);
                $agent->user_id = $user->id;
                $agent->save();
            }
        }

        $this->info('Creating users for Resellers...');
        $resellers = Reseller::all();
        foreach ($resellers as $reseller) {
            if (!$reseller->user_id) {
                $user = User::create([
                    'name' => $reseller->nama,
                    'email' => $reseller->email ?? $reseller->nama.'@example.com',
                    'role' => 'reseller',
                    'password' => Hash::make('defaultpassword123'),
                    'perumahan_id' => null,
                ]);
                $reseller->user_id = $user->id;
                $reseller->save();
            }
        }

        $this->info('Creating users for Affiliates...');
        $affiliates = Affiliate::all();
        foreach ($affiliates as $affiliate) {
            if (!$affiliate->user_id) {
                $user = User::create([
                    'name' => $affiliate->name,
                    'email' => $affiliate->email ?? $affiliate->name.'@example.com',
                    'role' => 'affiliate',
                    'password' => Hash::make('defaultpassword123'),
                    'perumahan_id' => null,
                ]);
                $affiliate->user_id = $user->id;
                $affiliate->save();
            }
        }

        $this->info('Done creating users!');
    }
}
