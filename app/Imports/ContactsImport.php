<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactsImportHasFailed;
use App\Support\Phone\PhoneService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;

class ContactsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithEvents
{
    use Importable;

    public function __construct(public User $importedBy, public int $contactGroupId)
    {
    }

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $extraFields = [];
        try {
            collect(array_keys($row))
                ->map(fn ($key) => strtolower($key))
                ->filter(fn ($key) => ! in_array($key, ['phone', 'name', 'email']))
                ->each(fn ($key) => $extraFields[$key] = $row[$key]);

            $phone = $row['Phone'] ?? $row['phone'] ?? $row['PHONE'] ?? null;
            $phone = ($phone ? substr(PhoneService::formatPhoneNumber($phone), 1) : $phone);

            return new Contact([
                'contact_group_id' => $this->contactGroupId,
                'name' => $row['Name'] ?? $row['name'] ?? $row['NAME'] ?? null,
                'phone' => $phone,
                'email' => $row['Email'] ?? $row['email'] ?? $row['EMAIL'] ?? null,
                'extra_fields' => $extraFields,
            ]);
        } catch (\Exception $e) {
            report($e);
            Log::error($e->getMessage());
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                $this->importedBy->notify(new ContactsImportHasFailed($this->contactGroupId));
            },
        ];
    }
}
