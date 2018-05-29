<template>
    <div class="control p_u_question_form">

        <form class="form" @submit.prevent="addPost" enctype="multipart/form-data">
                                        <textarea class="textarea post"
                                                  placeholder="post an update or a question"
                                                  v-model="status" rows="1"></textarea>
            <div class="file">
                <label class="file-label">
                    <input class="file-input" type="file" @change="previewImage"
                           accept="image/*" multiple>
                    <span class="file-cta-upload">
                        <span class="file-icon-upload">
                            <i class="fa fa-camera"></i>
                        </span>
                    </span>
                </label>
            </div>
            <button type="submit" class="button is-primary post-button">Post</button>

        </form>
    </div>
</template>

<script>
    import {toMulipartedForm} from '../helpers';
    export default {
        data() {
            return {
                status: '',
                form: new FormData(),
                attachments: [],
                images: [],
                list: [],
                error: [],
                i: 0,
            }
        },
        methods: {
            fetchPosts(){

            },
            prepareFields() {

                this.form.append('status', this.status);
                if (this.attachments.length > 0) {
                    for (let i = 0; i < this.attachments.length; i++) {
                        let attachment = this.attachments[i];
                        this.form.append('attachments[]', attachment);
                    }
                }
            },
            previewImage: function (event) {
                let input = event.target.files;
                if (input) {
                    for (let i = 0; i <= input.length - 1; i++) {
                        this.attachments.push(input[i]);
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.images.push(e.target.result);
                        };
                        reader.readAsDataURL(input[i]);
                    }
                }
            },
            deleteImage(index) {
                return this.attachments.splice(index, 1);
            },
            addPost() {
                this.prepareFields();
                const att = toMulipartedForm(this.form, this.$route.meta.mode);
                axios.post('/post/status', this.form)
                    .then(() => {
                        this.status = '';
                    })
                    .catch((err) => {
                        console.log(err);
                        this.error = err.error;
                    });
            },
        }
    }
</script>