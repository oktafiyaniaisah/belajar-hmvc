<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModuleGenerator extends BaseCommand
{
    protected $group       = 'Development';
    protected $name        = 'make:module';
    protected $description = 'Hanya membuat folder struktur HMVC (Config, Controllers, Models, Views).';
    protected $usage       = 'make:module [name]';
    protected $arguments   = ['name' => 'Nama modul yang ingin dibuat'];

    public function run(array $params)
    {
        // Ambil nama modul dan jadikan huruf kapital di depan
        $name = ucfirst($params[0] ?? '');

        if (empty($name)) {
            CLI::error("Nama modul harus diisi!");
            return;
        }

        $basePath = ROOTPATH . 'Modules/' . $name;

        // Daftar folder yang akan dibuat sesuai keinginanmu
        $folders = [
            $basePath . '/Config',
            $basePath . '/Controllers',
            $basePath . '/Models',
            $basePath . '/Views',
        ];

        foreach ($folders as $folder) {
            if (!is_dir($folder)) {
                // Membuat folder secara rekursif
                if (mkdir($folder, 0777, true)) {
                    CLI::write("Folder dibuat: " . $folder, 'green');
                }
            } else {
                CLI::write("Folder sudah ada: " . $folder, 'yellow');
            }
        }

        CLI::write("\nStruktur modul $name berhasil disiapkan. Silakan buat file secara manual!", 'cyan');
    }
}