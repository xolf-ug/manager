<?php include 'bootstrap.php' ?>
<?php include 'head.php' ?>
<?php
$submitted = true;
foreach ($inputs as $i)
{
    if(!isset($_POST[$i[0]])) $submitted = false;
}

if($submitted)
{
    $id = date('Y');

    $document = $io->table('customer')->document($id);

    $i = 1;
    while(isset($document->id))
    {
        $new_id = $i . $id;
        $document = $io->table('customer')->document($new_id);
        $i++;
    }

    if(!isset($new_id)) $new_id = $id;

    $data = ['id' => $new_id];

    $data = array_merge($data, $_POST);

    $document->write($data);

    echo '
<div class="alert alert-success">
  <strong>Erfolgreich!</strong> Der Kunde ' . $_POST['name'] . ' wurde erfolgreich erstellt. (Kundennummer: ' . $new_id .')
</div>';
}

?>

<h1>Kunden erstellen</h1>
<form method="post">
    <div class="row">
        <div class="col-md-6">
            <h4>Allgemeines</h4>
            <?php foreach ($inputs as $input) : ?>
                <div class="form-group">
                    <label for="<?php echo $input[0] ?>"><?php echo $input[1] ?>:</label>
                    <input type="text" class="form-control" name="<?php echo $input[0] ?>" id="<?php echo $input[0] ?>">
                </div>
            <?php endforeach ?>
        </div>
        <div class="col-md-6">
            <h4>Kontakt</h4>
            <?php foreach ($company as $input) : ?>
                <div class="form-group">
                    <label for="<?php echo $input[0] ?>"><?php echo $input[1] ?>:</label>
                    <input type="text" class="form-control" name="<?php echo $input[0] ?>" id="<?php echo $input[0] ?>">
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <input type="submit" value="Erstellen" class="btn btn-primary">
</form>
<?php include 'foot.php' ?>
