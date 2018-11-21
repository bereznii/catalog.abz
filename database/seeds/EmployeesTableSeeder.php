<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the seeding of employees list.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Александр', 'Алексей', 'Андрей', 'Артем', 'Виктор', 'Даниил', 'Дмитрий', 'Егор', 'Илья', 'Кирилл',
                    'Максим', 'Марк', 'Михаил', 'Роман', 'Степан', 'Тимофей', 'Ярослав'];
        $last_names = ['Иванов','Смирнов','Кузнецов','Попов','Васильев','Петров','Соколов','Михайлов','Новиков','Федоров',
                        'Морозов','Волков','Алексеев','Лебедев','Семенов','Егоров','Павлов','Козлов','Степанов','Николаев',
                        'Орлов','Андреев','Макаров','Никитин','Захаров','Зайцев','Соловьев','Борисов','Яковлев','Григорьев'];
        $second_names = ['Александрович','Анатольевич','Алексеевич','Андреевич','Антонович','Богданович','Вадимович','Викторович','Григорьевич','Ефимович',
                        'Игоревич','Кириллович','Макарович','Николаевич','Олегович','Павлович','Петрович','Романович','Русланович','Сергеевич'];
        
        $position_levels = ['President', 'First level', 'Second level', 'Third level', 'Fourth level'];
        
        $salaries = [500000, 200000, 100000, 80000, 30000];

        for($i = 0; $i < 50000; $i++) {
            //i == id
            if($i == 0) {
                $position = $position_levels[0];
                $salary = $salaries[0];
                $parent = 0;
                $depth = 0;
            } elseif($i <= 5) {
                $position = $position_levels[1];
                $salary = $salaries[1];
                $parent = 1;
                $depth = 1;
            } elseif($i <= 55) {
                $position = $position_levels[2];
                $salary = $salaries[2];
                $parent = rand(2, 6);
                $depth = 2;
            } elseif($i <= 1305) {
                $position = $position_levels[3];
                $salary = $salaries[3];
                $parent = rand(7, 57);
                $depth = 3;
            } else {
                $position = $position_levels[4];
                $salary = $salaries[4];
                $parent = rand(58, 1308);
                $depth = 4;
            }
            Employee::insert([
                'name' => $last_names[array_rand($last_names)] . ' ' . $names[array_rand($names)] . ' ' . $second_names[array_rand($second_names)],
                'position' => $position,
                'salary' => $salary,
                'employment' => date("Y-m-d"),
                'parent' => $parent,
                'depth' => $depth,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
        
    }
}
