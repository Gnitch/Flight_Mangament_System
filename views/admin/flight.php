<?php include_once 'header.php'; ?>
<?php include_once 'footer.php'; ?>
<?php require '../../helpers/init_conn_db.php'; ?>

<link rel="stylesheet" href="../../assets/css/flight_form.css">
<link rel="stylesheet" href="../../assets/css/form.css">

<?php if(isset($_SESSION['adminId'])) { ?>

<style>

  h5.form-name {
    color: cornflowerblue;
    font-family: 'Courier New', Courier, monospace;
    font-weight: 50;
    margin-bottom: 0px !important;
    margin-top: 10px;
  }
  h1 {
    font-size: 65px !important;
    font-family: 'Cantarell', sans-serif;
    font-family: 'Permanent Marker', cursive;   
    margin-bottom: 20px;  
  }
  body {
    /* padding-top: 20px; */
    background-image: url('../../assets/images/bg5.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;    
  }
  div.form-out {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
    background-color: whitesmoke !important;
    padding: 30px;
    margin-top: 50px;
  }

  select {
    float: right;
  }


  @media screen and (max-width: 900px){
    body {
      background-color: lightblue;
      background-image: none;
    }
    div.form-out {
    padding: 20px;
    background-color: none !important;
    margin-top: 20px;
  }    
}  
</style>
<main>
<div class="container mt-0">
  <div class="row">
    <?php
    if(isset($_GET['error'])) {
        echo '
        <div class="alert text-center alert-danger mb-0"
        style="margin-left: 60px; margin-right:60px;" role="alert">
        ';
        if($_GET['error'] === 'destless') {
            echo 'Dest. date/time is less than src.';
        } else if($_GET['error'] === 'sqlerr') {
            echo 'Database error';
        }
        echo '</div> ';
    }
    ?>
      <div class="bg-light form-out col-md-8">
      <h1 class="text-primary text-center">Add Flight</h1>

      <form id="test-form" action="#">

  
  <div class="input-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required />
 </div>
  
  <div class="input-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required />
  </div>
  
  <input type="submit" value="Submit" />
</form> 

      <form method="POST" class=" text-center" 
        action="../../includes/admin/flight.inc.php">

        <div class="form-row mb-4">
          <div class="col-md-3 p-0">
            <h5 class="mb-0 form-name">DEPARTURE</h5>
          </div>
          <div class="col">           
            <input type="date" name = "source_date" class="form-control"
            required >
          </div>
          <div class="col">         
            <input type="time" name = "source_time" class="form-control"
              required >
          </div>
        </div>


        <div class="form-row mb-4">
        <div class="col-md-3 ">
            <h5 class="form-name mb-0">ARRIVAL</h5>
          </div>          
          <div class="col">
            <input type="date" name = "dest_date" class="form-control"
            required >
          </div>
          <div class="col">
            <input type="time" name = "dest_time" class="form-control"
            required >
          </div>
        </div>

        <div class="form-row mb-4">
          <div class="col">
            <div class="input-group">
              <label for="dep_city">Departure city</label>
              <input class="form-contol" type="text" name="dep_city" id="dep_city" required />
            </div>                   
          </div>
          <div class="col">
            <div class="input-group">
              <label for="arr_city">Arrival city</label>
              <input type="text" name="arr_city" id="arr_city" required />
            </div>              
          </div>
        </div>

        <div class="form-row">
          <div class="col">
            <div class="input-group">
                <label for="dura">Duration</label>
                <input type="text" name="dura" id="dura" required />
              </div>              
            </div>            
          </div>
          <div class="col">
          <input type="number" name="price" placeholder="Enter price"
                  class="form-control form-input" required >
          </div>
          <?php
          $sql = 'SELECT * FROM Airline ';
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt,$sql);         
          mysqli_stmt_execute($stmt);          
          $result = mysqli_stmt_get_result($stmt);    
          echo '<select class="custom-select col-md-3 name="airline">
            <option selected>Select Airline</option>';
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value='. $row['airline_id']  .'>'. 
              $row['name'] .'</option>';
          }
        ?>
        </select>            
        </div>              

        <button name="flight_but" type="submit" 
          class="btn btn-primary w-25 mt-4">Submit</button>
      </form>
    </div>
    </div>
</div>
</main>
<script>
$(document).ready(function(){
  $('.input-group input').focus(function(){
    me = $(this) ;
    $("label[for='"+me.attr('id')+"']").addClass("animate-label");
  }) ;
  $('.input-group input').blur(function(){
    me = $(this) ;
    if ( me.val() == ""){
      $("label[for='"+me.attr('id')+"']").removeClass("animate-label");
    }
  }) ;
  // $('#test-form').submit(function(e){
  //   e.preventDefault() ;
  //   alert("Thank you") ;
  // })
});
</script>
<?php } ?>
