const profileButton = document.getElementById('profile-button');
const profileContent = document.getElementById('profile-content');

profileButton.addEventListener('mouseenter', () => {
    profileContent.style.display = 'block';
});

// profileButton.addEventListener('mouseleave', () => {
//     profileContent.style.display = 'none';
// });

document.addEventListener('click', (event) => {
    if (!event.target.closest('#profile-content') && !event.target.closest('#profile-button')) {
        profileContent.style.display = 'none';
    }
});