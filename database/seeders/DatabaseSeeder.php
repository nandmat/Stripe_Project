<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'DevTester',
            'email' => 'dev@tester.com',
            'password' => bcrypt('12345678')
        ]);

        $plan_1 = Plan::create([
            'name' => 'Plano Mensal',
            'url' => 'plano-mensal',
            'stripe_id' => 'price_1NBntyLqVmLnTszOg5oIAynP',
            'price' => 5,
            'description' => 'Plano de Assinatura mensal'
        ]);

        $plan_2 = Plan::create([
            'name' => 'Plano Anual',
            'url' => 'plano-anual',
            'stripe_id' => 'price_1NBntTLqVmLnTszOxeti7n7V',
            'price' => 50,
            'description' => 'Plano de Assinatura Anual'
        ]);

        Feature::create([
            'plan_id' => $plan_1->id,
            'name' => 'Controle de Produtos'
        ]);

        Feature::create([
            'plan_id' => $plan_1->id,
            'name' => 'Controle de Financeiro'
        ]);

        Feature::create([
            'plan_id' => $plan_1->id,
            'name' => 'Controle de Perfil'
        ]);

        Feature::create([
            'plan_id' => $plan_2->id,
            'name' => 'Controle de Produtos'
        ]);

        Feature::create([
            'plan_id' => $plan_2->id,
            'name' => 'Controle de Financeiro'
        ]);

        Feature::create([
            'plan_id' => $plan_2->id,
            'name' => 'Controle de Perfil'
        ]);
    }
}
