// 메일 전송
document.getElementById('contact-form').addEventListener('submit', function (event) {
    event.preventDefault();
    // these IDs from the previous steps
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