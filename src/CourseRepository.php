<?php
// src/CourseRepository.php
require_once __DIR__ . '/db.php';
use MongoDB\BSON\ObjectId;

class CourseRepository {
    private $collection;
    public function __construct($db) {
        $this->collection = $db->courses;
    }

    public function create(array $data) {
        $data['created_at'] = new MongoDB\BSON\UTCDateTime();
        $data['updated_at'] = new MongoDB\BSON\UTCDateTime();
        $result = $this->collection->insertOne($data);
        return $result->getInsertedId();
    }

    public function findAll() {
        return $this->collection->find()->toArray();
    }

    public function findById($id) {
        return $this->collection->findOne(['_id' => new ObjectId($id)]);
    }
}
