function update_profile(){
    let first_name = get_first_name();
    let last_name = get_last_name();
    let date_of_birth = get_date_of_birth();
    let gender = get_gender();
    let phone = get_phone();
    let email = get_my_email_address();
    let address_line_1 = get_address_line_1();
    let address_line_2 = get_address_line_2();
    let city = get_city();
    let address_code = get_address_code();

    if(first_name == "" || last_name == "" || gender == "" || phone == "" || email == "" || address_line_1 == "" ||
      city == "" || address_code == "") return;
    let address = "&address=" + address_line_1 + "<br>" + address_line_2 + "<br>" + city + "<br>" + address_code;
    let data = "first_name=" + first_name + "&last_name=" + last_name + "&data_of_birth=" + date_of_birth;
    data +=  "&gender=" + gender + "&phone=" + phone + "&email=" + email + address;
    let url = "./server/update-profile.php?" + data;
    let loc = "#update_profile_response";
    send_data(url, displayer, loc, "", "", "#submit_changes");            
}        
function get_first_name(){
    let text = $("#first_name").val();
    let err = $("#err_first_name");
    let msg = "First name is required";
    return validate_text(text, err, msg);
}
function get_last_name(){
    let text = $("#last_name").val();
    let err = $("#err_last_name");
    let msg = "First name is required";
    return validate_text(text, err, msg);
}
function get_date_of_birth(){
    let text = $("#date_of_birth").val();
    let err = $("#err_date_of_birth");
    let msg = "Date of birth is required";
    let pattern = /^[a-zA-Z0-9\-]+$/;
    return validate_text(text, err, msg, pattern);
}
function get_gender(){
    let text = $("#gender").val();
    let err = $("#err_gender");
    let msg = "Gender is required";
    let pattern = /(M|F|O)/;
    return validate_text(text, err, msg, pattern);
}        
function get_phone(){
    let text = $("#phone").val();
    let err = $("#err_phone");
    let msg = "Phone number is required";
    let pattern = /\d{10}/;
    return validate_text(text, err, msg, pattern);
}
function get_my_email_address(){
    let email = $("#your_emaillast_name");
    let err = $("#err_your_email");
    let ms1 = "Email is required";
    let ms2 = "Unsupported email domain";
    let pattern = /^[a-zA-Z0-9\.]+\@+(gmail.com|icloud.com|outlook.com|yandex.mail|yahoo.com)+$/g;
    return get_email(email, err, ms1, ms2, pattern);
}
function get_address_line_1(){
    let text = $("#address_line_1").val();
    let err = $("#err_address_line_1");
    let msg = "Address line 1 is required";
    return validate_text(text, err, msg);
}
function get_address_line_2(){
    let text = $("#address_line_2").val();
    let err = $("#err_address_line_2");
    let msg = "";
    return (text != "") ? validate_text(text, err, msg) : "";
}
function get_city(){
    let text = $("#city").val();
    let err = $("#city");
    let msg = "City/Town is required";
    let pattern = /^[a-zA-Z0-9\-\s\']+$/;
    return validate_text(text, err, msg, pattern);
}
function get_address_code(){
    let text = $("#address_code").val();
    let err = $("#err_address_code");
    let msg = "Address code is required";
    let pattern = /\d{4}/;
    return validate_text(text, err, msg, pattern);
}

function validate_text(text, err, err_msg_1, pattern=""){
    pattern = (pattern == "") ? /^[a-zA-Z]+$/ : pattern;
    if(text == ""){
        err.html(err_msg_1);
        return "";
    }else if(!text.match(pattern)){
        err.html("Invalid use of special characters");
        return "";
    }else{
        err.html(" * ");
        return text;
    }
}