<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Smalot\PdfParser\Parser;
use App\Models\PdfContent;
use Illuminate\Support\Facades\Storage;
use File;

class IndexPdfBible extends Command
{
    protected $signature = 'bible:index-pdf';
    protected $description = 'Indexa o conteúdo dos arquivos PDF da Bíblia';

    public function handle()
    {
        $directory = storage_path('app/public/biblia');
        
        if (!File::exists($directory)) {
            $this->error("Diretório não encontrado: {$directory}");
            return;
        }

        $files = File::files($directory);
        $parser = new Parser();

        foreach ($files as $file) {
            if ($file->getExtension() !== 'pdf') continue;

            $this->info("Processando: " . $file->getFilename());

            try {
                $pdf = $parser->parseFile($file->getRealPath());
                $pages = $pdf->getPages();

                foreach ($pages as $index => $page) {
                    $text = $page->getText();
                    
                    if (trim($text)) {
                        PdfContent::create([
                            'file_name' => $file->getFilename(),
                            'page_number' => $index + 1,
                            'content' => $text
                        ]);
                    }
                }
                $this->info("Finalizado: " . $file->getFilename());
            } catch (\Exception $e) {
                $this->error("Erro ao processar {$file->getFilename()}: " . $e->getMessage());
            }
        }

        $this->info("Indexação concluída!");
    }
}
