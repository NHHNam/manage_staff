<?php
    $phongban = $_GET['PB'];
    $dataStaffRoom = get_staff_by_room($phongban)['data'];
//    print_r($dataStaffRoom);
    if(isset($_POST['boNhiem'])){
        $id_choose_manager = $_POST['id_choose_manager'];
        $duocnghiTP = 18;
        $resultBoNhiem = choose_manager($id_choose_manager, $duocnghiTP);

        if($resultBoNhiem['code'] == 0){
            $success = $resultBoNhiem['message'];
        }else{
            $error = $resultBoNhiem['message'];
        }
    }else if(isset($_POST['huyBoNhiem'])){
        $duocnghiNV = 15;
        $id_reject_manager = $_POST['id_reject_manager'];
        $resultHuyBoNhiem = reject_manager($duocnghiNV, $id_reject_manager);

        if($resultHuyBoNhiem['code'] == 0){
            $success = $resultHuyBoNhiem['message'];
        }else{
            $error = $resultHuyBoNhiem['message'];
        }
    }
?>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $stt = 1;
        foreach($dataStaffRoom as $a){
            ?>
            <tr>
                <th scope="row"><?=$stt?></th>
                <td><?=$a['firstName']?></td>
                <td><?=$a['lastName']?></td>
                    <?php
                        if($a['chucvu'] == 'trưởng phòng'){
                            ?>
                                <td><button data-toggle="modal"
                                            onclick="get_name_to_huy_bo_nhiem(<?=$a['id']?>, '<?=$a['firstName']." ".$a['lastName']?>')"
                                            data-target="#confirm-huy-bo-nhiem" class="btn btn-danger">Hủy bổ nhiệm</button></td>
                            <?php
                        }else if(check_has_truong_phong($a['phongban']) == true){
                            ?>
                                <td></td>
                            <?php
                        }else{
                            ?>
                                <td><button data-toggle="modal" onclick="get_name_to_bo_nhiem(<?=$a['id']?>)" data-target="#confirm-bo-nhiem" class="btn btn-success">Bổ nhiệm</button></td>
                            <?php
                        }
                    ?>

            </tr>
            <?php
            $stt += 1;
        }
    ?>
    </tbody>
</table>
<?php
    include('../api/alert.php');
?>
<div class="modal fade" id="confirm-bo-nhiem">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Chọn trưởng phòng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    Bạn có chắc rằng muốn nâng chức vụ nhân viên <strong id="name-to-chon">image.jpg</strong>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="id_choose_manager" id="id_choose_manager">
                    <button type="submit" name="boNhiem" class="btn btn-danger">Bổ nhiệm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--        huỷ bổ nhiệm-->
<div class="modal fade" id="confirm-huy-bo-nhiem">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Huỷ trưởng phòng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    Bạn có chắc rằng muốn huỷ chức vụ của nhân viên <strong id="name-to-huy">image.jpg</strong>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="id_reject_manager" id="id_reject_manager">
                    <button type="submit" name="huyBoNhiem" class="btn btn-danger">Huỷ bổ nhiệm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                </div>
            </form>
        </div>
    </div>
</div>