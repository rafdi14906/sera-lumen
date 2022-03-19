<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $serviceAccount = ServiceAccount::fromValue(__DIR__ . '/FirebaseKey.json');
            dd($serviceAccount, env('FIREBASE_DATABASE_URL'));
            $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE_URL'));
            // ->create();
            $database = $firebase->createDatabase();
            $ref = $database->getReference('employee');
            // $key = $ref->push()->getKey();
            // $ref->getChild($key)->set([
            //     'name' => 'Abi',
            //     'address' => 'Depok',
            // ]);
            // return $key;
            $ref->set([
                'name' => 'Abi',
                'address' => 'Depok',
            ]);

            return response()->json('blog has been created');
        } catch (\Throwable $th) {
            throw $th;
            \Sentry\captureException($th);
        }
    }
}
