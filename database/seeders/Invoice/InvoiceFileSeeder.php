<?php

namespace Database\Seeders\Invoice;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

use App\Models\Invoice\Invoice;

class InvoiceFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        File::cleanDirectory(public_path('invoices'));
     
        foreach (Invoice::all() as $invoice) {
            try {
                $invoice->generate();
            } catch (\Exception $e) {
                report($e);
                continue;
            }
        }
    }
}
