<small>
    <a class="text-primary" href="admin.php?order=manageStaff">Back</a>
</small>
<form method="post" enctype="multipart/form-data" class="shadow-none p-3 mb-5 bg-light rounded">
    <div class="form-group">
        <label for="fname">First Name:</label>
        <input type="text" name="fname" class="form-control" placeholder="Enter name" id="fname">
    </div>

    <div class="form-group">
        <label for="lname">Last Name:</label>
        <input type="text" class="form-control" placeholder="Enter name" id="lname" name="lname">
    </div>

    <div class="form-group">
        <label for="lname">Date of birth:</label>
        <input type="date" min="1970-01-01" max="2004-12-31" name="birth" class="form-control" >
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" placeholder="Enter name" id="email" name="email">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" placeholder="Enter username" name="username" id="username">
    </div>

    <div class="form-group">
        <label for="phongban">Phòng ban</label>
        <select name="phongban" id="phongban">
        <option>-----Chooese phong ban-----</option>
        <?php 
            $data = $result2['data'];
            foreach ($data as $row){
                ?>
                    <option value="<?=$row['namePB']?>"><?=$row['namePB']?></option>
                <?php
            }
        ?>
        </select>
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" placeholder="Enter address" name="address" id="address">
    </div>

    <div class="form-group">
        <label for="phone">Phone number</label>
        <input type="text" class="form-control" placeholder="Enter phone" name="phone" id="phone">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Upload</span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="avatar" accept="image/png, image/gif, image/jpeg, image/webp" id="inputGroupFile01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
    </div>

    <div class="form-group">
        <?php
        include("../api/alert.php");
        ?>
    </div>
    <div class="form-group">
        <input type="submit" value="Save" name="addNV" class="btn btn-primary form-control">
    </div>
</form>    