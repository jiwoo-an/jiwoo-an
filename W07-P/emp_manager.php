<?php
    $link = mysqli_connect('localhost', 'admin', 'admin', 'employees');

    if(mysqli_connect_errno()){
        echo "Failed to connect to MariaDB: " . mysqli_connect_error();
        exit();
    }    

    settype($_GET['number'], 'integer');
    $filtered_number = mysqli_real_escape_string($link, $_GET['number']);
    
    $query = "
        SELECT d.dept_name, e.emp_no, e.first_name, e.last_name, e.hire_date
        FROM employees e
        INNER JOIN dept_manager dm
        ON dm.emp_no = e.emp_no   
        INNER JOIN departments d
        ON d.dept_no = dm.dept_no
    ";

    $result = mysqli_query($link, $query);  
    
    $article = '';    
    while($row = mysqli_fetch_array($result)){
        $article .= '<tr><td>';
        $article .= $row["dept_name"];
        $article .= '</td><td>';
        $article .= $row["emp_no"];
        $article .= '</td><td>';
        $article .= $row["first_name"];
        $article .= '</td><td>';
        $article .= $row["last_name"];
        $article .= '</td><td>';
        $article .= $row["hire_date"];
        $article .= '</td></tr>';
    }
    
    mysqli_free_result($result);
    mysqli_close($link);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>부서별 매니저 정보</title>
    <style>
        body {
            font-family: Consolas, monospace;
            font-family: 12px;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #dadada;
        }
    </style>
</head>

<body>
    <h2><a href="index.php">직원 관리 시스템</a> | 부서별 매니저 정보</h2>
    <table>
        <tr>
            <th>dept_name</th>
            <th>emp_no</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>hire_date</th>
        </tr>        
        <?= $article ?>
    </table>
</body>

</html>
