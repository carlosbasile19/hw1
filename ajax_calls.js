const deleteButtonsDiaries = document.querySelectorAll('.delete-button-diary');
const deleteButtonsEntries = document.querySelectorAll('.delete-button-entry');
const favoriteButtons = document.querySelectorAll('.favorite-button');

function getFavoriteStatus(entry_id) {
    const url = `get_entry_favorite_status.php?entry_id=${entry_id}`;
  
    return fetch(url)
      .then(response => response.json())
      .then(data => data.status)
      .catch(error => console.error(error));
  }


deleteButtonsDiaries.forEach((deleteButton) => {
    deleteButton.addEventListener('click', async (event) => {

        event.preventDefault();

        const diaryId = deleteButton.dataset.diaryId;
        const userId = deleteButton.dataset.user;

       
        // Send a POST request to the server using AJAX
        try {
            const response = await fetch('http://localhost/HOMEWORK/delete_diary.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // add this line
                },
                body: JSON.stringify({
                    diary_id: diaryId,
                    user_id: userId
                })
            });

            if (response.ok) {
                const diaryRow = deleteButton.closest('.diary-row');
                diaryRow.parentElement.removeChild(diaryRow);

                const diariesContainer = document.querySelector('.diaries-container');

                if(diariesContainer.children.length == 1){
                    const noDiaries = document.createElement('p');
                    noDiaries.textContent = "There are no diaries yet! Add them.";
                    diariesContainer.appendChild(noDiaries);
                }
            } else {
                console.error("Error calling");
            }
        } catch (error) {
            console.error(`Network error: ${error.message}`);
        }
    });
});

deleteButtonsEntries.forEach((deleteButton) => {
    deleteButton.addEventListener('click', async (event) => {

        event.preventDefault();
        
        const user_id = deleteButton.dataset.user;
        const entry_id = deleteButton.dataset.entry;
        const diary_id = deleteButton.dataset.diary;
        const redirect = deleteButton.dataset.redirect;

        // Send a POST request to the server using AJAX
        try {
            const response = await fetch('http://localhost/HOMEWORK/delete_entry.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // add this line
                },
                body: JSON.stringify({
                    diary_id: diary_id,
                    user_id: user_id,
                    entry_id: entry_id
                })
            });

            if(redirect == 1){
                return window.location.href = "http://localhost/HOMEWORK/entries.php?diary_id=" + diary_id;
            }

            if (response.ok) {
                const entryRow = deleteButton.closest('.entry');
                entryRow.parentElement.removeChild(entryRow);
                
                const entriesContainer = document.querySelector('.entries-container');
                if(entriesContainer.children.length == 0){
                    const noEntries = document.createElement('p');
                    noEntries.textContent = "There are no entries yet! Add them.";
                    entriesContainer.appendChild(noEntries);
                }

            } else {
                console.error("Error calling");
            }
        } catch (error) {
            console.error(`Network error: ${error.message}`);
        }
    });
});

// Favorite button main visibility

favoriteButtons.forEach((favoriteButton) => {

    const entryId = favoriteButton.dataset.entry;

    getFavoriteStatus(entryId)
                    .then(status => {
                         if (status === 'favorite') {
                             favoriteButton.textContent = 'Remove from favorites';
                         } else if (status === 'not favorite') {
                                 favoriteButton.textContent = 'Add to favorites';
                         } else {
                                  favoriteButton.textContent = 'Error: ' + status;
                         }
    })
    .catch(error => console.error(error));

});

// Favorite button click (for changing status)

favoriteButtons.forEach((favoriteButton) => {

    favoriteButton.addEventListener('click', async (event) => {

        event.preventDefault();
        
        const user_id = favoriteButton.dataset.user;
        const entry_id = favoriteButton.dataset.entry;
       
        // Send a POST request to the server using AJAX
        try {
            const response = await fetch('http://localhost/HOMEWORK/add_remove_favorite_entry.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    entry_id: entry_id,
                    user_id: user_id
                })
            });
             
            const entryId = favoriteButton.dataset.entry;

            if (response.ok) {
                getFavoriteStatus(entryId)
                    .then(status => {
                         if (status === 'favorite') {
                             favoriteButton.textContent = 'Remove from favorites';
                         } else if (status === 'not favorite') {
                                 favoriteButton.textContent = 'Add to favorites';
                         } else {
                                  favoriteButton.textContent = 'Error: ' + status;
                         }
    }).catch(error => console.error(error));

            } else {
                console.error("Error calling");
            }
        } catch (error) {
            console.error(`Network error: ${error.message}`);
        }
    });
});

