<?php
// src/StudentRepository.php
require_once __DIR__ . '/db.php';
use MongoDB\BSON\ObjectId;

class StudentRepository {
    private $collection;
    public function __construct($db) {
        $this->collection = $db->students;
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

    public function update($id, array $data) {
        $data['updated_at'] = new MongoDB\BSON\UTCDateTime();
        $this->collection->updateOne(['_id' => new ObjectId($id)], ['$set' => $data]);
    }

    public function delete($id) {
        $this->collection->deleteOne(['_id' => new ObjectId($id)]);
    }
}
