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

