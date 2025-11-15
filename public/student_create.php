<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/StudentRepository.php';

$repo = new StudentRepository($db);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    if ($name === '') $errors[] = "Nome é obrigatório";
    if ($cpf === '') $errors[] = "CPF é obrigatório";

    if (empty($errors)) {
        $doc = [
            'name' => $name,
            'rg' => $_POST['rg'] ?? '',
            'cpf' => $cpf,
            'birth_date' => isset($_POST['birth_date']) && $_POST['birth_date'] !== '' ? new MongoDB\BSON\UTCDateTime(strtotime($_POST['birth_date'])*1000) : null,
            'phones' => array_filter([$_POST['phone1'] ?? '', $_POST['phone2'] ?? '']),
            'mother_name' => $_POST['mother_name'] ?? '',
            'father_name' => $_POST['father_name'] ?? '',
            'address' => [
                'street' => $_POST['street'] ?? '',
                'number' => $_POST['number'] ?? '',
                'complement' => $_POST['complement'] ?? '',
                'neighborhood' => $_POST['neighborhood'] ?? '',
                'city' => $_POST['city'] ?? '',
                'state' => $_POST['state'] ?? '',
                'zip' => $_POST['zip'] ?? ''
            ],
        ];
        $id = $repo->create($doc);
        header("Location: student_list.php?created=" . (string)$id);
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Criar Estudante</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2>Criar Estudante</h2>
    <?php if(!empty($errors)): ?>
      <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3"><label class="form-label">Nome</label><input class="form-control" name="name" required></div>
      <div class="row">
        <div class="col"><label class="form-label">RG</label><input class="form-control" name="rg"></div>
        <div class="col"><label class="form-label">CPF</label><input class="form-control" name="cpf" required></div>
      </div>
      <div class="mb-3"><label class="form-label">Data de Nascimento</label><input type="date" class="form-control" name="birth_date"></div>
      <div class="row">
        <div class="col"><label class="form-label">Telefone 1</label><input class="form-control" name="phone1"></div>
        <div class="col"><label class="form-label">Telefone 2</label><input class="form-control" name="phone2"></div>
      </div>
      <div class="row mt-2">
        <div class="col"><label class="form-label">Nome da mãe</label><input class="form-control" name="mother_name"></div>
        <div class="col"><label class="form-label">Nome do pai</label><input class="form-control" name="father_name"></div>
      </div>

      <h5 class="mt-3">Endereço</h5>
      <div class="row">
        <div class="col"><label class="form-label">Rua</label><input class="form-control" name="street"></div>
        <div class="col"><label class="form-label">Número</label><input class="form-control" name="number"></div>
      </div>
      <div class="row">
        <div class="col"><label class="form-label">Complemento</label><input class="form-control" name="complement"></div>
        <div class="col"><label class="form-label">Bairro</label><input class="form-control" name="neighborhood"></div>
      </div>
      <div class="row">
        <div class="col"><label class="form-label">Cidade</label><input class="form-control" name="city"></div>
        <div class="col"><label class="form-label">Estado</label><input class="form-control" name="state"></div>
        <div class="col"><label class="form-label">CEP</label><input class="form-control" name="zip"></div>
      </div>
      <button class="btn btn-primary mt-3" type="submit">Salvar</button>
    </form>
  </div>
</body>
</html>
