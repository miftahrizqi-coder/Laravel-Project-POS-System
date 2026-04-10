<?php

namespace App\Livewire\Management;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\User;

class EditUser extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public User $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Edit user')
                    ->description('Update the user detail here')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('email')
                            ->unique(ignoreRecord: true),
                        Select::make('role')
                            ->options([
                                'cashier' => 'Cashier',
                                'admin' => 'Admin',
                                'other' => 'Other',
                            ])
                            ->native(false),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->unique(ignoreRecord: true),
                    ])
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);

        Notification::make()
            ->title('User Updated!')
            ->success()
            ->body("User has been updated successfully!")
            ->send();
    }

    public function render(): View
    {
        return view('livewire.management.edit-user');
    }
}
