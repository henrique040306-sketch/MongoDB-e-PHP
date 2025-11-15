<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/CourseRepository.php';
require_once __DIR__ . '/../src/EnrollmentRepository.php';

$courseRepo = new CourseRepository($db);
$enrollRepo = new EnrollmentRepository($db);

$courses = $courseRepo->findAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Cursos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2>Cursos</h2>
    <table class="table">
      <thead><tr><th>Título</th><th>Código</th><th>Alunos</th></tr></thead>
      <tbody>
      <?php foreach($courses as $c):
          $students = $enrollRepo->findStudentsByCourse((string)$c['_id']);
      ?>
      <tr>
        <td><?= htmlspecialchars($c['title']) ?></td>
        <td><?= htmlspecialchars($c['code'] ?? '') ?></td>
        <td>
          <?php foreach($students as $s): ?>
            <div><?= htmlspecialchars($s['student']['name']) ?> (<?= htmlspecialchars($s['status']) ?>)</div>
          <?php endforeach; ?>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
