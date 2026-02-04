<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users;

use App\Enums\RoleEnum;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\Company;
use App\Models\User;
use App\Services\InvitationService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|UnitEnum|null $navigationGroup = 'Paramètres';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static ?string $modelLabel = 'Utilisateur';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::LockClosed;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom complet')
                    ->disabled(),
                TextInput::make('email')
                    ->label('Adresse email')
                    ->email()
                    ->required(),
                // DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Select::make('roles')
                    ->label('Rôles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $item) => RoleEnum::tryFrom($item->name)?->label() ?? $item->name)
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('member.company.name')
                    ->label('Entreprise')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Nom complet')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Rôles')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => RoleEnum::tryFrom($state)?->label() ?? $state),
                TextColumn::make('email_verified_at')
                    ->label('Vérifiée')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_login_at')
                    ->label('Dernière connexion')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('last_login_ip')
                    ->label('Dernière IP')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('company_id')
                    ->label('Entreprise')
                    ->options(Company::pluck('name', 'id'))
                    ->searchable(),
                SelectFilter::make('role')
                    ->label('Rôle')
                    ->options(Role::pluck('name', 'name'))
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->whereHas('user.roles', fn ($q) => $q->where('name', $data['value']));
                        }
                    }),
                Filter::make('verified')
                    ->label('Vérifié')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    Action::make('resend_invitation')
                        ->label('Renvoyer l\'invitation')
                        ->icon('heroicon-o-envelope')
                        ->color('info')
                        ->visible(fn (User $record) => $record->member !== null)
                        ->requiresConfirmation()
                        ->modalHeading("Renvoyer l'invitation")
                        ->modalDescription("Un nouvel email d'invitation sera envoyé à cet utilisateur pour définir son mot de passe.")
                        ->action(function (User $record) {
                            app(InvitationService::class)->sendInvitation($record, $record->member->company);
                        })
                        ->successNotificationTitle('Invitation renvoyée avec succès'),
                    Action::make('reset_password')
                        ->label('Réinitialiser le mot de passe')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Réinitialiser le mot de passe')
                        ->modalDescription('Un email de réinitialisation de mot de passe sera envoyé à cet utilisateur.')
                        ->action(function (User $record) {
                            $token = Password::broker()->createToken($record);
                            $resetUrl = url(route('password.reset', [
                                'token' => $token,
                                'email' => $record->email,
                            ], false));

                            $record->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
                        })
                        ->successNotificationTitle('Email de réinitialisation envoyé'),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create New')
                    ->url('#')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}
