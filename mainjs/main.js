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

// about영역 sticky
window.addEventListener('scroll', function () {
  const aboutBox = document.querySelector('.aboutUs');
  const ul = document.querySelector('.aboutUs .aboutRight ul');

  const winScrollY = window.scrollY;
  const aboutTop = aboutBox.offsetTop;

  // 스크롤 시작점부터 얼마나 이동했는지 계산
  const scrollOffset = winScrollY - aboutTop;

  if (scrollOffset >= 0 && scrollOffset < 2000) {
    ul.style.top = `${200 - scrollOffset}px`;
  }
});

