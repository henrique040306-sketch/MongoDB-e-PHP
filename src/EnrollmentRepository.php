<?php
// src/EnrollmentRepository.php
require_once __DIR__ . '/db.php';
use MongoDB\BSON\ObjectId;

class EnrollmentRepository {
    private $collection;
    public function __construct($db) {
        $this->collection = $db->enrollments;
    }

    public function enroll($studentId, $courseId, $status = 'active') {
        // prevent duplicate
        $exists = $this->collection->findOne([
            'student_id' => new ObjectId($studentId),
            'course_id' => new ObjectId($courseId)
        ]);
        if ($exists) {
            return null;
        }
        $doc = [
            'student_id' => new ObjectId($studentId),
            'course_id' => new ObjectId($courseId),
            'enrolled_at' => new MongoDB\BSON\UTCDateTime(),
            'status' => $status
        ];
        $result = $this->collection->insertOne($doc);
        return $result->getInsertedId();
    }

    public function findCoursesByStudent($studentId) {
        $pipeline = [
            ['$match' => ['student_id' => new ObjectId($studentId)]],
            ['$lookup' => [
                'from' => 'courses',
                'localField' => 'course_id',
                'foreignField' => '_id',
                'as' => 'course'
            ]],
            ['$unwind' => '$course'],
            ['$project' => ['course' => 1, 'status' => 1, 'enrolled_at' => 1]]
        ];
        return $this->collection->aggregate($pipeline)->toArray();
    }

    public function findStudentsByCourse($courseId) {
        $pipeline = [
            ['$match' => ['course_id' => new ObjectId($courseId)]],
            ['$lookup' => [
                'from' => 'students',
                'localField' => 'student_id',
                'foreignField' => '_id',
                'as' => 'student'
            ]],
            ['$unwind' => '$student'],
            ['$project' => ['student' => 1, 'status' => 1, 'enrolled_at' => 1]]
        ];
        return $this->collection->aggregate($pipeline)->toArray();
    }
}
