function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

$(document).ready(function(){

    $(".barbutton").click(function(){
        document.cookie = "currenttag="+ "ALL";
        document.cookie = "pretag="+ "ALL";
    });

    $(".collapsible").click(function(){
        $(this)[0].classList.toggle("active");
        var content = $(this)[0].nextElementSibling;
        if (content.style.maxHeight){
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
    
    $(".tagbutton").click(function() {
        var newtag = $(this).text();
        var site = window.location.href.split("?")[0];
        location.href = site + "?currenttag="+newtag;
    });

    $(".autherbutton").click(function() {
        var newauther = $(this).text();
        var site = window.location.href.split("?")[0];
        location.href = site + "?currentauther="+newauther;
    });

    $(".pagebutton").click(function(){
        var newpage = $(this).text();
        //console.log(newpage);
        var site = window.location.href.split("?")[0];
        location.href = site + "?currentpage="+newpage;
    });

    $(".playgif").hover(
        function(){
            var site =  $(this).attr("src");
            $(this).attr("src", site.replace("jpg","gif"));
        },
        function(){
            var site =  $(this).attr("src");
            $(this).attr("src", site.replace("gif","jpg"));
        }
    );

});
