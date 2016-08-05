<?php session_start() ?>
<?php include 'bootstrap.php' ?>
<?php include 'head.php' ?>
<?php
if(!isset($_SESSION['articles'])) $_SESSION['articles'] = [];
if(isset($_GET['del'])) unset($_SESSION['articles'][$_GET['del']]);
if(isset($_POST['name'])) {
    $_POST['price'] = str_replace(',','.', $_POST['price']);
    $_POST['price'] = intval($_POST['price']);
    $_SESSION['articles'][] = $_POST;
}
$total = 0;
?>
<div class="modal fade" id="writeLetter" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Artikel hinzufügen</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="desc">Beschreibung:</label>
                        <textarea name="desc" class="form-control" id="desc"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pos">Position:</label>
                                <input type="number" name="pos" class="form-control" id="pos">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Preis:</label>
                                <input type="number" name="price" class="form-control" id="price" aria-describedby="price-currency" step="0.01">
                                <span class="input-group-addon" id="price-currency">€</span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success" value="Hinzufügen">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<h1>Rechnung erstellen</h1>
<form method="post" action="invoice.php">
    <input type="hidden" name="date" value="<?php echo date('d.m.Y') ?>">
    <div class="row clearfix">
        <div class="col-md-4">
            <h4>Kunde</h4>
            <div class="form-group">
                <label for="customer">Kunde</label>
                <select class="form-control" name="customer_id" id="customer">
                    <?php foreach ($io->table('customer')->getAllDocuments() as $customer) : ?>
                        <option value="<?php echo $customer->id ?>">#<?php echo $customer->id ?> - <?php echo $customer->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col-md-8">
            <h4>Artikel</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Beschreibung</th>
                        <th>Position</th>
                        <th>Preis</th>
                    </tr>
                </thead>
                <tbody id="articles"">
                <?php foreach ($_SESSION['articles'] as $key => $article) : ?>
                    <tr>
                        <td><a href="?del=<?php echo $key ?>" class="text-danger"><i class="fa fa-times fa-fw"></i></a> <?php echo $article['name'] ?></td>
                        <td><?php echo $article['desc'] ?></td>
                        <td><?php echo $article['pos'] ?></td>
                        <td><?php echo number_format($article['price'], 2, ',', '.') ?> €</td>
                    </tr>
                    <?php $total += $article['pos'] * $article['price'] ?>
                <?php endforeach ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><b>Total</b></td>
                    <td><?php echo number_format($total, 2, ',', '.') ?> €</td>
                </tr>
                <?php $_SESSION['total'] = $total ?>
                </tbody>
            </table>
            <a class="btn btn-success" id="add-article" data-toggle="modal" data-target="#writeLetter">Artikel hinzufügen</a>
        </div>
    </div>
    <input type="submit" value="Erstellen" class="btn btn-primary">
</form>
<?php include 'foot.php' ?>
