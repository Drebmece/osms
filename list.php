<li><a href="">発表する</a></li>
            <li><a href="">ユーザーを追加する</a></li>
            <li><a href="">コースを追加する</a></li>
            <li><a href="">科目を追加する</a> </li>
            <li><a href="">ユーザーを表示する</a> </li>
            <li><a href="">コースのリストを表示する</a> </li>
            <li><a href="">学生のリストを表示する</a> </li>
            <li><a href="">支払いのリスト</a> </li>
            <li><a href="">バックアップする</a> </li>
            <li><a href="">レストアする</a> </li>


            <input type="radio" name="same" id="r1">
        <input type="radio" name="same" id="r2">
        <div class="wrapper">
            <div class="container">
                <label for="r1" class="fas fa-bars" id="bars"></label>
                <label for="r2" class="fas fa-times" id="times"></label>
                <div class="outer">
                    <div class="logo"><img src="img/<?php echo $row['profile']?>" alt=""></div>
                    <div class="myName"><?php echo $row['last_name']?></div>
                    <div class="myName"><?php echo $row['first_name']?></div>
                </div>

                <ul>
                    <li><a href="#">Dashboard</a></li>

                    <li id="toggle1"><a href="#">Category<span class="fas fa-caret-down" id="arrow1"></span></a></li>
                        <li id="nested1"><a href="#">HTML Tutorials</a></li>
                        <li id="nested2"><a href="#">CSS Tutorials</a></li>

                    <li id="toggle2"><a href="#">Features<span class="fas fa-caret-down" id="arrow2"></span></a></li>
                        <li id="nested3"><a href="#">Updates</a></li>
                        <li id="nested4"><a href="#">Older ver.</a></li>


                    <li><a href="#">Contacts</a></li>
                    <li><a href="#">learn More</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </div>
            <div class="main-container">
                <div class="card">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
                <div class="card">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
                <div class="card">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        let toggle1 = document.querySelector("#toggle1");
        let toggle2 = document.querySelector("#toggle2");
        let nested1 = document.querySelector("#nested1");
        let nested2 = document.querySelector("#nested2");
        let nested3 = document.querySelector("#nested3");
        let nested4 = document.querySelector("#nested4");
        let arrow1 = document.querySelector("#arrow1");
        let arrow2 = document.querySelector("#arrow2");

        toggle1.addEventListener('click',()=>{
            if(nested1.style.display == "block" || nested2.style.display == "block"){
                nested1.style.display = "none";
                nested2.style.display = "none";
                arrow1.style.transform = "rotate(0deg)";
                arrow1.style.color = "#fff";
                arrow1.style.textShadow = "none";
            }else{
                nested1.style.display = "block";
                nested2.style.display = "block";
                arrow1.style.transform = "rotate(180deg)";
                arrow1.style.color = "#12fff1";
                arrow1.style.textShadow = "0 0 5px #12fff1";
            }
        });

        toggle2.addEventListener('click',()=>{
            if(nested3.style.display == "block" || nested4.style.display == "block"){
                nested3.style.display = "none";
                nested4.style.display = "none";
                arrow2.style.transform = "rotate(0deg)";
                arrow2.style.color = "#fff";
                arrow2.style.textShadow = "none";
            }else{
                nested3.style.display = "block";
                nested4.style.display = "block";
                arrow2.style.transform = "rotate(180deg)";
                arrow2.style.color = "#12fff1";
                arrow2.style.textShadow = "0 0 5px #12fff1";
            }
        });
    
    </script>