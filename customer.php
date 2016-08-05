<?php
if(!isset($_GET['i'])) header('Location: index.php');
?>
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
    $id = $_GET['i'];

    $document = $io->table('customer')->document($_GET['i']);

    $document->write($_POST);

    echo '
<div class="alert alert-success">
  <strong>Erfolgreich!</strong> Der Kunde ' . $_POST['name'] . ' wurde erfolgreich bearbeitet.
</div>';
}

$customer = $io->table('customer')->document($_GET['i']);

?>

<h1>Kunde</h1>
<a href="" class="btn btn-default" data-toggle="modal" data-target="#writeLetter">Brief schreiben</a>
<div class="modal fade" id="writeLetter" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Brief verfassen</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="write-letter.php">
                    <input type="hidden" name="customer_id" value="<?php echo $customer->id ?>">
                    <input type="hidden" name="date" value="<?php echo date('d.m.Y') ?>">
                    <div class="form-group">
                        <input type="checkbox" name="salut" value="yes" id="salut"> <label for="salut">Anrede</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="show_id" value="yes" id="show_id"> <label for="show_id">Kundennummer anzeigen</label>
                    </div>
                    <div class="form-group">
                        <label for="subject">Betreff:</label>
                        <input type="text" name="subject" class="form-control" id="subject">
                    </div>
                    <div class="form-group">
                        <label for="text">Briefinhalt:</label>
                        <textarea name="content" class="form-control" id="text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="greeter">Unterzeichner:</label>
                        <input name="greeter" class="form-control" id="greeter">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Erstellen">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<form method="post">
    <div class="row">
        <div class="col-md-6">
            <h4>Allgemeines</h4>
            <?php foreach ($inputs as $input) : ?>
                <?php $id = $input[0] ?>
                <div class="form-group">
                    <label for="<?php echo $id ?>"><?php echo $input[1] ?>:</label>
                    <input type="text" class="form-control" name="<?php echo $id ?>" id="<?php echo $id ?>" value="<?php echo $customer->$id ?>">
                </div>
            <?php endforeach ?>
        </div>
        <div class="col-md-6">
            <h4>Kontakt</h4>
            <?php foreach ($company as $input) : ?>
                <?php $id = $input[0] ?>
                <div class="form-group">
                    <label for="<?php echo $id ?>"><?php echo $input[1] ?>:</label>
                    <input type="text" class="form-control" name="<?php echo $id ?>" id="<?php echo $id ?>" value="<?php echo $customer->$id ?>">
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <input type="submit" value="Bearbeiten" class="btn btn-primary">
</form>
<?php include 'foot.php' ?>
