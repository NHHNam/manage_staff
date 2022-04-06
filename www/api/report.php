<?php
    $curr_day = date('Y-m-d', strtotime("+1 days")); // get date for choosing day for report
    // check report which we add report is waiting ? completed

    $result_check_report = check_report($data['firstName'], $data['lastName']);
    $status_after_check = "";
    if(count($result_check_report['data']) > 0){
        $status_after_check = array_reverse($result_check_report['data'])['0']['status'];
    }
?>
<div class="field">
    Số ngày nghỉ <?=$data['tongngaynghi']?> / <?=$data['duocnghi']?>
</div>
<?php
    if($status_after_check !== "Waiting"){
        ?>
            <button class="btn btn-success mb-5" data-toggle="modal" data-target="#add-report">+</button>
        <?php
    }
?>
<table class="table table-bordered">
    <thead>
        <th>STT</th>
        <th>Lý do</th>
        <th>Thời gian nghỉ</th>
        <th>Tiến trình</th>
    </thead>
    <tbody>
    <?php 
        if($result2['code'] == 0){
            foreach($result2['data'] as $row1){
        ?>
        <tr>
            <td>1</td>
            <td><?=$row1['reason']?></td>
            <td><?=convert_day($row1['fromDay'])?> <strong>To</strong> <?=convert_day($row1['toDay'])?></td>
            <td>Waiting</td>
        </tr>
        <?php 
            }}
        ?>
    </tbody>
</table>
<?php
    include("alert.php");
?>

<!-- Add new report -->
<div class="modal fade" id="add-report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" class="nop_task" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xin nghỉ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="badge badge-secondary" for="fromDay">From day</label>
                        <input class="form-control" type="date" name="fromDay" id="fromDay" min="<?=$curr_day?>">
                    </div>

                    <div class="form-group">
                        <label class="badge badge-secondary" for="toDay">To day</label>
                        <input class="form-control" type="date" name="toDay" id="toDay" min="<?=$curr_day?>">
                    </div>

                    <div class="form-group">
                        <label class="badge badge-secondary" for="reason">Reason</label>
                        <textarea rows="4" class="form-control" name="reason" id="reason"></textarea>
                    </div>

                    <input type="hidden" name="PB" value="<?=$data['phongban']?>">
                    <input type="hidden" name="fName" value="<?=$data['firstName']?>">
                    <input type="hidden" name="lName" value="<?=$data['lastName']?>">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="addReport" id="addReport" class="btn btn-primary">Xin nghỉ</button>
                </div>
            </form>
        </div>
    </div>
</div>