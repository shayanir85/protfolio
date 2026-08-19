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
                
            ToggleColumn::make('show')
                ->label('نمایش در پورتفولیو')
                ->tooltip('تغییر وضعیت نمایش یا عدم نمایش این مخزن')
                ->afterStateUpdated(function ($record, $state) {

                    Notification::make()
                        ->title($state ? 'مخزن نمایان شد' : 'مخزن پنهان شد')
                        ->body("مخزن {$record->full_name} در پورتفولیو " . ($state ? 'نمایش داده شد.' : 'پنهان شد.'))
                        ->success()
                        ->send();
                }),

                TextColumn::make('full_name')
                    ->label('مخزن')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('pushed_at')
                    ->label('آخرین ارسال')
                    ->dateTime('M j, Y')
                    ->sortable(),

                TextColumn::make('stargazers_count')
                    ->label('ستاره‌ها')
                    ->numeric()
                    ->sortable()
                    ->icon('heroicon-s-star'),

                TextColumn::make('watchers_count')
                    ->label('دنبال‌کنندگان')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('forks_count')
                    ->label('فورک‌ها')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('html_url')
                    ->label('لینک')
                    ->url(fn ($record) => $record->html_url)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('ssh_url')
                    ->label('آدرس SSH')
                    ->copyable()
                    ->copyMessage('کپی شد!')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('pushed_at', 'desc')
            ->headerActions([
                Action::make('FetchAgain')
                ->label('بروزرسانی مجدد')
                ->icon('heroicon-o-arrow-path')
                ->action(function(){
                    $userId = auth()->id();
                    $user = User::findOrFail($userId);
                    $username= $user->github_username;
                    if($username){
                        $response = Http::withoutVerifying()->get("https://api.github.com/users/$username/repos");

                        if ($response->successful()) {
                            $repos = $response->json();

                            Cache::put("github_api_data_$username", $repos, now()->addMinutes(30));

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
                                GithubRepo::updateOrCreate($insertData);
                            }
                        } else {
                            throw new \Exception('دریافت مخازن گیت‌هاب با خطا مواجه شد. لطفاً نام کاربری را بررسی کرده و مجدد تلاش کنید.');
                        }
                        return Notification::make()
                                    ->title('با موفقیت دریافت شد')
                                    ->body("مخازن شما با موفقیت بروزرسانی شدند")
                                    ->success()
                                    ->send(); 
                    }
                Notification::make()
                    ->title('ابتدا نام کاربری گیت‌هاب خود را ثبت کنید')
                    ->body("می‌توانید با دکمه 'دریافت مخازن گیت‌هاب' نام کاربری خود را ثبت کنید.")
                    ->danger()
                    ->icon('heroicon-o-arrow-path')
                    ->send();
                }),
                Action::make('fetchAndSyncGithubRepos')
                    ->label('دریافت مخازن گیت‌هاب')
                    ->icon('heroicon-o-cloud-arrow-down')
                    ->modalHeading('ورود نام کاربری گیت‌هاب')
                    ->modalDescription('مخازن عمومی شما دریافت و در پایگاه داده ذخیره خواهند شد.')
                    ->modalWidth('md')
                    ->form([
                        TextInput::make('github_username')
                            ->label('نام کاربری گیت‌هاب')
                            ->placeholder('مثال: shayanir85')
                            ->required()
                            ->maxLength(255)
                            ->alphaDash(),
                    ])
                    ->action(function (array $data) {
                        $username = $data['github_username'];
                        $userId = auth()->id();

                        $user = User::findOrFail($userId);
                        $user->github_username = $username;
                        $user->save();

                        $response = Http::withoutVerifying()->get("https://api.github.com/users/$username/repos?sort=updated&direction=desc&per_page=100");

                        if ($response->successful()) {
                            $repos = $response->json();

                            Cache::put("github_api_data_$username", $repos, now()->addMinutes(30));

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
                            throw new \Exception('دریافت مخازن گیت‌هاب با خطا مواجه شد. لطفاً نام کاربری را بررسی کرده و مجدد تلاش کنید.');
                        }
                    }),
            ])
            ->filters([

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