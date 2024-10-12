const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener('click', () => {
    console.log('Nút người dùng đã được nhấp!');
    const userBox = document.querySelector('.profile-detail');
    userBox.classList.toggle('active');
});

const toggle = document.querySelector('.toggle-btn');
toggle.addEventListener('click', () => {
    console.log('Nút chuyển đổi đã được nhấp!');
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
});
