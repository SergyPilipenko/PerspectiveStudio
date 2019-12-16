<template>
    <vue-nested-menu :source="menu" />
</template>
<script>
    import VueNestedMenu from 'vue-nested-menu';
    Vue.use(VueNestedMenu);

    export default {
        data() {
            return {
                menu: {
                    title: 'ret',
                    children: [
                        {
                            title: `Today's Deals`,
                            link: `/today`,
                            children: [],
                        },
                        {
                            title: `Shop By Department`,
                            children: [
                                {
                                    title: `Amazon Music`,
                                    link: `/music`,
                                    children: [],
                                },
                                {
                                    title: `CDs and Vinyl`,
                                    link: `/cds`,
                                    children: [],
                                },
                            ],
                        },
                    ],
                },
            }
        }
    }
</script>
