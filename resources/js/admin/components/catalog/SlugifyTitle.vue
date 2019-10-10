<template>
    <div>
        <div class="category-title">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_title">Название: [{{ locale }}]</label>
                        <input type="text" v-if="locale" :class="{'form-control' : true,' error': errors && errors['category_title'] != undefined}" :name="locale+'[category_title]'" v-model="title">
                        <input type="text" v-else :class="{'form-control' : true,' error': errors && errors['category_title'] != undefined}" name="category_title" v-model="title">
                        <div v-if="errors && errors['category_title']">
                            <div class="text-danger" v-for="error in errors['category_title']" v-text="error"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="category-slug">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_title">URL: [{{ locale }}]</label>
                        <input v-if="locale" type="text" :class="{'form-control' : true,' error': errors && errors['slug'] != undefined}" :name="locale+'[slug]'" :value="slugify">
                        <input v-else="locale" type="text" :class="{'form-control' : true,' error': errors && errors['slug'] != undefined}" name="slug" :value="slugify">

                        <div v-if="errors && errors['slug']">
                            <div class="text-danger" v-for="error in errors['slug']" v-text="error"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        props: ['old', 'current_title', 'current_slug', 'errors_list', 'locale'],

        data() {
            return {
                title: '',
                slug: this.current_slug,
                spt: '',
            }
        },
        created() {
            this.current_title ? this.title = this.current_title : this.title = '';
            this.oldData && this.oldData['category_title'] ? this.title = this.oldData['category_title'] : this.title = ''
        },
        methods: {
            find(str) {
                var arrru = new Array ('Я','я','Ю','ю','Ч','ч','Ш','ш','Щ','щ','Ж','ж','А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н', 'О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ы','ы','Ь','ь','Ъ','ъ','Э','э','-','/','.');
                var arren = new Array ('Ya','ya','Yu','yu','Ch','ch','Sh','sh','Sh','sh','Zh','zh','A','a','B','b','V','v','G','g','D','d','E','e','E','e','Z','z','I','i','J','j','K','k','L','l','M','m','N','n', 'O','o','P','p','R','r','S','s','T','t','U','u','F','f','H','h','C','c','Y','y','','','\'','\'','E', 'e','-','-','-');

                var ru = arrru.indexOf(str);
                var en = arrru.indexOf(str);
                var needle = '';
                if(ru != -1) {
                    needle = arren[ru];
                } else if(en != -1) {
                    needle = arren[en];
                }
                return needle;
            }
        },
        computed: {
            oldData() {
                if(this.old) {
                    return JSON.parse(this.old)
                }
            },
            errors() {
                if(this.errors_list) {
                    return (JSON.parse(this.errors_list))
                }
            },
            slugify() {
                var splitTitle =  this.title;

                splitTitle = splitTitle.toLowerCase();
                splitTitle = splitTitle.replace(/\s+/g, '-');
                this.spt = splitTitle;
                splitTitle = splitTitle.split("");
                for(let i in splitTitle) {
                    var reg = new RegExp('[a-zA-Z0-9]');
                    if(reg.test(splitTitle[i])) {
                        splitTitle[i] = splitTitle[i];
                        continue;
                    } else {
                        splitTitle[i] = this.find(splitTitle[i]);
                    }
                }
                splitTitle = splitTitle.join("");
                return splitTitle;
            }
        }
    }
</script>
