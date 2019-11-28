<template>
    <div>
        <textarea :name="inputName" id="ckeditor" rows="10" cols="80" v-model="editorData" v-text="editorData"></textarea>
<!--        <ckeditor :editor="editor"  v-model="editorData" :config="editorConfig"></ckeditor>-->
<!--        <textarea name="editor1" id="editor1" rows="10" cols="80">-->
<!--            This is my textarea to be replaced with CKEditor.-->
<!--        </textarea>-->
<!--        <input type="hidden" name="editorContent" v-model="editorData">-->
    </div>
</template>

<script>
    export default {
        props: ['content', 'name'],
        created() {
            if(this.name) {
                this.inputName = this.name;
            }
            if(this.content) {
                this.editorData = this.content
            }
        },
        data() {
            return {
                editorData: '',
                inputName: 'ckeditor'
            }
        }
    }
</script>
<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>
