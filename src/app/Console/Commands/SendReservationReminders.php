<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;

class SendReservationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-reservation-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to users with reservations today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();

        $reservations = Reservation::with(['user', 'shop', 'course'])
            ->whereDate('date', $today)
            ->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)->send(new ReservationReminderMail($reservation));
        }

        $this->info('リマインドメールを送信しました。');
    }
}
