<?php
    $result_get_list_task = get_list_task_manager($phongban);
    print_r($result_get_list_task['data']);
?>
<small>
  <a href="index.php" class="text-primary">Back</a>
</small>
<h1>Manage Task</h1>
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
            ?>
            <tr>
                <td><?=$stt_task?></td>
                <td><a href="index.php?order=detailTask&maTask=<?=$task['maTask']?>"><?=$task['nameTask']?></a></td>
                <td><?=$task['status']?></td>
                <td>
                    <i class="fas fa-edit"></i>
                    |
                    <i class="fas fa-trash-alt"></i>
                </td>
            </tr>
            <?php
            $stt_task += 1;
        }
    ?>
    </tbody>
</table>