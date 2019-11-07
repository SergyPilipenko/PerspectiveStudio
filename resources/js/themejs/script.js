$(function(){
    //Hamburger menu
	// var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};
	// var hamburgers = document.querySelectorAll(".hamburger");
	// if (hamburgers.length > 0) {
	//   forEach(hamburgers, function(hamburger) {
	//     hamburger.addEventListener("click", function() {
	//       this.classList.toggle("is-active");
	//     }, false);
	//   });
	// }
	// if ($(window).width() < 510) {
	// 	$('.last-articles .col-xl-2').wrapAll('<div class="col-12 last-articles-slider"></div>');
	// 	$('.last-articles-slider').flickity({
	// 		cellAlign: 'left',
	// 		wrapAround: true,
	// 		pageDots: false,
	// 		prevNextButtons: false
	// 	});
	// }
	//Sliders and popups
	// var offset = $('.red-line').offset().top;
	// var hasClass = $('.red-line__catalog').hasClass('red-line__catalog--main');
	// $(window).scroll(function(){
   	// 	if($(this).scrollTop() > offset) {
	// 		$('.red-line').addClass('fixed-top');
	// 		if (hasClass) {
	// 			$('.red-line__catalog').removeClass('red-line__catalog--main');
	// 		}
	// 	} else {
	// 		$('.red-line').removeClass('fixed-top');
	// 		if (hasClass) {
	// 			$('.red-line__catalog').addClass('red-line__catalog--main');
	// 		}
	// 	}
	// });
	// $('.category__sidebar-mobile-filter').click(function(){
	// 	$('.category__sidebar, .popup-bg').fadeIn();
	// 	$('html').addClass('lock');
	// });
	// $('.red-line__cart, .header__cart').click(function(){
	// 	$('.popup__cart, .popup-bg').fadeIn();
	// 	$('html').toggleClass('lock');
	// })
	// $('.popup-bg').click(function(){
	// 	$('html').removeClass('lock');
	// 	$('.category__sidebar, .popup-bg, .popup__cart').fadeOut();
	// })
	// $('.popup-bg2').click(function(){
	// 	$('html').removeClass('lock');
	// 	$('.header__mobile-menu, .popup-bg2').fadeOut();
	// })
	// $('.header__burger').click(function(){
	// 	$('.header__mobile-menu, .popup-bg2').fadeIn();
	// 	$('html').addClass('lock');
	// });
    $('.manufacturers__slider').flickity({
		cellAlign: 'left',
		wrapAround: true,
		pageDots: false
	});
	$('.last-goods__slider').flickity({
		cellAlign: 'center',
		wrapAround: true,
		pageDots: true,
		groupCells: true
	});
	$('.last-goods__list li').click(function() {
		$('.last-goods__list-block').addClass('d-none');
		$($(this).attr('data-for')).removeClass('d-none');
		$('.last-goods__list li').removeClass('active');
		$(this).addClass('active');
	})
	$('.search__filter span').click(function() {
		$('.search__body').addClass('d-none');
		$($(this).attr('data-type')).removeClass('d-none');
		$('.search__filter span').removeClass('active');
		$(this).addClass('active');
	})
	// $('.search__model-dropdown span').click(function(){
	// 	var data = $(this).text();
	// 	$(this).parent().parent().addClass('active');
	// 	$(this).parent().parent().find('.search__model-subtext').text(data);
	// })
	// $('.companies__block-form-contacts-dropdown span').click(function(){
	// 	var data = $(this).text();
	// 	$(this).parent().parent().parent().find('>span').text(data);
	// })
    //
	// $(document).mouseup(function (e){ // событие клика по веб-документу
	// 	var div = $(".header__popup-catalog"); // тут указываем ID элемента
	// 	if (!div.is(e.target) // если клик был не по нашему блоку
	// 		&& div.has(e.target).length === 0 && div.hasClass('d-block')) { // и не по его дочерним элементам
	// 		div.removeClass('d-block');
	// 		$('.popup-black').removeClass('d-block');
	// 	}
	// });
	// $('.header__catalog').click(function(){
	// 	$('.header__popup-catalog').addClass('d-block');
	// 	$('.popup-black').addClass('d-block');
	// });
    //
    //
	// $('.header__popup-search .close').click(function(){
	// 	$('.popup-black2').removeClass('d-block');
	// 	$('.header__popup-search').removeClass('d-block');
	// })
	// $('.slider__wrap').flickity({
	// 	cellAlign: 'left',
	// 	wrapAround: true
	// });
	// $('.category__sidebar-price').ionRangeSlider({
	// 	type: "double",
	// 	hide_from_to: true,
	// 	hide_min_max: true,
	// 	skin: "round",
	// 	onStart: function (data) {
    //         $('#ot').text(`от ${data.from} грн`);
	// 		$('#do').text(`до ${data.to} грн`);
    //     },
	// 	onChange: function (data) {
    //         $('#ot').text(`от ${data.from} грн`);
	// 		$('#do').text(`до ${data.to} грн`);
    //     },
	// })
	// $('.partners__wrapper').flickity({
	// 	wrapAround: true,
	// 	contain: true,
	// 	cellAlign: 'left',
	// 	pageDots: false,
	// 	arrowShape: 'M10.273,5.009c0.444-0.444,1.143-0.444,1.587,0c0.429,0.429,0.429,1.143,0,1.571l-8.047,8.047h26.554c0.619,0,1.127,0.492,1.127,1.111c0,0.619-0.508,1.127-1.127,1.127H3.813l8.047,8.032c0.429,0.444,0.429,1.159,0,1.587c-0.444,0.444-1.143,0.444-1.587,0l-9.952-9.952c-0.429-0.429-0.429-1.143,0-1.571L10.273,5.009z'
	// });
	// $('.slider, .partners__wrapper').find('.flickity-button-icon').attr('viewBox', '0 0 31.9 31.9')
	// $('.slider, .partners__wrapper').find('.flickity-prev-next-button.next .arrow').attr('transform', 'translate(31.9, 31.9) rotate(180) ')

	// $('.items__tabs li').click(function(){
	// 	$(this).parentsUntil('.items').find('.items__body').addClass('d-none')
	// 	$(this).parent().find('li').removeClass('active')
	// 	$(this).addClass('active')
	// 	$('#'+ $(this).attr('data-tab')).removeClass('d-none')
	// 	$('.slider').flickity('resize')
	// })
	// $('.items__tabs--mobile li').click(function(){
	// 	$(this).parentsUntil('.items').find('.items__body').addClass('d-none')
	// 	$(this).parent().prev().html($(this).html() + '<img src="img/arrow-down.png" alt="arrow">');
	// 	$('#'+ $(this).attr('data-tab')).removeClass('d-none')
	// 	$('.slider').flickity('resize')
	// })
	// $('.card__tabs li').click(function(){
	// 	$('.card__block').addClass('d-none')
	// 	$(this).parent().find('li').removeClass('active')
	// 	$(this).addClass('active')
	// 	$('#'+ $(this).attr('data-tab')).removeClass('d-none')
	// })
	// $('.popup__close').click(function(){
	// 	$(this).parent().fadeOut()
	// 	$('.popup-bg').fadeOut()
	// 	$('html').toggleClass('lock')
	// })
	// $('.items__add').click(function(){
	// 	$('.add-to-cart, .popup-bg').fadeIn()
	// 	$('html').toggleClass('lock')
	// 	return false;
	// });
	// $('.items__tabs--mobile').click(function(){
	// 	$(this).find('.items__tabs--mobile__popup').css('display', 'block')
	// })
	// $('.header__call').click(function(){
	// 	$(this).find('span').css('display', 'none')
	// 	$(this).find('form').css('display', 'block')
	// })
	// $('.category__block ul li').click(function(){
	// 	$(this).parent().find('li').removeClass('active')
	// 	$(this).addClass('active')
	// })
	// $('.header__menu > span:first-child').click(function(){
	// 	$('.popup-bg, .authorization').fadeIn()
	// 	$('html').toggleClass('lock')
	// })
	// $(document).mouseup(function (e){ // событие клика по веб-документу
	// 	var div = $(".header__call"); // тут указываем ID элемента
	// 	if (!div.is(e.target) // если клик был не по нашему блоку
	// 	    && div.has(e.target).length === 0) { // и не по его дочерним элементам
	// 		div.find('span').css('display', 'block');
	// 		div.find('form').css('display', 'none');
	// 	}
	// 	var div2 = $(".mobile-menu__popup"); // тут указываем ID элемента
	// 	if (!div2.is(e.target) // если клик был не по нашему блоку
	// 	    && div2.has(e.target).length === 0) { // и не по его дочерним элементам
	// 				div2.css('display', 'none')
	// 	}
	// 	var div3 = $(".items__tabs--mobile__popup"); // тут указываем ID элемента
	// 	if (!div3.is(e.target) // если клик был не по нашему блоку
	// 	    && div3.has(e.target).length === 0) { // и не по его дочерним элементам
	// 				div3.css('display', 'none')
	// 	}
	// });
	// $('.menu__search input').focus(function(){
	// 	$('.popup__search').css('display', 'block')
	// })
	// $('.menu__search input').focusout(function(){
	// 	$('.popup__search').css('display', 'none')
	// })
	// $('.menu__catalog').click(function(){
	// 	$('.popup__menu').css('display', 'flex')
	// 	$('.popup-bg').css('display', 'block')
	// 	$('html').toggleClass('lock')
	// })
	// $('.cart').click(function(){
	// 	$('.popup__cart').fadeIn()
	// 	$('.popup-bg').fadeIn()
	// 	$('html').toggleClass('lock')
	// })
	// $('.header__burger').click(function(){
	// 	$('.popup__menu').addClass('translated')
	// })
	// $('.popup__menu__header .close').click(function(){
	// 	$('.popup__menu').removeClass('translated')
	// })
	// $('.popup-bg').click(function(){
	// 	$(this).css('display', 'none')
	// 	if ($(window).width()>1440) {
	// 		$('.popup__menu').css('display', 'none')
	// 	}
	// 	$('.popup__cart, .authorization, .add-to-cart').fadeOut()
	// 	$('html').toggleClass('lock')
	// })
	// if ($(window).width() < 1440) {
	// 	$(".card__description").after($('.card__side').detach());
	// }
	// if ($(window).width() < 780) {
	// 	$('.categories .container .row:last-child .col-md-4:nth-last-child(2)').append($('.categories .container .row:last-child .col-md-4:last-child').find('.categories__block:first-child').detach())
	// }
	// $('.mobile-menu__phones').click(function(){
	// 	$('.mobile-menu__popup').css('display', 'flex')
	// })
	// $('input[type="tel"]').mask("+38(099)-999-99-99");
	//Responsive
	// $('.hamburger').click(function(){
	// 	$('.dropdown--menu').toggleClass('d-block');
	// });
    function insertAfter(newNode, referenceNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    if($(".show-more-text").length) {
        var showMoreElements = $(".show-more-text");
        showMoreElements.each(function(el) {
            var item = showMoreElements[el];
            if(item.offsetHeight < item.scrollHeight) {
                var btn = document.createElement("button");
                btn.classList.add("manufacturers__show-more");
                btn.innerText = "Показать больше";
                var btnHide = document.createElement("button");
                btnHide.classList.add("manufacturers__show-more");
                btnHide.style.display = "none";
                btnHide.innerText = "Скрыть";
                insertAfter(btn, item);
                insertAfter(btnHide, item);
                btn.addEventListener('click', () => {
                    item.style.maxHeight = "none";
                    btn.style.display = "none";
                    btnHide.style.display = "block";
                });
                btnHide.addEventListener('click', () => {
                    item.style.maxHeight = "110px";
                    btn.style.display = "block";
                    btnHide.style.display = "none";
                });
            }
        });
        // console.log(showMoreElements.length);
        // if(el.height() < el[0].scrollHeigh) {
        //     el.append("<button class='manufacturers__show-more'>Показать больше</button>")
        // }
        // console.log(el.height());
        // console.log(el[0].scrollHeigh);
    }
});
