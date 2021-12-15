function paintComponent(component){
    component.style.border = "1px solid red";
    return false;
}
function dpaintComponent(component){
    if(component.style.border.length > 0){
        component.style.border = "";
    }
}
document.addEventListener("DOMContentLoaded",()=>{
    var name = document.getElementById("name");
    var day = document.getElementById("day");
    var month = document.getElementById("month");
    var year = document.getElementById("year");
    var email = document.getElementById("email");
    var password = document.getElementById("email");
    var cpassword = document.getElementById("confirm-password");
    
    validateForm = () => {
        var val = true;
        if(name.value.length == 0){
            val = paintComponent(name);
            val = false;
        }else{
            dpaintComponent(name);
        }
        if(day.value < 0 || day > 31){
            val = paintComponent(day);
            val = false;
        }else{
            dpaintComponent(day);
        }
        if(month.value == "Select a month"){
            val = paintComponent(month);
            val = false;
        }else{
            dpaintComponent(month)
        }
        if(year.value < 1900 && year.value > (new Date()).getFullYear()){
            val = paintComponent(year);
            val = false;
        }else{
            dpaintComponent(year);
        }
        if(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email.value)){
            dpaintComponent(email);
        }
        else{
            val = paintComponent(email);
            val = false;
        }
        if(password.value.length < 8){
            val = paintComponent(password);
            val = false;
        }else{
            dpaintComponent(password);
        }
        if(cpassword.value.length < 8){
            val = paintComponent(password);
            val = false;
        }else{
            dpaintComponent(password);
        }
        if(cpassword.value != password.value){
            paintComponent(password);
            val = paintComponent(cpassword);
            val = false;
        }else{
            dpaintComponent(password);
            dpaintComponent(cpassword);
        }
        return val;
    }
    document.getElementById("register").onsubmit = () => {validateForm()}
    lementById("submit").addEventListener("click",()=>{
        
    })

})