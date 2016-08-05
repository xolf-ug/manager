<?php include 'bootstrap.php' ?>
<?php include 'head.php' ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Ort</th>
        <th>Straße</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($io->table('customer')->getAllDocuments() as $customer) : ?>
        <tr>
            <td><a href="customer.php?i=<?php echo $customer->id ?>"><?php echo $customer->id ?></a></td>
            <td><?php echo $customer->name ?></td>
            <td><?php echo $customer->city ?></td>
            <td><?php echo $customer->street ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include 'foot.php' ?>
