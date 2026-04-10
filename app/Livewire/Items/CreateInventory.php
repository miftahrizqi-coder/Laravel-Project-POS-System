<?php

namespace App\Livewire\Items;

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
use App\Models\Inventory;
use Livewire\Component;

class CreateInventory extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Add Inventory Item')
                    ->description('Fill the form to add new inventory item')
                    ->columns(2)
                    ->schema([
                        Select::make('item_id')
                            ->required()
                            ->relationship('item','name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('quantity')
                        ->required()
                        ->numeric(),
                    ])
            ])
            ->statePath('data')
            ->model(Inventory::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Inventory::create($data);

        $this->form->model($record)->saveRelationships();
        Notification::make()
        ->title('Inventory Created')
        ->success()
        ->body('Inventory created succesfully!')
        ->send()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.create-inventory');
    }
}
