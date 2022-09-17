<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organizations')->truncate();

        Schema::enableForeignKeyConstraints();

        $students = json_decode(file_get_contents(public_path() . "/shortMIREA.json"), true);
//        dump($students[0]['levels'][0]['directions']);
        foreach ($students as $key => $student) {
            dump($key);
//            foreach ($student as $key1 => $item) {
//                if (is_string($item)) {
//                    dump($item);
//                }
//            }
        }
        dd('ok');
    }
}
