<template>
    <div>
        <h2>Eventos</h2>
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
        <div class="card card-body mb-2" v-for="occasion in occasions" :key="occasion.id">
            <h3>{{occasion.title}}</h3>
            <hr>
            <button class="btn btn-danger" @click="deleteOccasion(occasion.id)">Delete</button>
        </div>
    </div>
</template>
<script type="application/javascript">
    export default {
        data() {
            return {
                occasions: [],
                occasion: {
                    id: '',
                    title: '',
                    day: '',
                    hour: '',
                    place: '',
                },
                occasion_id: '',
                pagination: {},
                edit: false,
            }
        },
        created() {
            this.fetchOccasions();
        },
        methods: {
            fetchOccasions(page_url) {
                console.log(page_url);
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
                        })
                        .catch(err => console.log(err))
                }
            }

        }
    }

</script>