<?php

namespace App\Filament\Resources\GithubRepos\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn; // Import ToggleColumn for the checkbox
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\GithubRepo; // Ensure this model exists
use Filament\Notifications\Notification;
class GithubReposTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. CHECKBOX: Matches 'show' column in your model
            ToggleColumn::make('show')
                ->label('Show on Portfolio')
                ->tooltip('Toggle to show or hide this repository')
                ->afterStateUpdated(function ($record, $state) {
                    // $state is the new boolean value (true/false)
                    // $record is the GithubRepo model instance
                    
                    // Example: Show a notification
                    Notification::make()
                        ->title($state ? 'Repository visible' : 'Repository hidden')
                        ->body("{$record->full_name} has been " . ($state ? 'shown on' : 'hidden from') . " your portfolio.")
                        ->success()
                        ->send();
                        
                    // Example: Clear portfolio cache so changes appear immediately
                    // Cache::forget('portfolio_repos');
                }),

                // 2. REPOSITORY NAME: Matches 'full_name'
                TextColumn::make('full_name')
                    ->label('Repository')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                // 3. LANGUAGE: We can extract this from full_name or add a 'language' column if you prefer
                // Since your model doesn't have a 'language' column, I'll use 'pushed_at' for sorting context
                TextColumn::make('pushed_at')
                    ->label('Last Pushed')
                    ->dateTime('M j, Y')
                    ->sortable(),

                // 4. STATS: Matches your integer columns
                TextColumn::make('stargazers_count')
                    ->label('Stars')
                    ->numeric()
                    ->sortable()
                    ->icon('heroicon-s-star'),

                TextColumn::make('watchers_count')
                    ->label('Watchers')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('forks_count')
                    ->label('Forks')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // 5. URL: Matches 'html_url'
                TextColumn::make('html_url')
                    ->label('Link')
                    ->url(fn ($record) => $record->html_url)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('ssh_url')
                    ->label('SSH URL')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('pushed_at', 'desc')
            ->headerActions([
                                Action::make('FetchAgain')
                ->label('Fetch')
                ->icon('heroicon-o-arrow-path')
                ->action(function(){
                    $userId = auth()->id();
                    $user = User::findOrFail($userId);
                    $username= $user->github_username;
                    if($username){
                        $response = Http::get("https://api.github.com/users/$username/repos?sort=updated&direction=desc&per_page=100");

                        if ($response->successful()) {
                            $repos = $response->json();

                            // 3. Cache the response
                            Cache::put("github_api_data_$username", $repos, now()->addMinutes(30));

                            // 4. Save to Database
                            // We clear existing repos for this user to avoid duplicates, then insert the fresh list
                            GithubRepo::where('user_id', $userId)->delete();

                            $insertData = collect($repos)->map(fn ($repo) => [
                                'user_id' => $userId,
                                'full_name' => $repo['full_name'],
                                'html_url' => $repo['html_url'],
                                'description' => $repo['description'],
                                'ssh_url' => $repo['ssh_url'],
                                'stargazers_count' => $repo['stargazers_count'],
                                'watchers_count' => $repo['watchers_count'],
                                'forks_count' => $repo['forks_count'],
                                'pushed_at' => $repo['pushed_at'],
                                'show' => false, 
                                'created_at' => now(),
                                'updated_at' => now(),
                            ])->toArray();

                            if (!empty($insertData)) {
                                GithubRepo::insert($insertData);
                            }
                        } else {
                            throw new \Exception('Failed to fetch GitHub repositories. Please check the username and try again.');
                        }
                        return    Notification::make()
                                    ->title('fetched successfully')
                                    ->body("your repos are updated")
                                    ->success()
                                    ->send(); 
                    }
                Notification::make()
                    ->title('Sign Your Username First')
                    ->body("You can sign your username using the 'Fetch Your GitHub Repos' button.")
                    ->danger()
                    ->icon('heroicon-o-arrow-path')
                    ->send();
                }),
                Action::make('fetchAndSyncGithubRepos')
                    ->label('Fetch Your GitHub Repos')
                    ->icon('heroicon-o-cloud-arrow-down')
                    ->modalHeading('Enter GitHub Username')
                    ->modalDescription('This will fetch public repositories, cache them, and save them to your database.')
                    ->modalWidth('md')
                    ->form([
                        TextInput::make('github_username')
                            ->label('GitHub Username')
                            ->placeholder('e.g., shayanir85')
                            ->required()
                            ->maxLength(255)
                            ->alphaDash(),
                    ])
                    ->action(function (array $data) {
                        $username = $data['github_username'];
                        $userId = auth()->id();

                        // 1. Update the authenticated user's GitHub username
                        $user = User::findOrFail($userId);
                        $user->github_username = $username;
                        $user->save();

                        // 2. Fetch data from GitHub API
                        $response = Http::get("https://api.github.com/users/$username/repos?sort=updated&direction=desc&per_page=100");

                        if ($response->successful()) {
                            $repos = $response->json();

                            // 3. Cache the response
                            Cache::put("github_api_data_$username", $repos, now()->addMinutes(30));

                            // 4. Save to Database
                            // We clear existing repos for this user to avoid duplicates, then insert the fresh list
                            GithubRepo::where('user_id', $userId)->delete();

                            $insertData = collect($repos)->map(fn ($repo) => [
                                'user_id' => $userId,
                                'full_name' => $repo['full_name'],
                                'html_url' => $repo['html_url'],
                                'description' => $repo['description'],
                                'ssh_url' => $repo['ssh_url'],
                                'stargazers_count' => $repo['stargazers_count'],
                                'watchers_count' => $repo['watchers_count'],
                                'forks_count' => $repo['forks_count'],
                                'pushed_at' => $repo['pushed_at'],
                                'show' => false, 
                                'created_at' => now(),
                                'updated_at' => now(),
                            ])->toArray();

                            if (!empty($insertData)) {
                                GithubRepo::insert($insertData);
                            }
                        } else {
                            throw new \Exception('Failed to fetch GitHub repositories. Please check the username and try again.');
                        }
                    }),
            ])
            ->filters([
                // Optional: Add a filter to quickly hide unchecked repos in the table view
                // \Filament\Tables\Filters\TernaryFilter::make('is_visible')->label('Visibility'),
            ])
            ->recordActions([

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}