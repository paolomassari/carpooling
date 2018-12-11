<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
            <div class="row">
                <h3>PHP prenotazioni</h3>
            </div>
<?php

include 'connessione.php';

function table($pdo)
{
    echo <<<EOT
    <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>IdPrenotazione</th>
                      <th>dataInvio</th>
                      <th>oraInvio</th>
                      <th>partenza</th>
                      <th>arrivo</th>
                      <th>nome </th>
                      <th>&nbsp</th>
                      <th>&nbsp</th>
                    </tr>
                  </thead>
                  <tbody>
EOT;
                   $sql = 'SELECT pr.id_prenotazione id_prenotazione, pa.nome nome, v.citta_partenza partenza, v.citta_destinazione destinazione, pr.data_invio as data_invio, pr.ora_invio as ora_invio, pa.nome as nome,   pr.accettata as accettata FROM `prenotazioni` pr, `passeggeri` pa, `viaggi` v WHERE pr.id_passeggero = pa.identificativo AND pr.id_viaggio = v.id_viaggio';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['id_prenotazione'] . '</td>';
                            echo '<td>'. $row['data_invio'] . '</td>';
                            echo '<td>'. $row['ora_invio'] . '</td>';
                            echo '<td>'. $row['partenza'] . '</td>';
                            echo '<td>'. $row['destinazione'] . '</td>';
                            echo '<td>'. $row['nome'] . '</td>';
                            echo '<td><a class="btn btn-default" href="index.php?action=update&id_prenotazione='.$row['id_prenotazione'].'">Update</a></td>';
                            echo '<td><a class="btn btn-default" href="index.php?action=delete&id_prenotazione='.$row['id_prenotazione'].'">Delete</a></td>';
                            echo '</tr>';
                   }
    echo <<<EOT
                  </tbody>
            </table>
EOT;
}

function delete($pdo, $id_prenotazione)
{
    $sql = "DELETE FROM prenotazioni WHERE id_prenotazione = :id_prenotazione";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_prenotazione' => $id_prenotazione]);
    if ($stmt->rowCount() == 1)
        return true;
    return false;
}

function form($pdo, $id_prenotazione)
{
    $data_invio = date('Y-m-d');
    $ora_invio = date('G:i:s');
    $idpasseggero = '';
    $accettata = '';
    if (isset($id_prenotazione))
    {
        $sql = "SELECT * FROM prenotazioni WHERE id_prenotazione = :id_prenotazione";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_prenotazione' => $id_prenotazione]);
        $row = $stmt->fetch();
        $id_prenotazione = $row['id_prenotazione'];
        $data_invio = $row['data_invio'];
        $ora_invio = $row['ora_invio'];
        $accettata = $row['accettata'];
        if ( $accettata == 1 )
          $accettata = 'accettata';
        else
          $accettata = 'non accettata';
    }
    else
        $id_prenotazione = '';
    $form =<<<EOT
  <form action="index.php" method="POST">
  <div class="form-group">
    <label for="name">Name</label>
    <input type="hidden" name="id_prenotazione" value="$id_prenotazione" class="form-control" id="id_prenotazione" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="accettata">accettata</label>
    <input type="text" name="accettata" value="$accettata" class="form-control" id="accettata" placeholder="accettata">
  </div>
  <div class="form-group">
    <label for="data_invio">data_invio</label>
    <input type="text" name="data_invio" value="$data_invio" class="form-control" id="data_invio" placeholder="data_invio">
  </div>
  <div class="form-group">
    <label for="ora_invio">ora_invio</label>
    <input type="text" name="ora_invio" value="$ora_invio" class="form-control" id="ora_invio" placeholder="ora_invio">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

EOT;
echo $form;
}
//INSERT AND UPDATE
if (isset($_POST['id_prenotazione']))
{
    $values = ['id_prenotazione' => $_POST['id_prenotazione'],
               'accettata' => $_POST['accettata'],
               'data_invio' => $_POST['data_invio']];

    if ($_POST['id_prenotazione']!='')
    {
        $sql = <<<EOT
        UPDATE prenotazioni SET accettata = :acceccata
        WHERE id_prenotazione = :id_prenotazione
EOT;
        $values['id_prenotazione'] = $_POST['id_prenotazione'];
    }
    else {
        $sql = <<<EOT
        INSERT INTO prenotazioni (accettata, data_invio, ora_invio)
        VALUES (0,:data_invio,:ora_invio)
EOT;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
    if ($stmt->rowCount() == 1)
        echo "<p class=\"bg-success\">Success</p>";
    else
        echo "<p class=\"bg-danger\">Error</p>";
}
if ( isset($_GET['action']) && isset($_GET['id_prenotazione'])) {
  $action = $_GET['action'];
  $id_prenotazione = $_GET['id_prenotazione'];
}


//INDEX
if (!isset($action)){
  echo '<a class="btn btn-default" href="index.php?action=add&id_prenotazione=">Inserisci</a>';
    table($pdo);
}

//DELETE
else if ($action == 'delete')
{
    if (delete($pdo, $id_prenotazione))
        echo "<p class=\"bg-success\">Prenotazione cancellata</p>";
    else
        echo "<p class=\"bg-danger\">Error</p>";
    echo "<div><a class=\"btn btn-default\" href=\"index.php?action=add&id_prenotazione=\">Inserisci</a></div>";
    table($pdo);
}

//FORM INSERT

else if ($action == 'add')
    // form($pdo,$id_prenotazione);
    form($pdo,null);
//FORM UPDATE
else if ($action == 'update')
    form($pdo,$id_prenotazione);

?>
        </div>
    </div> <!-- /container -->
  </body>
</html>
