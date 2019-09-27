<template>
    <div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Поиск" @input="search">
        </div>
        <div class="result-container">
            <div class="categories" v-if="categories.length">
                <div class="result-header">Категории</div>
                <ul>
                    <li v-for="category in categories">
                        <a href="#" v-text="getCategoryTitle(category)"></a>
                    </li>
                </ul>
            </div>
            <div class="products"  v-if="products.length">
                <div class="result-header">Товары</div>
                <ul>
                    <li v-for="product in products">
                        <ul>
                            <li v-if="product.images.length">
                                <img :src="'/' + product.images[0].path" alt="" style="max-width: 100px">
                            </li>
                            <li v-text="product.manufacturer"></li>
                            <li>
                                <a :href="'/' + product.slug + '.html'" v-text="product.name"></a>
                            </li>
                            <li v-text="product.price"></li>
                            <li>
                                <add-to-cart-form
                                    :product="product"
                                    :action="addToCartAction(product.id)"
                                    :hideSelect="true"
                                    @productAdded="refreshCart"
                                ></add-to-cart-form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
    import AddToCartForm from "../product/AddToCartForm";
    import { mapMutations } from 'vuex'

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
        methods: {
            ...mapMutations({
                'setCart': 'Cart/setCart'
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
                        self.products = data.data.products;
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
        }
    }
</script>
