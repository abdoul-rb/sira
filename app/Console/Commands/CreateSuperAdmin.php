<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sira:create-super {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un super administrateur';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("Création d'un super administrateur");
        $this->newLine();

        // Récupération des données
        $email = $this->option('email') ?: $this->ask('Email du super admin');
        $password = $this->option('password') ?: $this->secret('Mot de passe du super admin');

        // Validation des données
        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        // Vérification que le rôle super-admin existe
        if (! \Spatie\Permission\Models\Role::where('name', 'super-admin')->exists()) {
            $this->error("Le rôle 'super-admin' n'existe pas. Exécutez d'abord le seeder des rôles.");

            return 1;
        }

        // Création du super admin
        try {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                // company_id reste null pour le super admin
            ]);

            // Attribution du rôle super-admin
            $user->assignRole('super-admin');

            $this->info('Super administrateur créé avec succès !');
            $this->table(
                ['Email', 'Rôle'],
                [[$user->email, 'super-admin']]
            );

            return 0;
        } catch (\Exception $e) {
            $this->error('Erreur lors de la création du super admin : ' . $e->getMessage());

            return 1;
        }
    }
}
