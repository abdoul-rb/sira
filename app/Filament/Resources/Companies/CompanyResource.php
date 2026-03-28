<?php

declare(strict_types=1);

namespace App\Filament\Resources\Companies;

use App\Filament\Resources\Companies\Pages\ManageCompanies;
use App\Models\Company;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationLabel = 'Entreprises';

    protected static ?string $modelLabel = 'Entreprise';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('country')
                    ->label('Pays'),
                Toggle::make('active')
                    ->required(),
                TextInput::make('logo_path')
                    ->label('Logo (chemin)'),
                TextInput::make('facebook_url')
                    ->label('Facebook')
                    ->url()
                    ->placeholder('https://facebook.com/...'),
                TextInput::make('instagram_url')
                    ->label('Instagram')
                    ->url()
                    ->placeholder('https://instagram.com/...'),
                TextInput::make('tiktok_url')
                    ->label('TikTok')
                    ->url()
                    ->placeholder('https://tiktok.com/@...'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('slug')
                    ->label('Slug'),
                ImageColumn::make('logo_path')
                    ->disk('public'),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('country')
                    ->label('Pays')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('members_count')
                    ->counts('members')
                    ->label('Membres'),
                TextColumn::make('facebook_url')
                    ->label('Facebook')
                    ->formatStateUsing(fn (?string $state) => $state ? Str::limit($state, 30) : '—')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('instagram_url')
                    ->label('Instagram')
                    ->formatStateUsing(fn (?string $state) => $state ? Str::limit($state, 30) : '—')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tiktok_url')
                    ->label('TikTok')
                    ->formatStateUsing(fn (?string $state) => $state ? Str::limit($state, 30) : '—')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')
                    ->boolean(),
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
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                ActionGroup::make([
                    DeleteAction::make()
                        ->label('Suppression douce')
                        ->modalHeading("Mettre l'entreprise à la corbeille ?"),
                    RestoreAction::make(),
                    ForceDeleteAction::make()
                        ->label('Suppression définitive')
                        ->modalHeading("Supprimer définitivement l'entreprise et ses utilisateurs ?")
                        ->visible(fn (Company $record) => true) // Force la visibilité même si non supprimé
                        ->before(function (Company $record) {
                            // Supprimer tous les utilisateurs rattachés aux membres de cette entreprise
                            $record->members()->with('user')->get()->each(function ($member) {
                                if ($member->user) {
                                    $member->user->delete();
                                }
                            });
                        }),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make()
                        ->before(function (\Illuminate\Support\Collection $records) {
                            $records->each(function (Company $company) {
                                $company->members()->with('user')->get()->each(function ($member) {
                                    if ($member->user) {
                                        $member->user->delete();
                                    }
                                });
                            });
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCompanies::route('/'),
        ];
    }
}
