<?php

declare(strict_types=1);

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\User;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->label('Entreprise')
                    ->relationship('company', 'name')
                    ->required(),
                Select::make('user_id')
                    ->label('Auth user')
                    ->relationship('user', 'name')
                    ->options(
                        User::whereDoesntHave('member')
                            ->pluck('name', 'id')
                    )
                    ->native(false)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nom complet'),
                        TextInput::make('email')
                            ->label('Adresse email')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->required()
                            ->revealable(),
                    ]),
                TextInput::make('firstname')
                    ->label('Prénom'),
                TextInput::make('lastname')
                    ->label('Nom'),
                TextInput::make('phone_number')
                    ->label('Téléphone')
                    ->tel(),
            ]);
    }
}
