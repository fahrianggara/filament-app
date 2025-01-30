<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as FilamentLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class Login extends FilamentLogin
{
    /**
     * getHeading
     *
     * @return string
     */
    public function getHeading(): string | Htmlable
    {
        return __('Silakan masuk ke akun Anda');
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * Get the email form component.
     *
     * @return Component
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('username')
            ->label(__('Nama / Email'))
            ->required()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /**
     * throwFailureValidationException
     *
     * @return never
     */
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        $loginType = filter_var($data['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [
            $loginType => $data['username'],
            'password' => $data['password'],
        ];
    }
}
