document.addEventListener('DOMContentLoaded', () => {
    // Lấy phần tử .profile-detail
    let profile = document.querySelector('.header .flex .profile-detail');

    // Lấy phần tử #user-btn và gán sự kiện click
    document.querySelector('#user-btn').onclick = () => {
        console.log("Nút người dùng");
        if (profile.style.display === 'block') {
            profile.style.display = 'none'; // Ẩn phần tử
        } else {
            profile.style.display = 'block'; // Hiển thị phần tử
        }
        profile.classList.toggle('active'); // Thay đổi lớp 'active' cho phần tử profile
        searchForm.classList.remove('active'); // Xóa lớp 'active' khỏi phần tử searchForm
    };

    // Lấy phần tử .search-form
    let searchForm = document.querySelector('.header .flex .search-form');

    // Lấy phần tử #search-btn và gán sự kiện click
    document.querySelector('#search-btn').onclick = () => {
        console.log("Nút tìm kiếm");
        searchForm.classList.toggle('active'); // Thay đổi lớp 'active' cho phần tử searchForm
        profile.classList.remove('active'); // Xóa lớp 'active' khỏi phần tử profile
    };

    // Lấy phần tử .navbar
    let navbar = document.querySelector('.navbar');

    // Lấy phần tử #menu-btn và gán sự kiện click
    document.querySelector('#menu-btn').onclick = () => {
        console.log("Nút menu");
        navbar.classList.toggle('active'); // Thay đổi lớp 'active' cho phần tử navbar
    };
});

// Lấy phần tử chứa slider và các slide
const imgBox = document.querySelector('.slider-container');
const slides = document.getElementsByClassName('slideBox');
var i = 0; // Khởi tạo biến i

// Hàm chuyển đến slide tiếp theo
function nextSlide() {
    slides[i].classList.remove('active'); // Xóa lớp 'active' khỏi slide hiện tại
    i = (i + 1) % slides.length; // Tăng chỉ số i, quay lại 0 nếu vượt quá số lượng slide
    slides[i].classList.add('active'); // Thêm lớp 'active' vào slide mới
}

// Hàm chuyển đến slide trước
function prevSlide() {
    slides[i].classList.remove('active'); // Xóa lớp 'active' khỏi slide hiện tại
    i = (i - 1 + slides.length) % slides.length; // Giảm chỉ số i, quay lại slide cuối nếu i < 0
    slides[i].classList.add('active'); // Thêm lớp 'active' vào slide mới
}


/*----------------------------------------*/
var btn = document.querySelectorAll('.indicator .btn1');
var slide = document.getElementById('slide');
// Đặt sự kiện onclick cho các nút
btn[0].onclick = function () {
    slide.style.transform = 'translateX(0px)';
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
};

btn[1].onclick = function () {
    slide.style.transform = 'translateX(-800px)';
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
};

// Lặp lại cho các nút 2 và 3
btn[2].onclick = function () {
    slide.style.transform = 'translateX(-2400px)';
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
};

btn[3].onclick = function () {
    slide.style.transform = 'translateX(-2400px)';
    for (var i = 0; i < 4; i++) {
        btn[i].classList.remove('active');
    }
    this.classList.add('active');
};
