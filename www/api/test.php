<?php
    $maTask = "";
    if(isset($_GET['maTask'])){
        $maTask = $_GET['maTask'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang nhân viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/60364cba16.js" crossorigin="anonymous"></script>
</head>
<body>
    <ul id="list" class="list-group">

    </ul>
    <script>
        $(document).ready(function ()  {
            // đọc dữ liệu ngay khi tải trang xong
            let dulieu;
            // const xhr = new XMLHttpRequest();
            const url = 'get-file.php'
            const params = 'maTask='+encodeURI('KT1')
            // xhr.onreadystatechange = function() {
            //     if (xhr.readyState == XMLHttpRequest.DONE) {
            //            // window.location.reload()
            //
            //     }
            // }
            // xhr.open('GET', url + "?" + params, true);
            // xhr.send();
            $.get(`get-file.php?${params}`, function(data, status) {
                if(data.code == 0){
                    dulieu = data.data;
                    // console.log(dulieu);
                    for(let i = 0; i < dulieu.length; i++){
                        let tag = `
                         <li class="list-group-item">
                            ${split_name_file(dulieu[i].files)}
                            <p onclick="get_values_file('${split_name_file(dulieu[i].files)}','<?=$maTask?>', ${dulieu[i].id}, '${dulieu[i].files}')"
                                       class="btn btn-danger"
                                       data-toggle="modal" data-target="#deleteFile">X
                                    </p>
                          </li>
                    `;
                        $('#list').append(tag)
                    }
                }
            },"json");

            function split_name_file(name_file){
                const name_after = name_file.split("/")
                return name_after[1]
            }
        });
    </script>
</body>
</html>
