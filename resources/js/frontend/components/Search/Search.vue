<template>
    <div v-if="getShow">
        <div class="popup-black2" @click="hideModalSearch"></div>
        <div class="container popup-black2-container">
            <div class="search-modal-wrapper row">
                <form class="header__popup-search">
                    <div class="close"><img src="/img/frontend/img/svg/cross.svg" alt="img" @click="hideModalSearch"></div>
                    <div class="d-flex justify-content-between header__popup-search-line align-items-center">
                        <input ref="inp" type="text" placeholder="Поиск по марка/модель/год, номер запчасти, тип запчасти, производитель ...." @input="search">
                        <button type="submit"><img src="/img/frontend/img/svg/search.svg" alt="search"></button>
                    </div>
                    <div class="header__popup-search-result" v-if="products.length | categories.length">
                        <div  v-if="categories.length">
                            <h3>Категории</h3>
                            <ul class="cats">
                                <li>
                                    <a href="#" v-for="category in categories" v-text="getCategoryTitle(category)"></a>
                                </li>
<!--                                <li><a href="#"><span>Тормоз</span>ные шланги</a></li>-->
<!--                                <li><a href="#"><span>Тормоз</span>ные колодки</a></li>-->
<!--                                <li><a href="#"><span>Тормоз</span>ные барабаны</a></li>-->
                            </ul>
                        </div>
                        <div v-if="products.length">
                            <h3>Товары</h3>
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="header__popup-search-result-item" v-for="product in products">
                                    <a href="#">
                                        <div v-if="product.images.length">
                                            <img :src="'/' + product.images[0].path" alt="last-good" class="last-goods__image">
                                        </div>
                                        <img v-else src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="#"><span class="last-goods__title" v-text="product.manufacturer"></span></a>
                                        <a :href="'/' + product.slug + '.html'"><span class="last-goods__type" v-text="product.name">Фильтр масляный</span></a>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column">
                                                <span class="last-goods__price">{{ product.price }} грн</span>
                                                <div class="d-flex align-items-center last-goods__available">
                                                    <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                                    <span>В наличии</span>
                                                </div>
                                            </div>
                                            <add-to-cart-form
                                                :product="product"
                                                :action="addToCartAction(product.id)"
                                                :hideSelect="true"
                                                @productAdded="refreshCart"
                                            ></add-to-cart-form>
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="header__popup-search-result-item">-->
<!--                                    <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>-->
<!--                                    <div class="d-flex flex-column">-->
<!--                                        <a href="#"><span class="last-goods__title">Hyundai/Kia</span></a>-->
<!--                                        <a href="#"><span class="last-goods__type">Фильтр масляный</span></a>-->
<!--                                        <div class="d-flex align-items-center justify-content-between">-->
<!--                                            <div class="d-flex flex-column">-->
<!--                                                <span class="last-goods__price">122 грн</span>-->
<!--                                                <div class="d-flex align-items-center last-goods__available">-->
<!--                                                    <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">-->
<!--                                                    <span>В наличии</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <button class="last-goods__buy">Купить</button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="header__popup-search-result-item">-->
<!--                                    <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>-->
<!--                                    <div class="d-flex flex-column">-->
<!--                                        <a href="#"><span class="last-goods__title">Hyundai/Kia</span></a>-->
<!--                                        <a href="#"><span class="last-goods__type">Фильтр масляный</span></a>-->
<!--                                        <div class="d-flex align-items-center justify-content-between">-->
<!--                                            <div class="d-flex flex-column">-->
<!--                                                <span class="last-goods__price">122 грн</span>-->
<!--                                                <div class="d-flex align-items-center last-goods__available">-->
<!--                                                    <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">-->
<!--                                                    <span>В наличии</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <button class="last-goods__buy">Купить</button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="header__popup-search-result-item">-->
<!--                                    <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>-->
<!--                                    <div class="d-flex flex-column">-->
<!--                                        <a href="#"><span class="last-goods__title">Hyundai/Kia</span></a>-->
<!--                                        <a href="#"><span class="last-goods__type">Фильтр масляный</span></a>-->
<!--                                        <div class="d-flex align-items-center justify-content-between">-->
<!--                                            <div class="d-flex flex-column">-->
<!--                                                <span class="last-goods__price">122 грн</span>-->
<!--                                                <div class="d-flex align-items-center last-goods__available">-->
<!--                                                    <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">-->
<!--                                                    <span>В наличии</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <button class="last-goods__buy">Купить</button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="header__popup-search-result-item">-->
<!--                                    <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>-->
<!--                                    <div class="d-flex flex-column">-->
<!--                                        <a href="#"><span class="last-goods__title">Hyundai/Kia</span></a>-->
<!--                                        <a href="#"><span class="last-goods__type">Фильтр масляный</span></a>-->
<!--                                        <div class="d-flex align-items-center justify-content-between">-->
<!--                                            <div class="d-flex flex-column">-->
<!--                                                <span class="last-goods__price">122 грн</span>-->
<!--                                                <div class="d-flex align-items-center last-goods__available">-->
<!--                                                    <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">-->
<!--                                                    <span>В наличии</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <button class="last-goods__buy">Купить</button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="header__popup-search-result-item">-->
<!--                                    <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>-->
<!--                                    <div class="d-flex flex-column">-->
<!--                                        <a href="#"><span class="last-goods__title">Hyundai/Kia</span></a>-->
<!--                                        <a href="#"><span class="last-goods__type">Фильтр масляный</span></a>-->
<!--                                        <div class="d-flex align-items-center justify-content-between">-->
<!--                                            <div class="d-flex flex-column">-->
<!--                                                <span class="last-goods__price">122 грн</span>-->
<!--                                                <div class="d-flex align-items-center last-goods__available">-->
<!--                                                    <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">-->
<!--                                                    <span>В наличии</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <button class="last-goods__buy">Купить</button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                        </div>
                        <a href="#" class="results">Все результаты</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--    <div>-->
