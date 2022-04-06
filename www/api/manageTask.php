<?php
    $result_get_list_task = get_list_task_manager($phongban);
//    print_r($result_get_list_task['data']);
    $result_get_list_staff_manager = get_staff_by_manager($phongban);
//    print_r($result_get_list_staff_manager['data']);
    $curr_day = date('Y-m-d');
    if(isset($_POST['add_staff_btn'])){
        $name_task = $_POST['name_task_add'];
        $desc_task = $_POST['desc_task_add'];
        $deadline_task = $_POST['deadline_task_add'];
        $staff_choose = $_POST['staff_choose_add'];
        $sender = $_POST['sender'];
        $phongban = $_POST['phongban'];
        $result_add_task = add_task_manager($sender, $staff_choose, $name_task, $desc_task, $deadline_task, $phongban);
        if($result_add_task['code'] == 0){
            $success = $result_add_task['message'];
        }else{
            $error = $result_add_task['message'];
        }
    }else if(isset($_POST['editTask'])){
        $name_task_edit = $_POST['name_task_edit'];
        $desc_task_edit = $_POST['desc_task_edit'];
        $staff_choose_edit = $_POST['staff_choose_edit'];
        $id_task_edit = $_POST['id_task_edit'];
        $result_edit_task = edit_task_manager($id_task_edit, $name_task_edit, $desc_task_edit, $staff_choose_edit);
        if($result_edit_task['code'] == 0){
            $success = $result_edit_task['message'];
        }else{
            $error = $result_edit_task['message'];
        }
    }else if(isset($_POST['del_task'])){
        $id = $_POST['id_task_del'];
        $result_del = delete_task_manager($id);
        if($result_del['code'] == 0){
            $success = $result_del['message'];
        }else{
            $error = $result_del['message'];
        }
    }
?>
<small>
  <a href="index.php" class="text-primary">Back</a>
</small>
<h1>Manage Task</h1>
<button data-toggle="modal" data-target="#add-task-confirm" class="btn btn-primary mb-4">Add</button>
<h2 style="text-align: center">Current Task</h2>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Name Task</th>
        <th>Status task</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $stt_task = 1;
        $data_list_task = $result_get_list_task['data'];
        foreach ($data_list_task as $task){
            if($task['status'] != "Completed"){
            ?>
            <tr>
                <td><?=$stt_task?></td>
                <td><a href="index.php?order=detailTask&maTask=<?=$task['maTask']?>"><?=$task['nameTask']?></a></td>
                <td><?=$task['status']?></td>
                <td>
                    <i style="cursor: pointer;" data-toggle="modal" data-target="#edit-task-confirm" class="fas fa-edit"
                       onclick="get_values_edit_task(<?=$task['id']?>, '<?=$task['nameTask']?>')"></i>
                    <?php
                        if($task['status'] == "New"){
                            ?>
                            |
                            <i style="cursor: pointer;" data-toggle="modal" data-target="#delete-task-confirm" class="fas fa-trash-alt"
                               onclick="get_values_del_task(<?=$task['id']?>, '<?=$task['nameTask']?>')"></i>
                            <?php
                        }
                    ?>

                </td>
            </tr>
            <?php
                $stt_task += 1;
            }
        }
    ?>
    </tbody>
</table>
<h2 style="text-align: center; margin-top: 30px;">Completd Task</h2>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Name Task</th>
        <th>Status task</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $stt_task_completed = 1;
    $data_list_task = $result_get_list_task['data'];
    foreach ($data_list_task as $task){
        if($task['status'] == "Completed"){
            ?>
            <tr>
                <td><?=$stt_task_completed?></td>
                <td><a href="index.php?order=detailTask&maTask=<?=$task['maTask']?>"><?=$task['nameTask']?></a></td>
                <td><?=$task['status']?></td>
                <td>
                    <i style="cursor: pointer;" data-toggle="modal" data-target="#edit-task-confirm" class="fas fa-edit"
                       onclick="get_values_edit_task(<?=$task['id']?>, '<?=$task['nameTask']?>')"></i>
                    <?php
                    if($task['status'] == "New"){
                        ?>
                        |
                        <i style="cursor: pointer;" data-toggle="modal" data-target="#delete-task-confirm" class="fas fa-trash-alt"
                           onclick="get_values_del_task(<?=$task['id']?>, '<?=$task['nameTask']?>')"></i>
                        <?php
                    }
                    ?>

                </td>
            </tr>
            <?php
            $stt_task_completed += 1;
        }

    }
    ?>
    </tbody>
</table>

<?php
    include("alert.php");
?>

<!-- Confirm edit task -->
<div class="modal fade" id="edit-task-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="badge badge-secondary" for="name_task_edit">Name task</label>
                        <input type="text" class="form-control" name="name_task_edit" id="name_task_edit">
                    </div>
                    <div class="form-group">
                        <label class="badge badge-secondary" for="desc_task_edit">Description task</label>
                        <textarea class="form-control" rows="4" name="desc_task_edit" id="desc_task_edit"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="badge badge-secondary" for="staff_choose_edit">Choose staff do</label>
                        <select class="custom-select custom-select-sm" id="staff_choose_edit" name="staff_choose_edit">
                            <?php
                            $list_staff =  $result_get_list_staff_manager['data'];
//                            print_r($list_staff);
                            if(count($list_staff) > 0){
                                foreach ($list_staff as $staff){
                                    $name_staff = $staff['firstName']." ". $staff['lastName'];
                                    print_r($name_staff);
                                    ?>
                                    <option value="<?=$name_staff?>">
                                        <?=$name_staff?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                    <input type="hidden" id="id_task_edit" name="id_task_edit">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="editTask" id="editTask" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Confirm delete task -->
<div class="modal fade" id="delete-task-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn xoá <strong id="name_task_del">Hi</strong>
                    <input type="hidden" name="id_task_del" id="id_task_del">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="del_task" id="del_task" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm add task -->
<div class="modal fade" id="add-task-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="badge badge-secondary" for="name_task_add">Name task</label>
                        <input type="text" class="form-control" name="name_task_add" id="name_task_add">
                    </div>
                    <div class="form-group">
                        <label class="badge badge-secondary" for="desc_task_add">Description task</label>
                        <input type="text" class="form-control" name="desc_task_add" id="desc_task_add">
                    </div>
                    <div class="form-group">
                        <label class="badge badge-secondary" for="desc_task_add">Deadline task</label>
                        <input type="date" min="<?=$curr_day?>" class="form-control" name="deadline_task_add" id="deadline_task_add">
                    </div>
                    <div class="form-group">
                        <label class="badge badge-secondary" for="staff_choose_add">Choose staff do</label>
                        <select class="custom-select custom-select-sm" id="staff_choose_add" name="staff_choose_add">
                            <option selected>Open this select menu</option>
                            <?php
                            $list_staff =  $result_get_list_staff_manager['data'];
                            //                            print_r($list_staff);
                            if(count($list_staff) > 0){
                                foreach ($list_staff as $staff){
                                    $name_staff = $staff['firstName']." ". $staff['lastName'];
                                    print_r($name_staff);
                                    ?>
                                    <option value="<?=$name_staff?>">
                                        <?=$name_staff?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                    <input type="hidden" name="sender" value="<?=$data['firstName']." ".$data['lastName']?>">
                    <input type="hidden" name="phongban" value="<?=$phongban?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_staff_btn" id="add_staff_btn" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>