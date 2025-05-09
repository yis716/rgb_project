// 메일 전송
const form = document.getElementById('contact-form');

if (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        emailjs.sendForm('service_xxahbpq', 'template_zcpt63k', this)
            .then(() => {
                console.log('SUCCESS!');
                alert('메일 전송에 성공하였습니다.');
                location.href = './sub6_1.html';
            }, (error) => {
                console.log('FAILED...', error);
                alert('메일 전송에 실패하였습니다.');
            });
    });
} else {
    console.warn('contact-form not found!');
}

// nav tab
const tabItems = document.querySelectorAll(".category-tabs li");

    tabItems.forEach(function (item) {
        item.addEventListener("click", function (e) {
            e.preventDefault();
            // 모든 li에서 active 클래스 제거
            tabItems.forEach(function (el) {
                el.classList.remove("active");
            });

            // 클릭한 li에 active 클래스 추가
            this.classList.add("active");
        });
    });



// 메일 전송
// document.getElementById('contact-form').addEventListener('submit', function (event) {
//     event.preventDefault();
//     // these IDs from the previous steps
//     emailjs.sendForm('service_xxahbpq', 'template_zcpt63k', this)
//         .then(() => {
//             console.log('SUCCESS!');
//             alert('메일 전송에 성공하였습니다.');
//             location.href = './sub6_1.html';
//         }, (error) => {
//             console.log('FAILED...', error);
//             alert('메일 전송에 실패하였습니다.');
//         });
// });

