<?php

namespace App\Console\Commands;

use App\Models\Consultation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCompleteConsultationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark past confirmed consultations as completed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now();

        $consultations = Consultation::where('status', 'confirmed')
            ->where('end_time', '<=', $now)
            ->get();

        $count = $consultations->count();
        $this->info("Found {$count} consultations to complete.");

        foreach ($consultations as $consultation) {
            $consultation->update(['status' => 'completed']);
            Log::info("Consultation #{$consultation->id} auto-completed.");
        }

        $this->info("Completed {$count} consultations.");

        return Command::SUCCESS;
    }
}

