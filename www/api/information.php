<div class="information shadow-lg p-3 mb-5 bg-white rounded">
        <p class="header">Thông tin cá nhân</p>
        <div class="image">
            <img src="<?=$data['image']?>" alt="">
            <a class="changeImage" href="index.php?order=updateImage">Change</a>
        </div>
        <div class="row">
            <div class="col-6" style="text-align: center">
                <label>First Name</label>
                <p class="name-field"><?=$data['firstName']?></p>
            </div>
            <div class="col-6" style="text-align: center">
                <label>Last Name</label>
                <p class="name-field"><?=$data['lastName']?></p>
            </div>
        </div>
        
        <div class="group">
            <label for="">Date of Birth</label>
            <p class="field-property"><?=$data['birth']?></p>
        </div>

        <div class="group">
            <label for="">Email</label>
            <p class="field-property"><?=$data['email']?></p>
        </div>
        <div class="group">
            <label for="">Address</label>
            <p class="field-property"><?=$data['address']?></p>
        </div>
        <div class="group">
            <label for="">Phone number</label>
            <p class="field-property"><?=$data['phonenumber']?></p>
        </div>
        <div class="group" style="padding: 10px; display: flex; justify-content: space-around;">
           <a href="index.php?order=updateInfo" class="btn btn-primary">Update Info</a>
           <a href="index.php?order=updatePassword" class="btn btn-primary">Update Password</a>
        </div>
</div>