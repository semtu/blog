<?php include('includes/header.php'); ?>

<?php include('includes/navbar.php'); ?>

<div class="container py-5" >
    <div class="row py-3">

        <div class="col-md-8">
            <div class="card">
                <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(6).jpg" class="card-img-top" alt="...">
                <div class="card-body">
                <?php
                    require 'admin/database/dbconfig.php';

                    $query = "SELECT * FROM abouts";
                    $query_run= mysqli_query($connection, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                            
                            
                            
                            
                            
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <h6><?php echo $row['subtitle']; ?></h6>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <a href="<?php echo $row['links']; ?>" class="btn btn-primary">Goto getbootstrap.com</a>
                    <?php
                        }
                    }
                    else
                    {
                        echo "No Record Found";
                    }
                ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Notice</h5>
                    <p class="card-text">This is funda of web IT tutorials for creating a BLOG in PHP.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Notice</h5>
                    <p class="card-text">This is funda of web IT tutorials for creating a BLOG in PHP.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>