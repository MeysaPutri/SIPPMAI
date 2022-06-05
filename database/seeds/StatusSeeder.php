<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $approve = new \App\Status();
        $approve->status = "Approve";
        $approve->save();

        $disapprove = new \App\Status();
        $disapprove->status = "Disapprove";
        $disapprove->save();

        $inreview = new \App\Status();
        $inreview->status = "In Review";
        $inreview->save();
    }
}
