// 전체 페이지 공통 js

// 글로벌 네비게이션(GNB)

var smh = $('.main').height();  // 메인 이미지의 높이를 리턴
var on_off=false;  //false(안오버)  true(오버)

    $('#headerArea').mouseenter(function(){
    // var scroll = $(window).scrollTop();
        $(this).css('background','#fff');
       // $('.dropdownmenu li .depth1').css('color','#333'); 
        //헤더영역의 텍스트 색상과 로고이미지 경로 등을 교체
        on_off=true;
    });

    $('#headerArea').mouseleave(function(){
            var scroll = $(window).scrollTop();  //스크롤의 거리
            
            if(scroll<smh-50 ){
                $(this).css('background','#fff').css('box-shadow','none'); 
                //$('.dropdownmenu li a').css('color','#333');
            }else{
                $(this).css('background','#fff'); 
                //$('.dropdownmenu li a').css('color','#333');
            }
        on_off=false;    
    });

    $(window).on('scroll',function(){//스크롤의 거리가 발생하면
            var scroll = $(window).scrollTop();  
            //스크롤의 거리를 리턴하는 함수
            //console.log(scroll);

            if(scroll>smh-50){//스크롤이 비주얼의 높이-header높이 까지 내리면
                $('#headerArea').css('background','#fff')
                //$('.dropdownmenu li a').css('color','#333');
            }else{//스크롤 내리기 전 디폴트(마우스올리지않음)
            if(on_off==false){
                $('#headerArea').css('background','#fff').css('box-shadow','none');
                    //$('.dropdownmenu li a').css('color','#333');
            }
        };      
    });

    //2depth 열기/닫기
    $('.dropdownmenu').hover(
        function() { 
        $('.dropdownmenu .menu ul').fadeIn('normal',function(){$(this).stop();}); //모든 서브를 다 열어라
        $('#headerArea').animate({height:287},'fast').clearQueue();
    },function() {
        $('.dropdownmenu .menu ul').hide(); //모든 서브를 다 닫아라
        $('#headerArea').animate({height:87},'fast').clearQueue();
    });

// console.log('hover됨', this);
    
    //1depth 효과
    $('.dropdownmenu .menu').hover(
        function() { 
            $('.depth1', this).css('color','#006EFF');
        },function() {
            $('.depth1',this).css('color','#888');
    });
    
    //tab 처리
    $('.dropdownmenu .menu .depth1').on('focus', function () {        
        $('.dropdownmenu .menu ul').slideDown('normal');
        $('#headerArea').animate({height:287},'fast').clearQueue();
    });

    $('.dropdownmenu .m6 li:last').find('a').on('blur', function () {        
        $('.dropdownmenu .menu ul').slideUp('fast');
        $('#headerArea').animate({height:87},'normal').clearQueue();
    });

//top으로 이동
$(window).on('scroll',function(){ //스크롤 값의 변화가 생기면
            var scroll = $(window).scrollTop(); //스크롤의 거리
            
            
            $('.text').text(scroll);

            if(scroll>=500){ //300이상의 거리가 발생되면
                $('.top_move').fadeIn('slow');  //top보임
            }else{
                $('.top_move').fadeOut('fast');//top안보임
            }
        });
    
        $('.top_move').click(function(e){
            e.preventDefault();
            //상단으로 스르륵 이동합니다.
            $("html,body").stop().animate({"scrollTop":0},1000); //요거 중요 {"scrollTop":100 -> (top좌표만큼 이동)},1000
        });

        //슬라이드 메뉴 클릭시 해당 콘텐츠로 스스륵~~~ 이동
        // $('.slideMenu a').click(function(e){
        //     e.preventDefault(); //href="#" 속성을 막아주는..메소드
    
        //     var value=0; //이동할 스크롤의 거리

        //     if($(this).hasClass('link1')){   //첫번째 메뉴를 클릭했냐?   if($(this).is('#link1')){
        //         value= $('#content .con1').offset().top;  // .offset == 해당 콘테츠의 상단의 거리~~ left/top/right/bottom
        //     }else if($(this).hasClass('link2')){
        //         value= $('#content .con2').offset().top; 
        //     }else if($(this).hasClass('link3')){
        //         value= $('#content .con3').offset().top; 
        //     }else if($(this).hasClass('link4')){
        //         value= $('#content .con4').offset().top; 
        //     }
            
        // $("html,body").stop().animate({"scrollTop":value},1000);
        // });





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