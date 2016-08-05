<?php include 'bootstrap.php' ?>
<?php include 'head.php' ?>
<?php
    if(isset($_GET['printed']))
    {
        $letter = $io->table('letter')->document($_GET['printed']);
        if(isset($letter->printed)) $letter->write(['printed' => null]);
        else $letter->write(['printed' => true]);
    }
?>
<?php if(isset($_GET['i'])) :

    if(isset($_POST['content'])) {
        $io->table('letter')->document($_GET['i'])->write($_POST);
        if(!isset($_POST['salut'])) $io->table('letter')->document($_GET['i'])->write(['salut' => null]);
        if(!isset($_POST['show_id'])) $io->table('letter')->document($_GET['i'])->write(['show_id' => null]);

        echo '
<div class="alert alert-success">
  <strong>Erfolgreich!</strong> Der Brief wurde erfolgreich bearbeitet.
</div>';
    }
    $letter = $io->table('letter')->document($_GET['i']);
?>
    <form method="post" action="letter.php?i=<?php echo $_GET['i'] ?>">
        <input type="hidden" name="customer_id" value="<?php echo $letter->customer_id ?>">
        <input type="hidden" name="date" value="<?php echo $letter->date ?>">
        <div class="form-group">
            <input <?php if(isset($letter->salut)) echo 'checked' ?> type="checkbox" name="salut" value="yes" id="salut"> <label for="salut">Anrede</label>
        </div>
        <div class="form-group">
            <input <?php if(isset($letter->show_id)) echo 'checked' ?> type="checkbox" name="show_id" value="yes" id="show_id"> <label for="show_id">Kundennummer anzeigen</label>
        </div>
        <div class="form-group">
            <label for="subject">Betreff:</label>
            <input type="text" name="subject" class="form-control" id="subject" value="<?php if(isset($letter->subject)) echo $letter->subject ?>">
        </div>
        <div class="form-group">
            <label for="text">Briefinhalt:</label>
            <textarea name="content" class="form-control" id="text"><?php if(isset($letter->content)) echo $letter->content ?></textarea>
        </div>
        <div class="form-group">
            <label for="greeter">Unterzeichner:</label>
            <input name="greeter" class="form-control" id="greeter" value="<?php if(isset($letter->greeter)) echo $letter->greeter ?>">
        </div>
        <input type="submit" class="btn btn-primary" value="Bearbeiten">
        <a class="btn btn-default" href="write-letter.php?i=<?php echo $_GET['i'] ?>">PDF Herunterladen</a>
    </form>
<?php endif
?>

<?php if(!isset($_GET['i'])) :
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Kunde</th>
            <th>Betreff</th>
            <th>Datum</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($io->table('letter')->getAllDocuments() as $letter) : ?>
            <?php $customer = $io->table('customer')->document($letter->customer_id) ?>
            <tr>
                <td><a href="write-letter.php?i=<?php echo $letter->id ?>"><?php echo $letter->id ?></a></td>
                <td><?php echo $customer->name ?></td>
                <td><a href="?i=<?php echo $letter->id ?>" class="text-primary"><i class="fa fa-pencil"></i> <?php echo $letter->subject ?></a></td>
                <td><?php echo $letter->date ?> <a href="?printed=<?php echo $letter->id ?>" class="btn btn-<?php echo (isset($letter->printed) ? 'default' : 'warning') ?> btn-sm"><i class="fa fa-print" aria-hidden="true"></i></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif
?>
<?php include 'foot.php' ?>
