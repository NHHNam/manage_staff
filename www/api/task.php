<h1>New Task</h1>
<table class="table table-bordered" >
    <thead>
        <th>STT</th>
        <th>Tên Task</th>
        <th>Tiến trình</th>
    </thead>
    <tbody>
        <?php 
        if($result1['code'] == 0){
            $stt = 1;
            foreach($result1['data'] as $row){
        ?>
        <tr class="<?=$row['id']?>" onclick="show(this)">
            <td><?=$stt?></td>
            <td>
                <?=$row['nameTask']?>
            </td>
            <td>
                <?php 
                    if($row['status'] == "New"){
                        ?>
                           <form method="post">
                               <input type="hidden" name="maTask" value="<?=$row['maTask']?>">
                               <input type="submit" name="startTask" value="Start" class="btn btn-primary">
                           </form>
                        <?php
                    }else{
                        ?>
                            <span><?=$row['status']?> </span>
                        <?php
                    }
                ?>
                <tr class="descA row-desc-<?=$row['id']?>">
                    <td colspan="3">
                        <div>
                            <?=$row['descTask']?>
                        </div>
                        <a class="text-primary" href="index.php?order=detailTask&maTask=<?=$row['maTask']?>">View</a>
                    </td>
                </tr>
            </td>
        </tr>
        <?php 
            $stt += 1;
            }}
        ?>
    </tbody>
</table>