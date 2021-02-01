<?php

namespace Modules\Product\Entities;


class Firestore
{
    protected $db;
    protected $name;
    public function  __construct(string $collection){
        $this->db = new FirestoreClient([
            'projectId'=>'chat-c2b95'
        ]);
        $this->name=$collection;
    }

    public function getDocument(string $name){
        $this->db->collection($this->name)->document($name)->snapshot()->data();
    }

}
