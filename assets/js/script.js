function formValidation(event){
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;


    const emailText = document.getElementById("emailText");
    const passwordText = document.getElementById("passwordText");

    
    const emailDiv = document.getElementById("emailDiv");
    const passwordDiv = document.getElementById("passwordDiv");

    let isValid = true;

    if(email.trim() === ""){
        emailText.textContent = "This field is required";
        emailText.style.color = "red";
        emailText.style.marginTop = "5px";
        emailText.style.fontSize = "12px";

        emailText.style.marginLeft = "20px";
        emailDiv.appendChild(emailText);
        isValid = false;
    
    }else{
        emailText.textContent = ""; //Clear error message
    }

    if(password.trim() === ""){
        passwordText.textContent = "This field is required";
        passwordText.style.color = "red";
        passwordText.style.marginTop = "5px";
        passwordText.style.fontSize = "12px";

        passwordText.style.marginLeft = "20px";
        passwordDiv.appendChild(passwordText);
        isValid = false;
    
    }else{
        passwordText.textContent = ""; //Clear error message
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if invalid
    }
    return isValid;
}