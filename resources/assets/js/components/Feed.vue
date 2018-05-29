<template>
    <article class="message is-white is-bdr-b3">
        <div class="message-header">
            <h3 class="is-h3-clr">Post</h3>
        </div>
        <div class="is-hr">
            <hr>
        </div>
        <footer class="card-footer no-bdr">

        </footer>
        <div class="content">

        </div>
        <!--<div class="common_comment">-->
        <!--<div style="display:flex; justify-content:center; align-items:center">-->
        <!--<button class="show_more_btn" v-on:click="comment_show(commentshow)">comment</button>-->
        <!--</div>-->
        <!--<div v-if="feed.comments.length > 3 && feed.comments.length-1 > counter" style="display:flex; justify-content:center; align-items:center">-->
        <!--<button class="show_more_btn" v-on:click="comment_counter(counter)">show more</button>-->
        <!--</div>-->
        <!--</div>-->

    </article>
</template>
<script>

    export default {
        data() {
            return {
                date: '',
                counter: 2,
                commentshow: 0
            }
        },
        methods: {
            // getDate(value) {
            //     return moment(value).calendar();
            // },
            comment_counter: function (message) {
                this.counter = message + 3
            },
            comment_show: function (message) {
                if (message === 1) {
                    this.commentshow = 0
                }
                else {
                    this.commentshow = 1
                }

            }
        }
    }
</script>

<style>
    .card:not(:last-child) {
        margin-bottom: 20px;
    }

    .media-content {
        word-wrap: break-word;
        word-break: break-word;
        padding: 15px;
    }

    .is-320x320 {
        width: auto;
        min-width: 100px;
        max-width: 320px;
        /*height: 100%;*/
        min-height: 100px;
        max-height: 320px;
    }

    .is-80x80 {
        width: 100%;
        max-width: 80px;
        min-width: 80px;
        height: 100%;
        max-height: 80px;
        min-height: 80px;
    }

</style>