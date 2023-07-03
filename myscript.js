const urlParams = new URLSearchParams(window.location.search);
        const fromRedirect = urlParams.get('fromRedirect');
        if (fromRedirect === 'true') {
            const block = document.querySelector('.notin');
            block.style.display = 'block';
        }
        if (fromRedirect === 'false') {
            const block = document.querySelector('.notin2');
            block.style.display = 'block';
        }
        $(document).ready(function () {
            $(window).scroll(function () {
                $('.fade-in').each(function () {
                    var scroll = $(window).scrollTop();
                    var windowHeight = $(window).height();
                    var contentTop = $(this).offset().top;
                    if (scroll + windowHeight > contentTop) {
                        $(this).addClass('show-content');
                    }
                });
            });
        });
        window.onload = function () {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var jsonData = JSON.parse(xhr.responseText);
                    document.getElementById("mytitle").innerText = jsonData.title;
                    document.getElementById("mymotto").innerText = jsonData.motto;
                    document.getElementById("myvision").innerText = jsonData.vision;
                    document.getElementById("service-header").innerText = jsonData.serviceHeader;
                    document.getElementById("hero-image").src = jsonData.heroImage;
                    document.getElementById("service-img").src = jsonData.serviceImg;
                    document.getElementById("service-about").innerText = jsonData.serviceAbout;
                    document.getElementById("service1").innerText = jsonData.service1;
                    document.getElementById("service1-content").innerText = jsonData.service1C;
                    document.getElementById("service2").innerText = jsonData.service2;
                    document.getElementById("service2-content").innerText = jsonData.service2C;
                    document.getElementById("service3").innerText = jsonData.service3;
                    document.getElementById("service3-content").innerText = jsonData.service3C;
                    document.getElementById("service4").innerText = jsonData.service4;
                    document.getElementById("service4-content").innerText = jsonData.service4C;
                    document.getElementById("service5").innerText = jsonData.service5;
                    document.getElementById("service5-content").innerText = jsonData.service5C;
                    document.getElementById("about").innerText = jsonData.about;
                    document.getElementById("firstabout").innerText = jsonData.firstabout;
                    document.getElementById("secondabout").innerText = jsonData.secondabout;
                    document.getElementById("thirdabout").innerText = jsonData.thirdabout;
                    document.getElementById("forthabout").innerText = jsonData.forthabout;
                    document.getElementById("fifthabout").innerText = jsonData.fifthabout;
                    document.getElementById("secondabout-content").innerText = jsonData.secondaboutContent;
                    document.getElementById("thirdabout-content").innerText = jsonData.thirdaboutContent;
                    document.getElementById("forthabout-content").innerText = jsonData.forthaboutContent;
                    document.getElementById("fifthabout-content").innerText = jsonData.fifthaboutContent;
                    document.getElementById("firstabout-content").innerText = jsonData.firstaboutContent;
                    document.getElementById("opportunity").innerText = jsonData.opportunity;
                    document.getElementById("opportunity1").innerText = jsonData.opportunity1;
                    document.getElementById("opportunity2").innerText = jsonData.opportunity2;
                    document.getElementById("opportunity3").innerText = jsonData.opportunity3;
                    document.getElementById("opportunity4").innerText = jsonData.opportunity4;
                    document.getElementById("opportunity1-content").innerText = jsonData.opportunity1Content;
                    document.getElementById("opportunity2-content").innerText = jsonData.opportunity2Content;
                    document.getElementById("opportunity3-content").innerText = jsonData.opportunity3Content;
                    document.getElementById("opportunity4-content").innerText = jsonData.opportunity4Content;
                    document.getElementById("about-iba").innerText = jsonData.aboutiba;
                    document.getElementById("facebook").href = jsonData.facebook;
                    document.getElementById("instagram").href = jsonData.instagram;
                    document.getElementById("twitter").href = jsonData.twitter;
                    document.getElementById("linkedin").href = jsonData.linkedin;
                    document.getElementById("telephone1").href = jsonData.telephone1;
                    document.getElementById("telephone1").innerText = jsonData.telephonetext1;
                    document.getElementById("telephone2").href = jsonData.telephone2;
                    document.getElementById("telephone2").innerText = jsonData.telephonetext2;
                    document.getElementById("telephone3").href = jsonData.telephone3;
                    document.getElementById("telephone3").innerText = jsonData.telephonetext3;
                    document.getElementById("telephone4").href = jsonData.telephone4;
                    document.getElementById("telephone4").innerText = jsonData.telephonetext4;
                    document.getElementById("mail").href = jsonData.mail;
                    document.getElementById("mail").innerText = jsonData.mailtext;
                    document.getElementById("address1").innerText = jsonData.address1;
                    document.getElementById("address2").innerText = jsonData.address2;

                }};
            xhr.open("GET", "./json/content.json", true);
            xhr.send();
        };



        document.getElementById("subscriptionForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./mail/sendmail.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    document.getElementById("subscriptionForm").reset();
                }
                else {
                    alert("You may have subscribed already");
                }
            };
            xhr.send(new FormData(event.target));
        });