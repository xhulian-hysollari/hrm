<template>
    <article class="media" style="margin: 5px;">
        <div class="comment media-left">
            <figure class="comment image is-64x64" :style="{ 'background-image': 'url(' +me.profile_picture +')'}">
            </figure>
        </div>
        <div class="media-content" style="padding-top: 0">
            <form @submit.prevent="saveComment(id)">
                <div class="field">
                    <p class="comment-control">
                        <input class="input comment" placeholder="Add a comment..." v-model="comment">
                    </p>
                </div>
                <nav class="level">
                    <div class="level-left">
                        <div class="level-item">
                            <button type="submit" class="button is-info">Submit</button>
                        </div>
                    </div>
                </nav>
            </form>
        </div>
    </article>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import {toMulipartedForm} from '../../vuex/helpers';

    export default {
        props: ['id'],
        computed: {
            ...mapState({
                me: state => state.auth.me,
            }),
        },
        methods: {
            ...mapActions([
                'addComment',
                'addToastMessage',
            ]),
            saveComment(id) {
                console.log(this.comment);
                this.addComment({id: id, comment: this.comment})
                    .then(() => {
                        this.comment = '';
                    })
                    .catch((err) => {
                        console.log(err);
                        this.error = err.error;
                    });
            }
        },
        data() {
            return {
                comment: '',
            }
        }
    }
</script>

<style>
    .input.comment {
        border: none !important;
        box-shadow: none;
        border-radius: 0;
        border-bottom: 1.5px solid rgba(41, 127, 202, 0.7) !important;;
    }

    .input.comment:active {
        border: none !important;
        border-bottom: 1.5px solid rgba(41, 127, 202, 0.7) !important;;
    }

    .input.comment:hover {
        border: none !important;
        border-bottom: 1.5px solid rgba(41, 127, 202, 0.7) !important;;
    }

    .comment-control {
        padding: 0;
    }

    figure.comment.image {
        margin: 0;
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .comment.media-left {
        margin: 0;
        margin-right: 1rem;
        align-items: center;
        display: flex;
        flex-direction: column;
    }
</style>