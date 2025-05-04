// 아코디언js
document.addEventListener("DOMContentLoaded", () => {
  const acList = document.querySelectorAll(".accordion .list");

  // 처음화면은 Smart Industry(2번째 li) 기본 활성화
  if (acList.length > 0) {
    acList[1].classList.add("active"); // 
  }
  // hover시 li 콘텐츠들 active클래스 들어가면서 열리기
  acList.forEach(item => {
    item.addEventListener("mouseenter", () => {
      acList.forEach(i => i.classList.remove("active"));
      item.classList.add("active");
    });
  });
});

// modal js

// 개인정보모달
// 모달창과 버튼을 HTML에서 찾아서 지정
const openBtn = document.getElementById('priModal');   // 개인정보처리방침 버튼
const closeBtn = document.getElementById('closePriModal'); // 닫기 버튼
const modal = document.getElementById('privacyModal');     // 모달 전체

  // 버튼을 클릭하면 모달창이 나타나기
  openBtn.addEventListener('click', function (e) {
    e.preventDefault(); // 페이지이동 막기
    modal.removeAttribute('hidden'); // hidden 속성 제거 화면에 나타남
  });

  // 닫기 버튼을 누르면 모달창 사라지기
  closeBtn.addEventListener('click', function () {
    modal.setAttribute('hidden', true); // hidden 속성 추가 화면에서 사라짐
  });

  // 바깥배경 눌러도 닫히기
  modal.addEventListener('click', function (e) {
    if (e.target === modal) {
      modal.setAttribute('hidden', true);
    }
  });

  // ESC 키를 눌러도 닫히기
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      modal.setAttribute('hidden', true);
    }
  });


// 이메일 모달

const openEmailBtn = document.getElementById('emailModal'); // 이메일무단수집거부 열기 버튼
const closeEmailBtn = document.getElementById('closeEmailModal'); // 닫기 버튼
const emailRefuseModal = document.getElementById('emailRefuseModal');  // 모달

  // 열기 버튼 클릭 시 모달 보이기
  openEmailBtn.addEventListener('click', function (e) {
    e.preventDefault();
    emailRefuseModal.removeAttribute('hidden');
  });

  // 닫기 버튼 클릭 시 모달 숨기기
  closeEmailBtn.addEventListener('click', function () {
    emailRefuseModal.setAttribute('hidden', true);
  });

  // 모달 바깥 클릭 시 닫기
  emailRefuseModal.addEventListener('click', function (e) {
    if (e.target === emailRefuseModal) {
      emailRefuseModal.setAttribute('hidden', true);
    }
  });

  // ESC 키 눌렀을 때 닫기
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      emailRefuseModal.setAttribute('hidden', true);
    }
  });