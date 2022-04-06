<small>
  <a href="index.php" class="text-primary">Back</a>
</small>
<form class="shadow-none p-3 mb-5 bg-light rounded" method="post">
  <div class="form-row">
    <div class="col">
      <label>First Name</label>
      <input type="text" class="form-control" value="<?=$data['firstName']?>" id="fName" name="fName">
    </div>
    <div class="col">
      <label>Last Name</label>
      <input type="text" class="form-control" value="<?=$data['lastName']?>" name="lName">
    </div>
  </div>

  <div class="form-group mt-3">
      <label for="lname">Date of birth:</label>
      <input type="date" min="1970-01-01" max="2004-12-31" name="birth" value="<?=$data['birth']?>" class="form-control" >
  </div>

  <div class="form-group">
    <label>Email</label>
    <input class="form-control" value="<?=$data['email']?>" type="email" name="email" id="email">
  </div>

  <div class="form-group">
    <label>Address</label>
    <input class="form-control" type="text" value="<?=$data['address']?>" name="address" id="address">
  </div>

  <div class="form-group">
    <label>Phone Number</label>
    <input class="form-control" value="<?=$data['phonenumber']?>" type="text" name="phoneNumber" id="phoneNumber">
  </div>

  <input type="hidden" name="id" value="<?=$data['id']?>">

  <div class="form-group">
      <?php
      include("alert.php");
      ?>
  </div>

  <div class="form-group">
    <input type="submit" value="Save" name="updateInfo" class="btn btn-primary form-control">
  </div>
</form>