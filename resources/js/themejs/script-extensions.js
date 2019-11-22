$(function () {
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
    }
});
