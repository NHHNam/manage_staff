<?php 
    $result7 = get_information_task_by_maTask($_GET['maTask']);
    if($result7['code'] == 0){
        $dataTask = $result7['data'];
    }else{
        $error = $result7['message'];
    }
    // add file to Submit
    if(isset($_POST['addFile'])){
        for($i = 0; $i < count($_FILES['files']['name']); $i++)
        {
            $fileSize = $_FILES['files']['size'][$i];
            if($fileSize > 2097152){
                $error = 'File size is too big so please try again'.$_FILES['files']['name'][$i];
            }else{
                $file = "uploads/".$_FILES['files']['name'][$i];
                $target = "uploads/".$_FILES['files']['name'][$i];
                move_uploaded_file($_FILES['files']['tmp_name'][$i], $target);
                add_curr_files($dataTask['maTask'], $file);
            }
        }
    }
    $result8 = get_curr_files($dataTask['maTask']);
    $dataFiles = $result8['data'];
    
    // submit task
    if(isset($_POST['submitBTN'])){
        $maTask = $_POST['task_submit'];
        $list = $_POST['listFiles'];
        $time = date("Y-m-d h:i:sa");

        // check list file is empty ?
        if(empty($list)){
            $error = "Không thể submit tại vì vẫn chưa có file chọn";
        }else{
            change_status_task("Waiting", $maTask);
            $resultSubmit = submit_task($maTask, $list, $time);
            if($resultSubmit['code'] === 0){
                $success = $resultSubmit['message'];
            }else{
                $error = $resultSubmit['message'];
            }
        }
    }
    // unsubmit task
    if(isset($_POST['unSubmitBTN'])){
        $maTask = $_POST['task_unsubmit'];
        $ok = change_status_task("In Progress", $maTask);
    }

    // list file for submit
    $listFilesSubmit = "";
    foreach ($dataFiles as $file) {
        $listFilesSubmit = $listFilesSubmit.split_file_name($file['files']).", ";
    }

    // history submit list
    $resultHis = get_history_submit($dataTask['maTask']);
    $dataHis = $resultHis['data'];
?>
<small>
    <a href="index.php?order=task" class="text-primary">Back</a>
</small>
<div class="shadow-none p-3 mb-5 bg-light rounded row">
    <div class="col-lg-8 col-sm-12">
    <div class="group">
            <label for="address">Hạn nộp Task</label>
            <p class="field-property"><?=$dataTask['deadline']?></p>
        </div>
        <div class="row" style="text-align: center">
            <div class="col">
                <label>Người gửi</label>
                <p class="name-field"><?=$dataTask['sender']?></p>
            </div>
            <div class="col">
                <label for="">Người yêu cầu</label>
                <p class="name-field"><?=$dataTask['receiver']?></p>
            </div>
        </div>
        <div class="group">
            <label for="address">Tên của Task</label>
            <p class="field-property"><?=$dataTask['nameTask']?></p>
        </div>
        <div class="group">
            <label for="phone">Mô tả của Task</label>
            <p class="field-property"><?=$dataTask['descTask']?></p>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <ul id="list" class="list-group">

        </ul>
        <?php
            if($dataTask['status'] !== 'Waiting'){
                ?>
                <div class="form-group">
                    <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#exampleModal">
                        +
                    </button>
                </div>
                <?php
            }
        ?>
        <form>
            <div class="form-group">
                <?php
                    if($dataTask['status'] === 'Waiting'){
                        ?>
                        <button type="button" class="btn btn-danger form-control"
                                onclick="get_values_unsubmit('<?=$dataTask['maTask']?>', '<?=$dataTask['nameTask']?>')"
                                data-toggle="modal" data-target="#unsubmit-confirm">
                            UnSubmit
                        </button>
                        <?php
                    }else{
                        ?>
                        <button type="button" class="btn btn-success form-control"
                                onclick="get_values_submit('<?=$dataTask['maTask']?>', '<?=$dataTask['nameTask']?>', '<?=$listFilesSubmit?>')"
                                data-toggle="modal" data-target="#submit-confirm">
                            Submit
                        </button>
                        <?php
                    }
                ?>

            </div>
        </form>
        <div class="form-group">
            <button data-toggle="modal" data-target="#history-submit" class="btn btn-dark form-control">
                History</button>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
        include("alert.php");
    ?>
</div>

<!-- Confirm upload file -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" class="nop_task" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nộp task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="fileN">
                            <i class="fas fa-cloud-upload-alt"></i> Chọn file để nộp
                        </div>
                        <input type="file" multiple="multiple" name="files[]" id="files"
                         accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*, .docx, .pptx" hidden>
                    </div>
                    <ul class="form-group info-file"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="addFile" id="nopTask" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm submit task -->
<div class="modal fade" id="submit-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Submit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn submit <strong id="name_submit">Hi</strong>
                    <input type="hidden" name="task_submit" id="task_submit">
                    <input type="hidden" name="listFiles" id="listFiles">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="submitBTN" id="submitBTN" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm unsubmit task -->
<div class="modal fade" id="unsubmit-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">UnSubmit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn unsubmit <strong id="name_unsubmit">Hi</strong>
                    <input type="hidden" name="task_unsubmit" id="task_unsubmit">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="unSubmitBTN" id="unSubmitBTN" class="btn btn-danger">UnSubmit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm delete file -->
<div class="modal fade" id="deleteFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn xoá File <strong id="nameFile">Hi</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" data-id="" data-ma_task="" data-position="" id="delFile" class="btn btn-danger">Delete</button>
                </div>
        </div>
    </div>
</div>

<!-- History submit task -->
<div class="modal fade" id="history-submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">History submit task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <?php
                        foreach (array_reverse($dataHis) as $file){
                            $list_file = explode(",", $file['arrayFile']);
                            ?>
                            <li class="list-group-item">
                                <div class="mb-2"><i class="fas fa-clock"></i> <?=$file['dateTime']?></div>
                                <div style="border: 1px solid #ccc;"></div>
                                <div class="row mt-2">
                            <?php
                            foreach ($list_file as $f){
                                if($f != " " && !empty($f)){
                            ?>
                                    <p class="col-12"><i class="fas fa-file"></i> <?=$f?></p>
                            <?php
                                }
                            }
                            ?>
                                </div>
                                </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>