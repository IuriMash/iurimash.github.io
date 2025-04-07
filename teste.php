<?php
session_start();

// Inicializa as variáveis de sessão se ainda não existirem. 
if (!isset($_SESSION['parcelas']) && !isset($_SESSION['next_id'])) {
    $_SESSION['parcelas'] = [];
    $_SESSION['next_id'] = 10;
}

// Função para criar uma nova parcela em um Array Associativo.
function createParcel($description) {
    $id = $_SESSION['next_id'];
    $_SESSION['next_id']++;
    return [
        'id' => $id,
        'description' => $description
    ];
}

// Se o formulário for enviado...
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['description'])) {
    $description = trim($_POST['description']);

    // Verifica se a descrição está vazia...
    if ($description === '') {
        header("Location: teste.php?erro=vazio");
        exit;
    }

    // Se não, adiciona uma nova parcela à sessão
    $_SESSION['parcelas'][] = createParcel($description);
    
    // Redireciona para evitar reenvio de formulário
    header("Location: teste.php");
    exit;
}

// Função para reduzir e formatar a descrição a ser exibida.
function formatDescription($text) {
    if (preg_match('/(\d+\.){4,}\d+/', $text, $match)) {
        $reduced = implode('.', array_slice(explode('.', $match[0]), 0, 4)) . '...';
        $display = str_replace($match[0], $reduced, $text);
        return ['display' => $display, 'full' => $text, 'reduced' => true];
    }
    return ['display' => $text, 'full' => '', 'reduced' => false];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Parcelas</title>
  <style>
    body {
        font-family: 'Segoe UI', sans-serif;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
    }
    .item {
        margin: 5px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    input, button {
        padding: 10px;
        margin: 5px 0;
        width: 100%;
        box-sizing: border-box;
    }
    button {
        background-color: #2196F3;
        color: white;
        cursor: pointer;
    }
    .description {
        position: relative;
        max-width: 90%;
        word-wrap: break-word;
    }
    .description.reduced {
        cursor: help;
    }
    .description.reduced::after {
        content: attr(data-full);
        position: absolute;
        top: 120%;
        left: 0;
        z-index: 999;
        background: #333;
        color: #fff;
        font-size: 0.85em;
        padding: 8px 12px;
        border-radius: 4px;
        opacity: 0;
        transition: opacity 0.2s;
        max-width: 60vw;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        pointer-events: none;
        word-wrap: break-word;
    }
    .description.reduced:hover::after {
        opacity: 1;
    }
  </style>
</head>
<body>

<div class="container">
    <!-- Exibe mensagem de erro se o campo estiver vazio -->
    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'vazio'): ?>
        <div style="color: red; font-weight: bold;">A descrição não pode possuir apenas espaços.</div>
    <?php endif; ?>

    <!-- Formulário para adicionar nova parcela -->
    <form method="POST">
        <input type="text" name="description" placeholder="Descrição da parcela" required />
        <button type="submit">Adicionar Parcela</button>
    </form>
</div>

<div class="container">
    <!-- Lista as parcelas existentes -->
            <div class="item">
            <strong>1</strong>: 
                <span class="description">11/181.1</span>
            </div>
            <div class="item">
            <strong>2</strong>: 
                <span class="description">11/181.2</span>
            </div>
            <div class="item">
            <strong>3</strong>: 
                <span class="description">11/181.2.1</span>
            </div>
            <div class="item">
            <strong>4</strong>: 
                <span class="description">11/181.2.1.1</span>
            </div>
            <div class="item">
            <strong>5</strong>: 
                <span class="description reduced" data-full="11/181.2.1.1.1">11/181.2.1.1...</span>
            </div>
            <div class="item">
            <strong>6</strong>: 
                <span class="description reduced" data-full="11/181.2.1.1.1.1">11/181.2.1.1...</span>
            </div>
            <div class="item">
            <strong>7</strong>: 
                <span class="description reduced" data-full="11/181.2.1.1.1.1.1">11/181.2.1.1...</span>
            </div>
            <div class="item">
            <strong>8</strong>: 
                <span class="description reduced" data-full="11/181.2.1.1.1.1.1.1">11/181.2.1.1...</span>
            </div>
            <div class="item">
            <strong>9</strong>: 
                <span class="description reduced" data-full="11/181.2.1.1.1.1.1.1.1">11/181.2.1.1...</span>
            </div>
    <!-- Lista as parcelas existentes -->
    <?php foreach ($_SESSION['parcelas'] as $parcel): 
        $desc = formatDescription($parcel['description']);
    ?>
        <div class="item">
            <strong><?= $parcel['id'] ?></strong>: 
            <?php if ($desc['reduced']): ?>
                <span class="description reduced" data-full="<?= $desc['full'] ?>"><?= $desc['display'] ?></span>
            <?php else: ?>
                <span class="description"><?= $desc['display'] ?></span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
