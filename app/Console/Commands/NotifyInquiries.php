<?php

namespace App\Console\Commands;

use App\Models\Inquiry;
use App\Services\InquiryNotifier;
use Illuminate\Console\Command;

class NotifyInquiries extends Command
{
    protected $signature = 'detra:inquiries:notify {--id= : Envoyer une demande précise encore en attente} {--limit=20 : Nombre maximal de demandes à envoyer}';

    protected $description = 'Transmettre par SMTP les demandes qui ne sont pas encore notifiées';

    public function handle(InquiryNotifier $notifier): int
    {
        if (config('mail.default') !== 'smtp') {
            $this->error('Configurez le transport SMTP avant de transmettre les demandes.');

            return self::FAILURE;
        }

        $query = Inquiry::query()->whereNull('notification_sent_at')->orderBy('id');

        if ($this->option('id') !== null) {
            if (! ctype_digit((string) $this->option('id')) || (int) $this->option('id') < 1) {
                $this->error('Identifiant de demande invalide.');

                return self::FAILURE;
            }

            $query->whereKey($this->option('id'));
        }

        $inquiries = $query->limit(max(1, min(100, (int) $this->option('limit'))))->get();
        $failed = 0;

        foreach ($inquiries as $inquiry) {
            if ($notifier->send($inquiry)) {
                $this->info(sprintf('Demande DTR-%06d transmise.', $inquiry->id));
            } else {
                $this->error(sprintf('Demande DTR-%06d toujours en attente.', $inquiry->id));
                $failed++;
            }
        }

        $this->info(($inquiries->count() - $failed).' demande(s) transmise(s).');

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }
}
