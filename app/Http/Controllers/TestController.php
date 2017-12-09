<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function generate_test_data()
    {
        $numberOfGM = 4;
        $count = 1;

        while($count < $numberOfGM)
        {
            $email = 'generalmanager' . $count . '@email.com';
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
                                                            'referrer_id' => $gm->id
                                                        ]);
            foreach($teamleaders as $teamleader)
            {
                $ma = factory('App\User', 5)->create(['is_marketing_agent' => true, 
                                                        'is_verified' => true, 
                                                        'is_default_password' => false, 
                                                        'confirmed' => true,
                                                        'referrer_id' => $teamleader->id
                                                    ]);
            }

            $count++;
        } 

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

            $ma = factory('App\User', 5)->create(['is_marketing_agent' => true, 
	                                                'is_verified' => true, 
	                                                'is_default_password' => false, 
	                                                'confirmed' => true,
	                                                'referrer_id' => $teamleader->id
	                                            ]);
            $count++;
        }

        factory('App\User')->create(['email' => 'admin@email.com',
    								'is_admin' => true,
                                    'confirmed' => true
    								]);

        return 'Test data generated.';
    }
}
