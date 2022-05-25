<?php
include('security.php');

if(isset($_POST['check_submit_btn'])) //live check email
{
    $email = $_POST['email_id'];
    $email_query = "SELECT * FROM register WHERE email='$email' ";
    $email_query_run = mysqli_query($connection, $email_query);
    if(mysqli_num_rows($email_query_run) > 0)
    {
        echo "Email Already Taken. Please Try Another one.";
    }
    else
    {
        echo "Available";
    }
}

if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];
    $trn_date = date("Y-m-d H:i:s");
    $usertype = $_POST['usertype'];

    $email_query = "SELECT * FROM register WHERE email='$email' ";
    $email_query_run = mysqli_query($connection, $email_query);
    if(mysqli_num_rows($email_query_run) > 0)
    {
        $_SESSION['status'] = "Email Already Taken. Please Try Another one.";
        $_SESSION['status_code'] = "error";
        header('Location: register.php');  
    }
    else
    {
        if($password === $cpassword)
        {
            $query = "INSERT INTO register (username,email,password,trn_date,usertype) VALUES ('$username','$email',md5($password),'$trn_date', '$usertype')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "Admin Profile Added";
                $_SESSION['status_code'] = "success";
                header('Location: register.php');
            }
            else 
            {
                $_SESSION['status'] = "Admin Profile Not Added";
                $_SESSION['status_code'] = "error";
                header('Location: register.php');  
            }
        }
        else 
        {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: register.php');  
        }
    }

}


if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];
    $usertypeupdate = $_POST['update_usertype'];
    $query= "UPDATE register SET username='$username', email='$email', password='$password', usertype='$usertypeupdate' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    }
}

if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM register WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    }    
}

if(isset($_POST['login_btn']))
{
    $email_login = $_POST['emaill']; 
    $password_login = $_POST['passwordd']; 

    $query = "SELECT * FROM register WHERE email='$email_login' AND password= md5($password_login) LIMIT 1";
    $query_run = mysqli_query($connection, $query);
    $usertypes = mysqli_fetch_array($query_run);

   if($usertypes['usertype'] == "admin")
   {
        $_SESSION['username'] = $email_login;
        header('Location: index.php');
   } 
   else if($usertypes['usertype'] == "user")
   {
        $_SESSION['username'] = $email_login;
        header('Location: ../index.php');
   }
   else
   {
        $_SESSION['status'] = "Email / Password is Invalid";
        $_SESSION['status_code'] = "error";
        header('Location: login.php');
   }
    
}

if(isset($_POST['dept_save']))
{
    $dept_name = $_POST['dept_name'];
    $dept_description = $_POST['dept_description'];
    $dept_image = $_FILES['dept_image']['name'];

    $validate_img_extension = $_FILES['dept_image']['type']=="image/jpg" ||
        $_FILES['dept_image']['type']=="image/png" ||
        $_FILES['dept_image']['type']=="image/jpeg"
    ;

    if($validate_img_extension)
    {
        if(file_exists("upload/departments/" . $_FILES["dept_image"]["name"]))
        {
            $store = $_FILES['dept_image']['name'];
            $_SESSION['status']= "image already exists. '.$store.'";
            $_SESSION['status_code'] = "error";
            header('Location: departments.php');
        }
        else
        {
            $query = "INSERT INTO dept_category (name,description,images) VALUES ('$dept_name','$dept_description','$dept_image')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                move_uploaded_file($_FILES["dept_image"]["tmp_name"],"upload/departments/".$_FILES["dept_image"]["name"]);
                $_SESSION['status'] = "Department Added";
                $_SESSION['status_code'] = "success";
                header('Location: departments.php');
            }
            else 
            {
                $_SESSION['status'] = "Department Not Added";
                $_SESSION['status_code'] = "error";
                header('Location: departments.php');  
            }
        }
    }
    else
    {
        $_SESSION['status'] = "Only PNG, JPG and JPEG Images are allowed";
        $_SESSION['status_code'] = "info";
        header('Location: departments.php');
    }

}

