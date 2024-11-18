<?php

namespace App\Imports;

use App\Jobs\NotifyGuestsViaSms;
use App\Models\Event;
use App\Models\Guest;
use App\Models\User;
use App\Support\Phone\PhoneService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;

class GuestsImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue, WithEvents
{
    use Importable;

    public function __construct(public User $importedBy, public Event $event, public int $guestsPerTable)
    {
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                // notify user who imported the file
            },
        ];
    }

    public function collection(Collection $rows)
    {
        $tableNumber = $this->event->guests->last()?->assigned_table_number ?? 0;

        $guestCount = 0;

        foreach ($rows as $row) {
            $phone = $row['Phone'] ?? $row['phone'] ?? $row['PHONE'] ?? null;
            $phone = ($phone ? substr(PhoneService::formatPhoneNumber($phone), 1) : $phone);

            if ($guestCount % $this->guestsPerTable === 0) {
                $tableNumber++;
            }

            $guestCount++;

            $guest = Guest::create([
                'name' => $row['Name'] ?? $row['name'] ?? $row['NAME'] ?? null,
                'phone' => $phone,
                'event_id' => $this->event->id,
                'assigned_table_number' => $tableNumber,
            ]);
            if ($guest) {
                NotifyGuestsViaSms::dispatch($guest, $this->event);
            }
        }
    }
}
