<?php

namespace Database\Seeders\Invoice;

use Illuminate\Database\Seeder;

use Database\Factories\Invoice\InvoiceFactory;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            InvoiceFactory::new()->count(10)->create();
        } catch (\Exception $e) {
            report($e);
            $this->command->error($e->getMessage());
            return;
        }
    }
}
