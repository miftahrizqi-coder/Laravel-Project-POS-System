<?php

namespace App\Livewire\Items;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use App\Models\Inventory;
use Livewire\Component;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;
use Filament\Forms\Components\ToggleButtons;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
class EditInventory extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Inventory $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Edit Inventory Item')
                    ->description('Update your inventory item detail here')
                    ->columns(2)
                    ->schema([
                        Select::make('item_id')
                            ->relationship('item','name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('quantity')
                        ->numeric(),
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
        ->title('Inventory Item Updated')
        ->success()
        ->body('Inventory item has been updated succesfully!')
        ->send()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.edit-inventory');
    }
}
