<?php

namespace App\Livewire\Items;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Inventory;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ListInventories extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Inventory::query())
            ->columns([
                TextColumn::make('item.name')
                ->searchable()
                ->sortable(),
                TextColumn::make('quantity')
                ->sortable()
                ->alignCenter()
                ->badge()
                ->color(fn(int $state): string => match (true){
                    $state < 50 => 'danger',
                    $state < 100 => 'warning',
                    default => 'success'
                }),
                TextColumn::make('created_at')
                ->Toggleable(isToggledHiddenByDefault:true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Add New Inventory')
                    ->url(fn (): string => route('inventory.create'))
            ])
            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn (Inventory $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                        ->title('Deleted successfully')
                        ->success()
                    ),

                Action::make('edit')
                    ->url(fn (Inventory $record): string => route('inventory.edit', $record))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.items.list-inventories');
    }
}
