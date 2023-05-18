<?php
$dsn = "mysql:host=localhost;charset=utf8;dbname=store";
$pdo = new PDO($dsn, "root", '');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header id="header">
        <h1>MENU</h1>
        <select id="type" onchange="typeFun()">
            <option value="0">內用</option>
            <option value="1">外帶</option>
        </select>
    </header>
    <div id="checkoutDiv">
        <div class="background">
            <div>
            <button type="button" onclick="closeF()" id="closeBtn">x</button>
            <span>總計：</span><span id="checkout"></span><span>元</span>
            </div>
            <div id="discount">
            <span>優惠價：</span>
            <span id="discountCheckout"></span>
            <span>元</span>
            </div>
        </div>
    </div>
    <marquee behavior="" direction="">滿300元享8折優惠</marquee>
    <table>
        <tr>
            <td>品項</td>
            <td>品名</td>
            <td>照片</td>
            <td>價格</td>
            <td>數量</td>
            <td>小計</td>
        </tr>

    <?php
        $sql = "select `name`,`file_name`,`price` from `drink`";
        $rows = $pdo->query($sql)->fetchAll();
        $n = 1;
        foreach ($rows as $row) {
    ?>

            <tr>
                <td><?= $n ?></td>
                <td><?= $row['name'] ?></td>
                <td><img src="<?= $row['file_name'] ?>" alt=""></td>
                <td class="price"><?= $row['price'] ?></td>
                <td>
                    <input type="number" name="number" class="number" onchange="sum()" value="0" min="0">
                </td>
                <td class="sum">0</td>
            </tr>

    <?php
        $n++;
        }
    ?>

    </table>
    <div class="here">
        
        <div>
            <span>總計:</span>
            <span id="total">0</span>
            <span>元</span>
        </div>
        <button type="button" onclick="checkoutFun()">結帳</button>
    </div>

    <div id="hidden">

    <?php
        $sql = "select count(*) from `drink`";
        echo $pdo->query($sql)->fetch()[0];
    ?>

    </div>
    <script>
        function sum() {
            total.innerText = 0;
            for (i = 0; i < count; i++) {
                if(Number(num[i].value)<0){
                    num[i].value=0;
                }
                num[i].value=parseInt(num[i].value);
                sums[i].innerText = Number(prices[i].innerText) * Number(num[i].value);
            }
            for (i = 0; i < count; i++) {
                total.innerText = Number(total.innerText) + Number(sums[i].innerText);
            }
        }

        function closeF() {
            checkoutDiv.style.display = "none";
        }

        function checkoutFun() {
            if(Number(total.innerText)!=0){
            checkoutDiv.style.display = "block";
            checkout.innerText = total.innerText;
            if(Number(checkout.innerText)>=300){
                discount.style.display="block";
                discountCheckout.innerText=Number(checkout.innerText)*0.8;
            }else{
                discount.style.display="none";
            }
            }
        }
        function typeFun(){
            if(type.value==0){
                document.getElementById("header").style.backgroundColor="lightpink";
            }else{
                document.getElementById("header").style.backgroundColor="lightblue";
            }
        }
        let checkoutDiv = document.getElementById("checkoutDiv");
        let checkout = document.getElementById("checkout");
        let num = document.getElementsByClassName("number");
        let prices = document.getElementsByClassName("price");
        let sums = document.getElementsByClassName("sum");
        let total = document.getElementById("total");
        let count = document.getElementById("hidden").innerText;
        let discount=document.getElementById("discount");
        let discountCheckout=document.getElementById("discountCheckout");
        let type=document.getElementById("type");
    </script>
</body>

</html>