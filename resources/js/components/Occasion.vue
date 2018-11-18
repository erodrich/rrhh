<template>
    <div>
        <h2>Eventos</h2>
        <h1 v-model="message">{{ message }}</h1>
        <form mb-3 @submit.prevent="addOccasion" >
            <div class="form-group">
                <input type="text" class="form-control" placeholder="title" v-model="occasion.title">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="place" v-model="occasion.place">
            </div>
            <div class="form-group">
                <datepicker
                        v-model="occasion.day"
                        placeholder="Dia del evento"
                        format="yyyy-MM-dd"
                        :bootstrap-styling="bootstrapStyling"
                        :language="es"
                        input-class="date"
                >
                </datepicker>
            </div>
            <div class="form-group">
                <input type="time" class="form-control" placeholder="" v-model="occasion.hour">
            </div>
            <button type="submit" class="btn btn-light btn-block">Enviar</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchOccasions(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchOccasions(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="(occasion) in occasions" :key="occasion.id">
            <h3>{{ occasion.title }}</h3>
            <hr>
            <button class="btn btn-warning mb-2" @click="editOccasion(occasion)">Edit</button>
            <button class="btn btn-danger" @click="deleteOccasion(occasion.id)">Delete</button>
        </div>
    </div>
</template>
<script type="application/javascript">
    import Datepicker from 'vuejs-datepicker'
    import { es } from 'vuejs-datepicker/dist/locale'
    import axios from 'axios'

    export default {
        data() {
            return {
                occasions: [],
                occasion: {
                    id: '',
                    title: '',
                    day: new Date(),
                    hour: '',
                    place: '',
                },
                es: es,
                occasion_id: '',
                pagination: {},
                edit: false,
                bootstrapStyling: true,
                message: ''
            }
        },
        components: {
            Datepicker
        },
        created() {
            this.fetchOccasions();
        },
        methods: {
            fetchOccasions(page_url) {
                let vm = this;
                page_url = page_url || 'api/occasions';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        console.log(res);
                        this.occasions = res.data;
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
            deleteOccasion(id){
                if(confirm('Are you sure?')){
                    fetch(`api/occasions/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(res => {
                            alert(res.message);
                            this.$router.go()
                        })
                        .catch(err => console.log(err))
                }

            },
            prepareResource(){
                this.occasion.day = new Date();
                this.occasion.hour = '';
                this.occasion.place = '';
                this.occasion.title = '';

            },
            addOccasion(){
                if(this.edit === false){
                    this.occasion.day = this.occasion.day.toLocaleDateString('fr-CA')
                    axios.post('api/occasions', this.occasion)
                        .then(res => {
                            console.log(res.data)
                            this.prepareResource();
                            this.message = "Evento añadido correctamente"
                            this.fetchOccasions()
                        })
                        .catch(err => {
                            this.message = err.response.data.message


                        })
                } else {
                    axios.put(`api/occasions/${this.occasion.id}`, this.occasion)
                        .then(res => {
                            this.fetchOccasions();
                        })
                        .catch(err => {
                            this.message = err.response.data.message;
                        })

                }
            },
            editOccasion(occasion){
                this.edit = true;
                this.occasion.id = occasion.id;
                this.occasion.title = occasion.title;
                this.occasion.day = occasion.day;
                this.occasion.hour = occasion.hour;
                this.occasion.place = occasion.place;
                this.addOccasion()
            }

        }
    }

</script>
