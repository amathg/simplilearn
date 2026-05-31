<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder {
    public function run(): void {
        $plans = [
            [
                'nom'          => 'Starter',
                'slug'         => 'starter',
                'prix_mensuel' => 9900,
                'prix_annuel'  => 99000,
                'nb_produits'  => 100,
                'nb_employes'  => 3,
                'nb_magasins'  => 1,
                'ecommerce'    => false,
                'comptabilite' => false,
                'rh'           => false,
                'multi_depot'  => false,
                'api_access'   => false,
                'description'  => 'Pour démarrer',
            ],
            [
                'nom'          => 'Pro',
                'slug'         => 'pro',
                'prix_mensuel' => 24900,
                'prix_annuel'  => 249000,
                'nb_produits'  => 1000,
                'nb_employes'  => 10,
                'nb_magasins'  => 1,
                'ecommerce'    => true,
                'comptabilite' => true,
                'rh'           => false,
                'multi_depot'  => false,
                'api_access'   => false,
                'description'  => 'Pour croître',
            ],
            [
                'nom'          => 'Business',
                'slug'         => 'business',
                'prix_mensuel' => 49900,
                'prix_annuel'  => 499000,
                'nb_produits'  => 5000,
                'nb_employes'  => 30,
                'nb_magasins'  => 3,
                'ecommerce'    => true,
                'comptabilite' => true,
                'rh'           => true,
                'multi_depot'  => true,
                'api_access'   => false,
                'description'  => 'Pour les PME',
            ],
            [
                'nom'          => 'Enterprise',
                'slug'         => 'enterprise',
                'prix_mensuel' => 99900,
                'prix_annuel'  => 999000,
                'nb_produits'  => -1,
                'nb_employes'  => -1,
                'nb_magasins'  => -1,
                'ecommerce'    => true,
                'comptabilite' => true,
                'rh'           => true,
                'multi_depot'  => true,
                'api_access'   => true,
                'description'  => 'Pour les grandes enseignes',
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}