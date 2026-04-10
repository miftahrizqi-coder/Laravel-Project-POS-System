<?php

namespace App\Livewire\Items;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use App\Models\Item;
use Livewire\Component;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\ToggleButtons;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;

class EditItem extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Item $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Edit Item')
                    ->description('Update your item detail here')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                        ->label('Item Name'),
                        TextInput::make('sku')
                        ->unique(),
                        TextInput::make('price')
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
                            ->grouped()
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
        ->title('Item Updated')
        ->success()
        ->body('Item has been updated succesfully!')
        ->send()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.edit-item');
    }
}
