<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/CourseRepository.php';

$repo = new CourseRepository($db);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $code = trim($_POST['code'] ?? '');
    if ($title === '') $errors[] = "Título é obrigatório";
    if ($code === '') $errors[] = "Código é obrigatório";

    if (empty($errors)) {
        $doc = [
            'code' => $code,
            'title' => $title,
            'description' => $_POST['description'] ?? '',
            'credits' => (int)($_POST['credits'] ?? 0),
            'period' => $_POST['period'] ?? '',
            'category' => $_POST['category'] ?? ''
        ];
        $id = $repo->create($doc);
        header("Location: course_list.php?created=" . (string)$id);
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Criar Curso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2>Criar Curso</h2>
    <?php if(!empty($errors)): ?>
      <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3"><label class="form-label">Código</label><input class="form-control" name="code" required></div>
      <div class="mb-3"><label class="form-label">Título</label><input class="form-control" name="title" required></div>
      <div class="mb-3"><label class="form-label">Descrição</label><textarea class="form-control" name="description"></textarea></div>
      <div class="row">
        <div class="col"><label class="form-label">Créditos</label><input type="number" class="form-control" name="credits"></div>
        <div class="col"><label class="form-label">Período</label><input class="form-control" name="period"></div>
        <div class="col"><label class="form-label">Categoria</label><input class="form-control" name="category"></div>
      </div>
      <button class="btn btn-primary mt-3" type="submit">Salvar</button>
    </form>
  </div>
</body>
</html>
