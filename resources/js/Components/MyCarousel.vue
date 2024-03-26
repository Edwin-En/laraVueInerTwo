<template>
   <v-card class="mt-8 elevation-23">
        <v-carousel :show-arrows="true" cycle height="350">
            <v-carousel-item v-for="(imagen, index) in imagenes" :key="index">
                <div class="flex justify-center items-center h-full">
                    <a :href="'/' + (index == 0 ? 'departments' : 'employees')">
                    <img :src="imagen.src" alt="Imagen" class="object-contain h-full">
                    </a>
                </div>
            </v-carousel-item>
        </v-carousel>
    </v-card>
</template>

<script setup>


const imagenes = [
    { src: "https://proyecto.plus/empresas/departamentos-de-una-empresa.jpg" },
    { src: "https://i0.wp.com/get.witei.com/wp-content/uploads/2021/06/5278.jpg?resize=789%2C481&ssl=1" },
    { src: "https://www.educaciontrespuntocero.com/wp-content/uploads/2020/04/mejores-bancos-de-imagenes-gratis.jpg" },
    { src: "https://www.tooltyp.com/wp-content/uploads/2014/10/1900x920-8-beneficios-de-usar-imagenes-en-nuestros-sitios-web.jpg" },
    { src: "https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dW5pdmVyc2V8ZW58MHx8MHx8fDA%3D" },
];



</script>