<?php

namespace App\Livewire\Items;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\View\View;
use App\Models\Item;
use Livewire\Component;

class CreateItem extends Component implements HasActions, HasSchemas
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
                Section::make('Add Item')
                    ->description('Fill the form to add new item')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->label('Item Name'),
                        TextInput::make('sku')
                        ->required()
                        ->unique(),
                        TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('IDR')
                            ->suffixAction(
                                Action::make('copyCostToPrice')
                                    ->icon(Heroicon::Clipboard),
                                ),
                        ToggleButtons::make('status')
                            ->label('Is This Item Active?')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'In Active',
                            ])
                            ->colors([
                                'active' => 'success',
                                'inactive' => 'danger'
                            ])
                            ->default('active')
                            ->grouped()
                    ])
            ])
            ->statePath('data')
            ->model(Item::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Item::create($data);

        $this->form->model($record)->saveRelationships();
        Notification::make()
        ->title('Item Created')
        ->success()
        ->body('Item created succesfully!')
        ->send()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.create-item');
    }
}
