<template>
    <div class="container">
        <nav-bar></nav-bar>
        <router-view></router-view>
    </div>
</template>

<script type="application/javascript">
    import NavBar from '../components/Navbar'
    export default {
        name: 'App',
        components: {
            NavBar
        }
    }
</script>

<style lang="scss">

</style>
