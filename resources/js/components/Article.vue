<template>
    <div>
        <h1>Noticias</h1>
        <div v-if="messageOk" class="alert alert-success" role="alert">
            {{ messageOk }}
        </div>
        <div v-if="messageError" class="alert alert-danger" role="alert">
            {{ messageError }}
        </div>
        <form mb-3 @submit.prevent="addArticle">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="title" v-model="article.title">
            </div>
            <div class="form-group">
                <input type="textarea" class="form-control" placeholder="place" v-model="article.body">
            </div>
            <div class="form-group">
                <input type="file"
                       id="image"
                       ref="article_image"
                       class="form-control"
                       :placeholder="article.image"
                       @change="handleFileUpload()">
            </div>
            <img :src="`storage/${article.image}`" style="width: 200px; height: 200px;"/>
            <button type="submit" class="btn btn-light btn-block">Enviar</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page
                    }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="(article) in articles" :key="article.id">
            <h3>{{ article.title }}</h3>
            <hr>
            <button class="btn btn-warning mb-2" @click="editArticle(article)">Edit</button>
            <button class="btn btn-danger" @click="deleteArticle(article.id)">Delete</button>
        </div>
    </div>


</template>
<script type="application/javascript">
    export default {
        name: 'Article',
        data() {
            return {
                articles: [],
                article: {
                    title: '',
                    body: '',
                    image: {}
                },
                pagination: {},
                edit: false,
                messageOk: '',
                messageError: '',
                article_id: ''
            }
        },
        created() {
            this.fetchArticles();
        },
        methods: {
            fetchArticles(page_url) {
                let vm = this;
                page_url = page_url || 'api/articles';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        console.log(res);
                        this.articles = res.data;
                        vm.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url
                };
                console.log(pagination);
                this.pagination = pagination;
            },
            deleteArticle(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/articles/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(res => {
                            alert(res.message);
                            this.fetchArticles();
                        })
                        .catch(err => console.log(err))
                }

            },
            prepareResource() {
                this.article.title = '';
                this.article.body = '';
                this.article.image = {}
            },
            handleFileUpload(e) {
                this.article.image = this.$refs.article_image.files[0]
            },
            addArticle() {
                let formData = new FormData();
                formData.append('title', this.article.title);
                formData.append('body', this.article.body);
                formData.append('image', this.article.image);
                console.log(this.article)
                if (this.edit === false) {
                    axios.post('api/articles', formData)
                        .then(res => {
                            console.log(res.data)
                            this.messageOk = "Evento añadido correctamente"
                            this.fetchArticles()
                        })
                        .catch(err => {
                            this.messageError = err.response.data.message


                        })
                } else {
                    if(this.$refs.article_image.files[0] === undefined) {
                        formData.append('image', null)
                    }
                    formData.append('_method', 'PATCH')
                    axios.post(`api/articles/${this.article.id}`, formData)
                        .then(res => {
                            console.log(res);
                            this.messageOk = 'Elementoe actualizado'
                            this.fetchArticles();
                        })
                        .catch(err => {
                            this.messageError = err.response.data.message;
                        })

                }
            },
            editArticle(article) {
                this.edit = true;
                this.article.id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
                this.article.image = article.image;
                //this.addArticle();
            }
        }
    }

</script>
