<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/StudentRepository.php';
require_once __DIR__ . '/../src/CourseRepository.php';
require_once __DIR__ . '/../src/EnrollmentRepository.php';

$studentRepo = new StudentRepository($db);
$courseRepo = new CourseRepository($db);
$enrollRepo = new EnrollmentRepository($db);

$students = $studentRepo->findAll();
$courses = $courseRepo->findAll();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? null;
    $course_id = $_POST['course_id'] ?? null;
    if ($student_id && $course_id) {
        $res = $enrollRepo->enroll($student_id, $course_id);
        if ($res) $msg = "Matrícula realizada com sucesso!";
        else $msg = "Matrícula já existe.";
    } else {
        $msg = "Selecione estudante e curso.";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Matricular Estudante</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2>Matricular Estudante</h2>
    <?php if($msg): ?><div class="alert alert-info"><?=$msg?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Estudante</label>
        <select class="form-select" name="student_id" required>
          <option value="">-- selecione --</option>
          <?php foreach($students as $s): ?>
            <option value="<?= (string)$s['_id'] ?>"><?= htmlspecialchars($s['name']) ?> (<?= htmlspecialchars($s['cpf'] ?? '') ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Curso</label>
        <select class="form-select" name="course_id" required>
          <option value="">-- selecione --</option>
          <?php foreach($courses as $c): ?>
            <option value="<?= (string)$c['_id'] ?>"><?= htmlspecialchars($c['title']) ?> (<?= htmlspecialchars($c['code'] ?? '') ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <button class="btn btn-primary" type="submit">Matricular</button>
    </form>
  </div>
</body>
</html>
