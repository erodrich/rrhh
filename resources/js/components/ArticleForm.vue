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
                <input type="text" class="form-control" placeholder="Tìtulo" v-model="article.title">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea3">Texto</label>
                <textarea class="form-control" id="exampleFormControlTextarea3" rows="7" v-model="article.body"></textarea>
                <!-- <input type="textarea" class="form-control" placeholder="body" > -->
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                    <input type="file"
                       id="inputGroupFile01"
                       aria-describedby="inputGroupFileAddon01"
                       ref="article_image"
                       class="custom-file-input"
                       placeholder="Añadir imagen"
                       @change="handleFileUpload()">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <img v-if="edit" :src="`/storage/${article.image}`" style="width: 200px; height: 200px;"/>
            <button type="submit" class="btn btn-warning btn-block mb-2 mt-2">Guardar</button>
            <router-link 
                :to="{ name: 'noticias' }" 
                tag="button"
                class="btn btn-danger btn-block">Cancelar
            </router-link>
        </form>
    </div>
    
</template>
<script>
export default {
    name: 'ArticelForm',
    data() {
        return {
            article: {
                title: '',
                body: '',
                image: {}
            },
            edit: false,
            messageOk: '',
            messageError: '',
            article_id: ''
        }
    },
    props: ['id'],
    mounted() {
        console.log("ID: " + this.id)
        if(this.id != null){
            this.article_id = this.id;
            this.fetchArticle(this.id)
            this.edit = true
        }
        
    },
    methods: {
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
                axios.post('/api/articles', formData)
                    .then(res => {
                        console.log(res.data)
                        this.messageOk = "Noticia añadida correctamente"
                    })
                    .catch(err => {
                        this.messageError = err.response.data.message


                    })
            } else {
                if(this.$refs.article_image.files[0] === undefined) {
                    formData.append('image', null)
                }
                formData.append('_method', 'PATCH')
                axios.post(`/api/articles/${this.article.id}`, formData)
                    .then(res => {
                        console.log(res);
                        this.messageOk = 'Elemento actualizado'
                    })
                    .catch(err => {
                        this.messageError = err.response.data.message;
                    })
            }
        },
        fetchArticle(id){
            axios.get(`/api/articles/${id}`)
            .then(res => {
                res = res.data
                this.article.id = res.id;
                this.article.title = res.title;
                this.article.body = res.body;
                this.article.image = res.image;
            })
            .catch(err => this.messageError = err.response.data.message)
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
