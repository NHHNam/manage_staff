<h1>Manage Room</h1>
<button class="btn btn-success mb-5" data-toggle="modal" data-target="#add-room-confirm">+</button>
<?php
    $dataRoom = $result2['data'];
    if(isset($_POST['editRoom'])){
        $name_room = $_POST['name-room-edit'];
        $destination_room = $_POST['destination-room-edit'];
        $id = $_POST['id-room-edit'];
        $resultEdit = edit_room($id, $name_room, $destination_room);
        if($resultEdit['code'] == 0){
            $success = $resultEdit['message'];
        }else{
            $error = $resultEdit['message'];
        }
    }else if(isset($_POST['addRoom'])){
        $room_name = $_POST['name-room'];
        $destination_room = $_POST['destination-room'];
        $resultAddRoom = add_room($room_name, $destination_room);
        print_r(check_before_add_room_by_name($room_name));
        print_r(check_before_add_room_by_destination($destination_room));
        if($resultAddRoom['code'] == 0){
            $success = $resultAddRoom['message'];
        }else{
            $error = $resultAddRoom['message'];
        }
    }
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
                    <i class="fas fa-edit btn-edit-room" data-toggle="modal" data-target="#edit-room-confirm"
                       onclick="get_values_room('<?=$room['namePB']?>', '<?=$room['destination']?>', <?=$room['id']?>)"></i>
                </td>
            </tr>
            <?php
            $idRoom =$idRoom + 1;
        }
    ?>
    </tbody>
</table>
<?php
    include('../api/alert.php');
?>
<!-- Confirm edit Room -->
<div class="modal fade" id="edit-room-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="badge badge-secondary">Room name</label>
                        <input type="text" class="form-control" name="name-room-edit" id="name-room-edit">
                    </div>

                    <div class="form-group">
                        <label class="badge badge-secondary">Room destination</label>
                        <input type="text" class="form-control" name="destination-room-edit" id="destination-room-edit">
                    </div>
                    <input type="hidden" class="form-control" name="id-room-edit" id="id-room-edit">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="editRoom" id="editRoom" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm add new room -->
<div class="modal fade" id="add-room-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="badge badge-secondary">Room name</label>
                        <input type="text" class="form-control" value="<?php if (!empty($room_name)) echo $room_name;?>" name="name-room" placeholder="Enter new name room">
                    </div>

                    <div class="form-group">
                        <label class="badge badge-secondary">Room destination</label>
                        <input type="text" class="form-control" value="<?php if (!empty($destination_room)) echo $destination_room;?>" name="destination-room" placeholder="Enter destination room">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="addRoom" id="addRoom" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>