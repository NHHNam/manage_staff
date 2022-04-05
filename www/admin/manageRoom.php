<h1>Manage Room</h1>
<?php
    $dataRoom = $result2['data'];
?>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name Room</th>
        <th scope="col">Destination</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $idRoom = 1;
        foreach ($dataRoom as $room){
            ?>
            <tr>
                <th scope="row"><?=$idRoom?></th>
                <td><?=$room['namePB']?></td>
                <td><?=$room['destination']?></td>
                <td>
                    <i class="fas fa-edit"></i>
                </td>
            </tr>
            <?php
            $idRoom =$idRoom + 1;
        }
    ?>
    </tbody>
</table>