if(isset($_POST['dept_cate_update']))
{
    $updating_id = $_POST['updating_id'];
    $edit_name = $_POST['edit_name'];
    $edit_description = $_POST['edit_description'];
    $edit_dpt_cate_image = $_FILES['dpt_cate_image']['name'];

    $validate_img_extension = $_FILES['dpt_cate_image']['type']=="image/jpg" ||
        $_FILES['dpt_cate_image']['type']=="image/png" ||
        $_FILES['dpt_cate_image']['type']=="image/jpeg"
    ;

    $facul_query = "SELECT * FROM dept_category WHERE id='$updating_id' ";
    $facul_query_run = mysqli_query($connection, $facul_query);
    foreach($facul_query_run as $fa_row)
    {
        if($edit_dpt_cate_image == NULL)
        {
            //Update with existing Image
            $image_data = $fa_row['images'];
        }
        else
        {
            //Update with new image and delete old image
            if($img_path = "upload/departments/".$fa_row['images'])
            {
                unlink($img_path);
                $image_data = $edit_dpt_cate_image;
            }
        }
    }

    $query = "UPDATE dept_category SET name='$edit_name', description='$edit_description', images='$image_data' WHERE id='$updating_id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        if($edit_dpt_cate_image == NULL)
        {
            //Update with existing Image
            $_SESSION['status'] = "Department is Updated with existing Image";
            $_SESSION['status_code'] = "success";
            header('Location: departments.php');
        }
        else
        {
            //Update with new image and delete old image
            move_uploaded_file($_FILES["dpt_cate_image"]["tmp_name"],"upload/departments/".$_FILES["dpt_cate_image"]["name"]);
            $_SESSION['status'] = "Department Category is Updated";
            $_SESSION['status_code'] = "success";
            header('Location: departments.php'); 
        }
    }
    else
    {
        $_SESSION['status'] = "Department Category is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: departments.php'); 
    }

   
}

if(isset($_POST['dept_cate_deletebtn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM dept_category WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Department Category Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: departments.php'); 
    }
    else
    {
        $_SESSION['status'] = "Department Category Data is NOT DELETED";   
        $_SESSION['status_code'] = "error";    
        header('Location: departments.php'); 
    }    
}

if(isset($_POST['dept_catelist_save']))
{
    $dept_cate_id = $_POST['dept_cate_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $section = $_POST['section'];

    $query = "INSERT INTO dept_category_list (dept_cate_id,name,descrip,section) VALUES ('$dept_cate_id','$name','$description','$section')";
    $query_run = mysqli_query($connection, $query);
    
    if($query_run)
    {
        // echo "Saved";
        $_SESSION['status'] = "Dept Category-List is Added";
        $_SESSION['status_code'] = "success";
        header('Location: departments-list.php');
    }
    else 
    {
        $_SESSION['status'] = "Dept Category-List is Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: departments-list.php');  
    }

}

if(isset($_POST['dept_catelist_update']))
{
    $updateing_id = $_POST['updateing_id'];
    $dept_cate_id = $_POST['dept_cate_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $section = $_POST['section'];

    $query = "UPDATE dept_category_list SET dept_cate_id='$dept_cate_id', name='$name', descrip='$description', section='$section' WHERE id='$updateing_id' ";
    $query_run = mysqli_query($connection, $query); 

    if($query_run)
    {
        $_SESSION['status'] = "Dept Category-List is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: departments-list.php');
    }
    else
    {
        $_SESSION['status'] = "Dept Category-List is Not Updated";
        $_SESSION['status_code'] = "error";
        header('Location: departments-list.php');
    }
}

if(isset($_POST['dept_catelist_deletebtn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM dept_category_list WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Department Category-List is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: departments-list.php'); 
    }
    else
    {
        $_SESSION['status'] = "Department Category-List is NOT DELETED";   
        $_SESSION['status_code'] = "error";    
        header('Location: departments-list.php'); 
    }    
}
?>
