<?php
session_start();

// biến mảng chứa lỗi
$errors = [];
// gán mặc định
$studentHo = $studentTen = $studentGt ="";

// có dữ liệu submit đi hay không
if (isset($_POST) & !empty($_POST)) {
    // bắt đầu validate
    if(!isset($_POST["first_name"]) || empty($_POST["first_name"])) {
        $errors["first_name"] = "Bắt buộc phải nhập họ";
    } else {
        // có nhập dữ liệu
        // cách 1
        /*$studentName = trim($_POST["name"]);
        $studentNameArr = explode(" ", $studentName);
        $studentNameLength = count($studentNameArr);
        var_dump($studentNameLength);*/

        // cách 2
        $studentHo = trim($_POST["ho"]);
        $patternStudentHo = "/^([A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ])/";


        $studentHoValidate = preg_match_all($patternStudentHo, $studentHo, $matches);
        // $studentNameValidate bằng 0 , null , false

        if (!$studentHoValidate) {
            $errors["ho"] = "Bắt buộc phải nhập họ";
        }

    }

    if(!isset($_POST["last_name"]) || empty($_POST["last_name"])) {
        $errors["last_name"] = "Bắt buộc phải nhập tên";
    } else {

        $studentTen = trim($_POST["last_name"]);
        $patternStudentTen = "/^([A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ])/";


        $studentTenValidate = preg_match_all($patternStudentTen, $studentTen, $matches);
        // $studentNameValidate bằng 0 , null , false

        if (!$studentTenValidate) {
            $errors["last_name"] = "Tên không đúng";
        }
    }

    if(!isset($_POST["gender"]) || empty($_POST["gender"])) {
        $errors["gender"] = "Bắt buộc phải nhập giới tính";
    } else {
        $studentGt = (int) $_POST["gender"];
        if (!in_array($studentGt, [1,2])) {
            $errors["gender"] = "giới tính của không đúng";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        * {
            box-sizing: border-box;
        }

        body{
            background-image: url("bg.4b97638c.jpg");

        }
        input[type="text"] {
            width: 150px;
            height: 50px;
        }
        select {
            width: 110px;
            height: 50px;
        }
        
    </style>
</head>
<body> 
    <div class="loading" id="loading">
        <p class="loading-text">
           Loading .....   
       </p>

   </div>
   <form id="form" action="test.php" method="post" name="data">
    <div class="container">
        <h2 style="text-align:center;color:#BB8B31;padding: 60px">NHẬP GIỮ LIỆU</h2>
        <div><span style="color:red">*Chú ý: </span> Để bắt đầu tìm hiểu về con, bố/mẹ hãy nhập những thông tin dưới đây thât chính xác.</div>
        <div class="row">
            <div class="col-md-6">
                <p style="color: #BB8B31; font-size: 20px;">Thông tin con :</p></div>
                <div class="col-md-6">
                    <p style="color: #BB8B31; font-size: 20px;">Giới Tính :</p></div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <input type="text" placeholder="Họ" name="first_name" value="<?php echo $studentHo ?>" autocomplete="off">
                        <?php
                        if (isset($errors["first_name"]) && $errors["first_name"]) {
                            echo "<p style='color:red'>".$errors["first_name"]."</p>";
                        }
                        ?>
                    </div>

                    <div class="col-md-2">

                        <input type="text" placeholder="Tên Đệm" name="middle_name">

                    </div>

                    <div class="col-md-2">

                        <input type="text" placeholder="Tên"name="last_name">
                        <?php
                        if (isset($errors["last_name"]) && $errors["last_name"]) {
                            echo "<p style='color:red'>".$errors["last_name"]."</p>";
                        }
                        ?>
                    </div>

                    <div class="col-md-6"> 

                        <input type="radio" value="1" name="gender" <?php echo ($studentGt === 1) ? "checked" : "" ?>>Nam
                        <i class="fa fa-venus" aria-hidden="true"></i>

                        <input type="radio" value="0" name="gender" <?php echo ($studentGt === 2) ? "checked" : "" ?>>Nữ
                        <i class="fa fa-mars" aria-hidden="true"></i>

                        <?php
                        if (isset($errors["gender"]) && $errors["gender"]) {
                            echo "<p style='color:red'>".$errors["gender"]."</p>";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p style="color: #BB8B31; font-size: 20px;">Thời điểm chào đời :</p>
                    </div>
                    <div class="col-md-6">
                        <p style="color: #BB8B31; font-size: 20px;">Sinh nhật :</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <select name="hour" id="">
                            <option value=""  >Giờ</option>
                            <?php 
                            for($gio = 0; $gio <= 23; $gio++) {
                                echo "<option> $gio Giờ </option>";
                            }
                            ?>

                        </select>
                        <select name="minute" id="">
                            <option value="">Phút</option>
                            <?php
                            for($phut = 0; $phut <= 59; $phut++){
                                echo "<option> $phut Phút</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">


                        <select name="day" id="">
                            <option value="">Ngày sinh</option>
                            <?php
                            for($ngay = 1; $ngay <= 31; $ngay++ ){
                                echo "<option> Ngày $ngay </option>";
                            } 
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="month" id="">
                            <option value=""> Tháng </option>
                            <?php 
                            for($thang=1;$thang<=12;$thang++){
                                echo "<option> Tháng $thang</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="year" id="">
                            <option value="">Năm</option>
                            <?php 
                            for($nam=2021;$nam>=1930;$nam--){
                                echo "<option> Năm $nam</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <p style="color: #BB8B31; font-size: 20px;">Chế độ lịch :<p>
                    <div class="row">
                        <div class="col">
                            <input type="radio" value="0" name="calendar" checked>Dương Lịch
                            <input type="radio" value="1" name="calendar">Âm Lịch
                        </div>
                    </div>
                    <div>
                        <input id="submit" name="submit" type="submit" value="Tiến Hành Luận Giải" style="background-color:#7D5F2F; color:white; border-radius:20px; font-size:20px">
                    </div>
                </div>
            </form>
            <style type="text/css">
                .loading{
                    display: none;
                    position: fixed;
                    z-index: 555;
                    opacity: 70%;
                    width: 100vw;
                    height: 100vh;
                    background: pink;
                }
                .loading-text{
                    padding: 20% 40% 20% 40%;
                    font-size: 30px;

                }
            </style>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script>
                function getFormData($form){
                    var unindexed_array = $form.serializeArray();
                    var indexed_array = {};

                    $.map(unindexed_array, function(n, i){
                        indexed_array[n['name']] = n['value'];
                    });

                    return indexed_array;
                }
                $(document).ready(function(){
        // click on button submit
        
        $("#submit").on('click', function(e){
            e.preventDefault();
            $("#loading").css("display", "block");
            var formSubmit = getFormData($("#form"));
            $.ajax({
                url: 'test.php', // url where to submit the request
                data :formSubmit, // post data || get data
                success : function(result) {
                    // you can see the result from the console
                    // tab of the developer tools
                    $("#loading").css("display", "none");;
                   if(result)
                    window.location.href  = result;
                },
                error: function(xhr, resp, text) {
                    $("#loading").css("display", "none");
                    console.log(xhr, resp, text);
                }
            })
        });
        });

    </script>

</body>
</html>