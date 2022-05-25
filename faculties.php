<?php include('includes/header.php'); ?>

<?php include('includes/navbar.php'); ?>

<div class="container py-5" >
    <div class="row mt-3">
        <div class = "col-md-12">
            <h1 class="text-center"> Faculty Details </h1> 
        </div>
    </div> 
    <div class="row mt-4">  
        <?php
        require 'admin/database/dbconfig.php';

        $query = "SELECT * FROM faculty";
        $query_run= mysqli_query($connection, $query);
        $check_faculty = mysqli_num_rows($query_run) > 0;

        if($check_faculty)
        {
            while($row = mysqli_fetch_array($query_run))
            {
                ?>
                <div class="col-md-3 mt-3">
                    <div class="card">
                        <img src="admin/upload/<?php echo $row['images'] ?>" width="255px" height="200px" alt="Faculty Images">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row['name']; ?></h4>
                            <h3 class="card-title"><?php echo $row['designation']; ?></h3>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else
        {
            echo "No Faculty Found";
        }
        ?>  
                
    </div>
</div>

<?php include('includes/footer.php'); ?>