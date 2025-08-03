function submit()
{
    var fname = document.getElementById(fname);
    var lname = document.getElementById(lname);
    var address = document.getElementById(address);
    var city = document.getElementById(city);
    var state = document.getElementById(state);
    var phone = document.getElementById(phone);
    var email = document.getElementById(email);

    if (fname ===""||lname ===""||address ===""||city ===""||state === ""||phone === ""|| email ==="")
    {
        alert("please fill out the full form")
    }
}