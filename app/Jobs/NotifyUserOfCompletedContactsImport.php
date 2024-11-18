<?php

namespace App\Jobs;

use App\Models\ContactGroup;
use App\Models\User;
use App\Notifications\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedContactsImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user, public int $contactGroupId)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contactGroup = ContactGroup::find($this->contactGroupId);
        $route = route('contacts.groups.show', $contactGroup->id);
        $message = "Hello, {$this->user->name}.\nYour contacts have been imported into '{$contactGroup->name}' successfully! You can view them on the application via the link below.\n\n{$route}";

        $this->user->notify(new SendMessage([
            'message' => $message,
            'sender' => config('app.sender'),
        ]));
    }
}
