<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/StudentRepository.php';
require_once __DIR__ . '/../src/EnrollmentRepository.php';

$studentRepo = new StudentRepository($db);
$enrollRepo = new EnrollmentRepository($db);

$students = $studentRepo->findAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Estudantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2>Estudantes</h2>
    <table class="table">
      <thead><tr><th>Nome</th><th>CPF</th><th>Telefones</th><th>Cursos</th></tr></thead>
      <tbody>
      <?php foreach($students as $s):
          $courses = $enrollRepo->findCoursesByStudent((string)$s['_id']);
      ?>
      <tr>
        <td><?= htmlspecialchars($s['name']) ?></td>
        <td><?= htmlspecialchars($s['cpf'] ?? '') ?></td>
        <td><?= htmlspecialchars(implode(', ', $s['phones'] ?? [])) ?></td>
        <td>
          <?php foreach($courses as $c): ?>
            <div><?= htmlspecialchars($c['course']['title']) ?> (<?= htmlspecialchars($c['status']) ?>)</div>
          <?php endforeach; ?>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
