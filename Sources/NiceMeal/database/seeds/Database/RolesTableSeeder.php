<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => 'a1,a2,u1,u2,d1,d2,c1,c2,res1,res2,up1,up2,tbr1,tbr2,cus1,cus2,reca1,reca2,rds1,rds2,tbpr1,tbpr2,g1,g2,t1,t2,rr1,rr2'
            ],
            [
                'name' => 'Restaurant',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => 'a1,a2,u1,u2,d1,d2,c1,c2,res1,res2,up1,up2,tbr1,tbr2,cus1,cus2,reca1,reca2,rds1,rds2,tbpr1,tbpr2,g1,g2,t1,t2'
            ],
            [
                'name' => 'Chef',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => 'a1,a2'
            ]
        ];

        if(DB::table('roles')->count() == 0){
            DB::table('roles')->insert($roles);
        }

    }
}
