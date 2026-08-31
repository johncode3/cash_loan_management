<?php

namespace App\Console\Commands;

use App\Models\LoanSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOverdueLoans extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'loans:check-overdue';

    /**
     * The console command description.
     */
    protected $description = 'Automatically scan and mark unpaid installments past due_date as Overdue';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::today()->format('Y-m-d');

        // Find all Pending installments where due_date is in the past
        $affectedRows = LoanSchedule::where('status', 'Pending')
            ->where('due_date', '<', $today)
            ->update(['status' => 'Overdue']);

        $this->info("Successfully scanned loan schedules. Updated {$affectedRows} installment(s) to 'Overdue'.");

        return Command::SUCCESS;
    }
}