<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
        <div class="container">
            <a href="#" class="navbar-brand">RRHH</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link"
                                     active-class="active"
                                     exact
                                     :to="{ name: 'noticias', id: '' }">Noticias
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link"
                                     active-class="active"
                                     exact
                                     :to="{ name: 'eventos', id: '' }">Eventos
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link"
                                     active-class="active"
                                     exact
                                     :to="{ name: 'documentos', id: '' }">Documentos
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
