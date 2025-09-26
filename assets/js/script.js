let deleteButton = document.getElementById("delete-btn");

deleteButton.addEventListener(() =>{
    document.getElementById("deleteModal").style.display = 'flex';
});

function accecptDelete(){
    document.getElementById("deleteModal").style.display = 'none';
}

function declineDelete(){
    document.getElementById("deleteModal").style.display = 'none';
}