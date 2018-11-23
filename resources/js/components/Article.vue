<template>
    <div>
        <h1 class="display-4">Noticias</h1>
        <router-link 
                :to="{ name: 'noticiasForm' }" 
                tag="button"
                class="btn btn-success mb-2">Add
            </router-link>
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
            <img  :src="`/storage/${article.image}`" alt="Imagen de noticia" />
            <div>
                <h3>{{ article.title }}</h3>
                <em>Creado: {{ article.created_at}}</em>
            </div>
            
            <hr>
            <router-link 
                :to="{ name: 'noticiasForm', params: { id: article.id } }" 
                tag="button"
                class="btn btn-warning mb-2">Edit
            </router-link>
            <button class="btn btn-danger mb-2" @click="deleteArticle(article.id)">Delete</button>
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

            }
            
        }
    }

</script>
