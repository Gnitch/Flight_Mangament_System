<?php
if(isset($_POST['login_but'])) {
    require '../helpers/init_conn_db.php';   
    $email_id = $_POST['user_id'];
    $password = $_POST['user_pass'];
    $sql = 'SELECT * FROM Users WHERE username=? OR email=?;';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header('Location: ../views/index.php?error=sqlerror');
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'ss',$email_id,$email_id);            
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)) {
            $pwd_check = password_verify($password,$row['password']);
            if($pwd_check == false) {
                header('Location: ../views/index.php?error=wrongpwd');
                exit();    
            }
            else if($pwd_check == true) {
                session_start();
                $_SESSION['userId'] = $row['user_id'];
                $_SESSION['userUid'] = $row['username'];
                header('Location: ../views/index.php?login=success');
                exit();                  
            } else {
                header('Location: ../views/index.php?error=invalidcred');
                exit();                    
            }
        }
    }

} else {
    header('Location: ../views/index.php');
    exit();  
}    