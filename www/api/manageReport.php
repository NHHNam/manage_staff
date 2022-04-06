<?php
    $list_staff = get_staff_by_manager($phongban)['data'];
    if(isset($_POST['approveReport'])){
//        print_r($_POST);
        $id = $_POST['id_report_evaluate'];
        $username = $_POST['username_report_evaluate'];
        $numDay = (int)$_POST['num_report_evaluate'];
        $result1 = change_status_report($id, "Approved");
        update_day_release($username, $numDay);
    }else if(isset($_POST['rejectReport'])){
        $id = $_POST['id_report_evaluate'];
        change_status_report($id, "Rejected");
    }
?>
<small>
  <a href="index.php" class="text-primary">Back</a>
</small>
<h1>Manage Report</h1>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Reason</th>
        <th>From Day</th>
        <th>To Day</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    <?php
        $stt_report = 1;
        foreach ($list_staff as $staff){
//            print_r($staff['username']);
            $result = get_report_manager($phongban, $staff['username'])['data'];
            foreach ($result as $report){
                if($report['status'] != "Approved"){
            ?>
            <tr>
                <td><?=$stt_report?></td>
                <td><?=$report['firstName']?></td>
                <td><?=$report['lastName']?></td>
                <td><?=$report['reason']?></td>
                <td><?=$report['fromDay']?></td>
                <td><?=$report['toDay']?></td>
                <td><?=$report['status']?></td>
                <td>
                    <button class="btn btn-success"
                            onclick="get_values_evaluate_report('<?=$report['firstName']." ".$report['lastName']?>', <?=$report['id']?>, '<?=$report['username']?>', <?=$report['songay']?>)"
                            data-toggle="modal" data-target="#evaluate-report">Evaluate
                    </button>
                </td>
            </tr>
            <?php

            $stt_report+=1;
                }
            }
        }
    ?>
    </tbody>
</table>

<div class="modal fade" id="evaluate-report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" class="nop_task" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Evaluate Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Đơn xin nghỉ của <strong id="name_staff_report">Hi</strong>
                    <input type="hidden" name="id_report_evaluate" id="id_report_evaluate">
                    <input type="hidden" name="username_report_evaluate" id="username_report_evaluate">
                    <input type="hidden" name="num_report_evaluate" id="num_report_evaluate">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="approveReport" id="approveReport" class="btn btn-primary">Approve</button>
                    <button type="submit" name="rejectReport" id="rejectReport" class="btn btn-primary">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>