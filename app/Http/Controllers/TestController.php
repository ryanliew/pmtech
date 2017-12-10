<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function generate_test_data()
    {
        $numberOfGM = 4;
        $count = 1;

        /*while($count < $numberOfGM)
        {
            $email = 'groupmanager' . $count . '@email.com';
            $gm = factory('App\User')->create(['email' => $email, 
                                                'is_marketing_agent' => true, 
                                                'is_verified' => true, 
                                                'is_default_password' => false, 
                                                'confirmed' => true
                                            ]);

            $teamleaders = factory('App\User', 10)->create(['is_marketing_agent' => true, 
                                                            'is_verified' => true, 
                                                            'is_default_password' => false, 
                                                            'confirmed' => true,
                                                        ]);

            foreach($teamleaders as $teamleader)
            {
                $teamleader->makeChildOf($gm);
            }

            $count++;
        }*/

        /*$gms = \App\User::find(['1','12','23']);

        foreach($gms as $gm)
        {
            foreach($gm->getImmediateDescendants() as $teamleader)
            {
                $mas = factory('App\User', 5)->create(['is_marketing_agent' => true, 
                                                        'is_verified' => true, 
                                                        'is_default_password' => false, 
                                                        'confirmed' => true,
                                                    ]);

                foreach($mas as $ma)
                {
                    $ma->makeChildOf($teamleader);
                }
            }
        }*/
/*
        $email = 'generalmanager4@email.com';
        $gm = factory('App\User')->create(['email' => $email, 
                                            'is_marketing_agent' => true, 
                                            'is_verified' => true, 
                                            'is_default_password' => false, 
                                            'confirmed' => true
                                        ]);

        $numberOfTL = 11;
        $count = 1;
        while($count < $numberOfTL)
        {
            $email = 'teamleader' . $count . '@email.com';


            $teamleader = factory('App\User')->create(['email' => $email,
                                                        'is_marketing_agent' => true, 
                                                        'is_verified' => true, 
                                                        'is_default_password' => false, 
                                                        'confirmed' => true,
                                                        'referrer_id' => $gm->id
                                                    ]);

            $teamleader->makeChildOf($gm);

            $mas = factory('App\User', 5)->create(['is_marketing_agent' => true, 
	                                                'is_verified' => true, 
	                                                'is_default_password' => false, 
	                                                'confirmed' => true,
	                                                'referrer_id' => $teamleader->id
	                                            ]);

            foreach($mas as $ma)
            {
                $ma->makeChildOf($teamleader);
            }

            $count++;
        }
*/
        factory('App\User')->create(['email' => 'admin@email.com',
    								'is_admin' => true,
                                    'confirmed' => true
    								]);

        return 'Test data generated.';
    }
}
