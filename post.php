<?php
include('connection.php');

$articleId = isset($_GET['id']) ? $_GET['id'] : null;

// verificam existenta unui ID valid in URL
if (!empty($articleId)) {
    $sql = "SELECT * FROM articole WHERE id = $articleId";
    $result = $GLOBALS['conn']->query($sql);

    // verificam rezultatul interogarii si existenta articolului
    if ($result && $result->num_rows > 0) {
        $article = $result->fetch_assoc();
        $userRole = isset($_GET['role']) ? $_GET['role'] : '';

        // verificam daca utilizatorul curent are permisiuni pentru acest articol
        if (($userRole === 'jurnalist' && $article['autor'] === $user['nume']) || $userRole === 'editor') {
            // utilizatorul are permisiuni, afisam detaliile articolului si butoanele relevante
            echo '<h1>' . $article['titlu'] . '</h1>';
            echo '<p><strong>Autor:</strong> ' . $article['autor'] . '</p>';
            echo '<p><strong>Categorie:</strong> ' . $article['categorie'] . '</p>';
            echo '<p><strong>Data:</strong> ' . $article['created_at'] . '</p>';
            echo '<p>' . $article['continut'] . '</p>';

            // buton editare si stergere pentru jurnalisti
            if ($userRole === 'jurnalist') {
                echo '<button onclick="editArticle(' . $article['id'] . ')">Editare</button>';
                echo '<button onclick="deleteArticle(' . $article['id'] . ')">Stergere</button>';
            }

            // buton editare, stergere si validare pentru editori
            elseif ($userRole === 'editor') {
                echo '<button onclick="editArticle(' . $article['id'] . ')">Editare</button>';
                echo '<button onclick="deleteArticle(' . $article['id'] . ')">Stergere</button>';
                echo '<button onclick="validateArticle(' . $article['id'] . ')">Validare</button>';
            }
        } else {
            echo '<p>Acces interzis la acest articol.</p>';
        }
    } else {
        echo '<p>Articolul nu exista.</p>';
    }
} else {
    echo '<p>ID articol invalid.</p>';
}
?>

<script>
    function editArticle(articleId) {
        alert('Editare articol cu ID ' + articleId);
        // implementeaza redirecționarea către pagina de editare a articolului
    }

    function deleteArticle(articleId) {
        alert('Stergere articol cu ID ' + articleId);
        // implementeaza stergerea articolului din baza de date
    }

    function validateArticle(articleId) {
        alert('Validare articol cu ID ' + articleId);
        // implementeaza validarea articolului in baza de date
    }
</script>
