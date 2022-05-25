<?php
include('security.php');

if(isset($_POST['aboutbtn']))
{
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $links = $_POST['links'];

    $query = "INSERT INTO abouts (title,subtitle,description,links) VALUES ('$title','$subtitle','$description','$links')";
    $query_run = mysqli_query($connection, $query);
    
    if($query_run)
    {
        // echo "Saved";
        $_SESSION['status'] = "Added";
        $_SESSION['status_code'] = "success";
        header('Location: aboutus.php');
    }
    else 
    {
        $_SESSION['status'] = "Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: aboutus.php');  
    }

}

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $title = $_POST['edit_title'];
    $subtitle = $_POST['edit_subtitle'];
    $description = $_POST['edit_description'];
    $links = $_POST['edit_links'];

    $query = "UPDATE abouts SET title='$title', subtitle='$subtitle', description='$description', links='$links' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: aboutus.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: aboutus.php'); 
    }
}

if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM abouts WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: aboutus.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: aboutus.php'); 
    }    
}


if(isset($_POST['save_faculty']))
{
    $name = $_POST['faculty_name'];
    $designation = $_POST['faculty_designation'];
    $description = $_POST['faculty_description'];
    $images = $_FILES['faculty_image']['name'];

    $validate_img_extension = $_FILES['faculty_image']['type']=="image/jpg" ||
        $_FILES['faculty_image']['type']=="image/png" ||
        $_FILES['faculty_image']['type']=="image/jpeg"
    ;

    if($validate_img_extension)
    {
        if(file_exists("upload/" . $_FILES["faculty_image"]["name"]))
        {
            $store = $_FILES['faculty_image']['name'];
            $_SESSION['status']= "image already exists. '.$store.'";
            $_SESSION['status_code'] = "error";
            header('Location: faculty.php');
        }
        else
        {
            $query = "INSERT INTO faculty (name,designation,description,images) VALUES ('$name','$designation','$description','$images')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                move_uploaded_file($_FILES["faculty_image"]["tmp_name"],"upload/".$_FILES["faculty_image"]["name"]);
                $_SESSION['status'] = "Faculty Added";
                $_SESSION['status_code'] = "success";
                header('Location: faculty.php');
            }
            else 
            {
                $_SESSION['status'] = "Faculty Not Added";
                $_SESSION['status_code'] = "error";
                header('Location: faculty.php');  
            }
        }
    }
    else
    {
        $_SESSION['status'] = "Only PNG, JPG and JPEG Images are allowed";
        $_SESSION['status_code'] = "info";
        header('Location: faculty.php');
    }

}

if(isset($_POST['faculty_update_btn']))
{
    $edit_id = $_POST['edit_id'];
    $edit_name = $_POST['edit_name'];
    $edit_designation = $_POST['edit_designation'];
    $edit_description = $_POST['edit_description'];
    $edit_faculty_image = $_FILES['faculty_image']['name'];


    $facul_query = "SELECT * FROM faculty WHERE id='$edit_id' ";
    $facul_query_run = mysqli_query($connection, $facul_query);
    foreach($facul_query_run as $fa_row)
    {
        if($edit_faculty_image == NULL)
        {
            //Update with existing Image
            $image_data = $fa_row['images'];
        }
        else
        {
            //Update with new image and delete old image
            if($img_path = "upload/".$fa_row['images'])
            {
                unlink($img_path);
                $image_data = $edit_faculty_image;
            }
        }
    }

    $query = "UPDATE faculty SET name='$edit_name', designation='$edit_designation', description='$edit_description', images='$image_data' WHERE id='$edit_id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        if($edit_faculty_image == NULL)
        {
            //Update with existing Image
            $_SESSION['status'] = "Faculty is Updated with existing Image";
            $_SESSION['status_code'] = "success";
            header('Location: faculty.php');
        }
        else
        {
            //Update with new image and delete old image
            move_uploaded_file($_FILES["faculty_image"]["tmp_name"],"upload/".$_FILES["faculty_image"]["name"]);
            $_SESSION['status'] = "Your Data is Updated";
            $_SESSION['status_code'] = "success";
            header('Location: faculty.php'); 
        }
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: faculty.php'); 
    }
    
}

if(isset($_POST['search_data']))  //checkbox
{
    $id = $_POST['id'];
    $visible = $_POST['visible'];

    $query = "UPDATE faculty SET visible='$visible' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);
}

if(isset($_POST['delete_multiple_data']))
{
    $id = "1";

    $query = "DELETE FROM faculty WHERE visible='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Faculty Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: faculty.php'); 
    }
    else
    {
        $_SESSION['status'] = "Faculty Data is NOT DELETED"; 
        $_SESSION['status_code'] = "error";      
        header('Location: faculty.php'); 
    }    
}

if(isset($_POST['faculty_delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM faculty WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Faculty Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: faculty.php'); 
    }
    else
    {
        $_SESSION['status'] = "Faculty Data is NOT DELETED";
        $_SESSION['status_code'] = "error";       
        header('Location: faculty.php'); 
    }    
}
?>