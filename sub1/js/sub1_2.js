const bannerLists = document.querySelectorAll(".banner ul");

    bannerLists.forEach(ul => {
        const clone = ul.innerHTML;
        ul.innerHTML += clone; // 뒤에 복제
        if (ul.classList.contains("mid")) {
            ul.classList.add("reverse");
        }
    });