<!--        <div class="form-group">-->
<!--            <input type="text" class="form-control" placeholder="Поиск" @input="search">-->
<!--        </div>-->
<!--        <div class="result-container">-->
<!--            <div class="categories" v-if="categories.length">-->
<!--                <div class="result-header">Категории</div>-->
<!--                <ul>-->
<!--                    <li v-for="category in categories">-->
<!--                        <a href="#" v-text="getCategoryTitle(category)"></a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            <div class="products"  v-if="products.length">-->
<!--                <div class="result-header">Товары</div>-->
<!--                <ul>-->
<!--                    <li v-for="product in products">-->
<!--                        <ul>-->
<!--                            <li v-if="product.images.length">-->
<!--                                <img :src="'/' + product.images[0].path" alt="" style="max-width: 100px">-->
<!--                            </li>-->
<!--                            <li v-text="product.manufacturer"></li>-->
<!--                            <li>-->
<!--                                <a :href="'/' + product.slug + '.html'" v-text="product.name"></a>-->
<!--                            </li>-->
<!--                            <li v-text="product.price"></li>-->
<!--                            <li>-->
<!--                                <add-to-cart-form-->
<!--                                    :product="product"-->
<!--                                    :action="addToCartAction(product.id)"-->
<!--                                    :hideSelect="true"-->
<!--                                    @productAdded="refreshCart"-->
<!--                                ></add-to-cart-form>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>
<script>
    import AddToCartForm from "../product/AddToCartForm";
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        props: ['add_action', 'marker'],
        components: { AddToCartForm },
        data() {
            return {
                searchString: '',
                products: [],
                categories: [],
                lang: window.lang
            }
        },
        computed: {
            ...mapGetters({
                'getShow': 'Search/getShow',
            }),
        },
        methods: {
            ...mapMutations({
                'setCart': 'Cart/setCart',
                'hideModalSearch': 'Search/hideModalSearch',
            }),
            search(e) {
                if(e.target.value.length == 0 && this.categories.length > 0 || this.products.length > 0) {
                    this.categories = [];
                    this.products = [];
                }
                if(e.target.value.length >=3 ) {
                    this.searchString = e.target.value;
                    this.sendSearchRequest();
                }
            },
            sendSearchRequest() {
                var Form = new FormData(),
                    self = this;
                Form.append('searchString', this.searchString);
                axios.post('/search', Form)
                    .then(function (data) {
                        self.categories = data.data.categories;
                        if(data.data.products.data != undefined && data.data.products.data.length) {
                            self.products = data.data.products.data;
                        }
                    })
            },
            addToCartAction(id) {
                var reg = new RegExp(this.marker);
                return this.add_action.replace(reg, id)
            },
            refreshCart(cart) {
                this.setCart(cart);
            },
            getCategoryTitle(category) {
                var locatedTitle = category.category_title[this.lang];
                if(!locatedTitle) {
                    locatedTitle = category.category_title["ru"];
                }

                return locatedTitle;
            }
        },
        watch: {
            getShow() {
                if(this.getShow) {
                    this.$nextTick(() => {
                        this.$refs.inp.focus();
                    })
                }
            }
        }
    }
</script>
