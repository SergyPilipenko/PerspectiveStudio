<template>
    <div class="col-12 d-flex flex-column align-items-center">
        <h1 class="search__title">Подберём любую автозапчасть</h1>
        <p class="search__subtitle">Поиск запчастей и автотоваров по более чем 1 000 000 предложений</p>
        <div class="d-flex align-items-center search__filter">
            <span class="active" data-type="#model">По модели</span>
            <span data-type="#auto">По номеру авто</span>
            <span data-type="#vin">По VIN</span>
        </div>
        <select-car :auto_brands="auto_brands"
                    :routes="routes"></select-car>
        <form class="search__body search__vin align-items-center justify-content-center d-none" id="auto">
            <input type="text" placeholder="AA000Ae" required>
            <button type="submit">Выбрать</button>
        </form>
        <form class="search__body search__vin align-items-center justify-content-center d-none" id="vin">
            <input type="text" placeholder="KMHDH41EACU521274" required>
            <button type="submit">Выбрать</button>
        </form>
        <div class="search__footer d-flex align-items-center">
            <a href="#">Поиск по производителю</a>
            <a href="#">Поиск по товару</a>
        </div>
    </div>
</template>
<script>
    import SelectCar from './SelectCar'
    export default {
        props: ['auto_brands', 'routes'],
        comments: { SelectCar }
    }
</script>
