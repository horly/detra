<?php

namespace App\Console\Commands;

use App\Models\Inquiry;
use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;

class ListInquiries extends Command
{
    protected $signature = 'detra:inquiries {--id= : Afficher une demande en détail} {--limit=20 : Nombre de demandes récentes}';

    protected $description = 'Consulter les demandes du site depuis un accès serveur autorisé';

    public function handle(): int
    {
        if ($this->option('id') !== null) {
            $inquiry = Inquiry::find($this->option('id'));

            if (! $inquiry) {
                $this->error('Demande introuvable.');

                return self::FAILURE;
            }

            foreach ($inquiry->only(['id', 'created_at', 'name', 'company', 'email', 'phone', 'service', 'locale', 'message']) as $field => $value) {
                $this->line($field.': '.OutputFormatter::escape((string) $value));
            }

            return self::SUCCESS;
        }

        $limit = max(1, min(100, (int) $this->option('limit')));
        $inquiries = Inquiry::query()->latest('id')->limit($limit)
            ->get(['id', 'created_at', 'name', 'email', 'service', 'locale']);

        $this->table(['ID', 'Date', 'Nom', 'E-mail', 'Service', 'Langue'], $inquiries->map(
            fn (Inquiry $inquiry) => array_map(
                fn ($value) => OutputFormatter::escape((string) $value),
                $inquiry->only(['id', 'created_at', 'name', 'email', 'service', 'locale']),
            ),
        )->all());

        return self::SUCCESS;
    }
}
