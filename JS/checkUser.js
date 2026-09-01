function CheckUser()
{
    let username=document.getElementById("name").value.trim();

    let response=document.getElementById("userresponse");

    let xhttp=new XMLHttpRequest();

    xhttp.onreadystatechange=function()
    {
        if(this.readyState==4 && this.status==200)
        {
            response.innerHTML=this.responseText;
        }
    }

    xhttp.open("POST","checkuser.php",true);

    xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");

    xhttp.send("username="+encodeURIComponent(username));
}

function CheckEmail()
{
    let email=document.getElementById("email").value.trim();

    let response=document.getElementById("emailresponse");

    let xhttp=new XMLHttpRequest();

    xhttp.onreadystatechange=function()
    {
        if(this.readyState==4 && this.status==200)
        {
            response.innerHTML=this.responseText;
        }
    }

    xhttp.open("POST","checkuser.php",true);

    xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");

    xhttp.send("email="+encodeURIComponent(email));
}