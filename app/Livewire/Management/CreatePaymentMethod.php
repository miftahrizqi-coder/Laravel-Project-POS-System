<?php

namespace App\Livewire\Management;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\PaymentMethod;

class CreatePaymentMethod extends Component implements HasActions, HasSchemas
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
                Section::make('Add Payment Method')
                    ->description('Fill the form to add new payment method')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->label('Payment Method Name'),
                        Textarea::make('description')
                        ->required()
                        ,
                    ])
            ])
            ->statePath('data')
            ->model(PaymentMethod::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = PaymentMethod::create($data);

        $this->form->model($record)->saveRelationships();
        Notification::make()
        ->title('Payment Method Created')
        ->success()
        ->body('Payment Method created succesfully!')
        ->send()
        ;
    }

    public function render(): View
    {
        return view('livewire.management.create-payment-method');
    }
}
