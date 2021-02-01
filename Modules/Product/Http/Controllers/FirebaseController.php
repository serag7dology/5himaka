<?php
namespace Modules\Product\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
// use Kreait\Firebase;
// use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;
// use Kreait\Firebase\Database;
use Modules\Product\Entities\Firestore;
class FirebaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $firestore_data  = [
            "content" => ["stringValue" => "Hello"],
            "idFrom" => ["stringValue" => "12"],
            "idTo" => ["stringValue" => "28"],
            "isread" => ["booleanValue" => false],
            "timestamp" => ["integerValue" =>strtotime(date('H:m:s'))],
            "type" => ["stringValue" =>"text"]
        ];
        $data = ["fields" => (object)$firestore_data];
        $json = json_encode($data);
        $firestore_key = "AIzaSyBrbASTDTE_bEJDhunGZ8yCl1GoTVwXeC0";
        $project_id = "chat-c2b95";  
        $object_unique_id = random_int(1,3000000);
        $url = "https://firestore.googleapis.com/v1beta1/projects/chat-c2b95/databases/(default)/documents/chatroom/12-28/12-28/".$object_unique_id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json',
                'Content-Length: ' . strlen($json),
                'X-HTTP-Method-Override: PATCH'),
            CURLOPT_URL => $url . '?key='.$firestore_key,
            CURLOPT_USERAGENT => 'cURL',
            CURLOPT_POSTFIELDS => $json
        ));
        $response = curl_exec( $curl );
        curl_close( $curl );
        // echo $response . "\n";
        ///////////////
        // $fs = new Firestore('chatroom');
        // print_r($fs);
        // return;
        // print_r($fs->getDocument('25-18'));
        ////////////////////////////////
        // $factory = (new Factory)->withServiceAccount(__DIR__.'/chat.json');
        // $database = $factory->createDatabase();
        // // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/chat.json');
		// // $firebase 		  = (new Factory)
        // //                 ->withServiceAccount($serviceAccount)
        // //                 ->withDatabaseUri('https://chat-a378a.firebaseio.com')
        // //                 ->create();
		// // $database 		= $firebase->getDatabase();
		// $newPost 		  = $database
		//                     ->getReference('blog/posts')
		//                     ->push(['title' => 'Post title','body' => 'This should probably be longer.']);
		// echo"<pre>";
		// print_r($newPost->getvalue());
    }
}
