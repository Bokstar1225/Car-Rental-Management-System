let deleteButton = document.getElementById("delete-btn");

deleteButton.addEventListener(() =>{
    fetch(".users.php").then(response => response.text()).then(data =>{
        document.getElementById("deleteModal").style.display = data + "flex";
    })
});

function accecptDelete(){
    document.getElementById("deleteModal").style.display = 'none';
}

function declineDelete(){
    document.getElementById("deleteModal").style.display = 'none';
}