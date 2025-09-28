document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('#delete-btn');
    const modalOverlay = document.getElementById('deleteModal');
    const acceptButton = document.getElementById('acceptButton');
    const declineButton = document.getElementById('declineButton');
    const customerIdInput = document.querySelector('input[name="customerID"]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            // Get the CustomerID from the row within the table
            const customerId = e.target.closest('tr').querySelector('td:first-child').textContent;
            
            // Update the hidden input field with the CustomerID
            customerIdInput.value = customerId;
            
            // Show the modal as flex
            modalOverlay.style.display = 'flex';
        });
    });

    
    declineButton.addEventListener('click', () => {
        // Hide the modal
        modalOverlay.style.display = 'none';
    });

    
    acceptButton.addEventListener('click', () => {
        // The form submission is handled by the form's action attribute
        // No additional JavaScript is needed for the submission
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('#edit-btn');
    const editModal = document.getElementById('editModal');
    const cancelEditButton = document.getElementById('cancelEditButton');
    const editCustomerIdInput = document.getElementById('editCustomerID');
    const editNameInput = document.getElementById('editName');
    const editEmailInput = document.getElementById('editEmail');
    const editPhoneInput = document.getElementById('editPhone');

    // Edit button event listeners
    editButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            const customerId = row.querySelector('td:nth-child(1)').textContent;
            const name = row.querySelector('td:nth-child(2)').textContent;
            const email = row.querySelector('td:nth-child(3)').textContent;
            const phone = row.querySelector('td:nth-child(4)').textContent;

            // Populate edit form fields
            editCustomerIdInput.value = customerId;
            editNameInput.value = name;
            editEmailInput.value = email;
            editPhoneInput.value = phone;

            // Show edit modal
            editModal.style.display = 'flex';
        });
    });

    // Cancel button for edit modal
    cancelEditButton.addEventListener('click', () => {
        editModal.style.display = 'none';
    });
});