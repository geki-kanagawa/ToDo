<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class ToDoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create([
            'id' => '1',
            'title' => '買い物',
            'datetime' => '2022-05-14 00:00:00',
            'memo' => 'ドンキ',
            'category' => 'private',
            'ins_time' => '2022-05-01 00:00:00',
            'upd_time' => '2022-05-01 00:00:00',
            'flag' => '1',
        ]);

        Task::create([
            'id' => '2',
            'title' => '仕事',
            'datetime' => '2022-05-13 00:00:00',
            'memo' => '新宿',
            'category' => 'work',
            'ins_time' => '2022-05-01 00:00:00',
            'upd_time' => '2022-05-01 00:00:00',
            'flag' => '1',
        ]);

        Task::create([
            'id' => '3',
            'title' => 'トレーニング',
            'datetime' => '2022-05-15 00:00:00',
            'memo' => 'ジム',
            'category' => 'private',
            'ins_time' => '2022-05-01 00:00:00',
            'upd_time' => '2022-05-01 00:00:00',
            'flag' => '1',
        ]);
    }
}
