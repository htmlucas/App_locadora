<template>
<div class="row">
    <div v-for="m, id in dados" :key="id" class="card col-md-4" >
        <div class="card-header text-center">
            {{m.marca.nome}}
        </div>
            <a href="" class="text-warning stretched-link" :data-toggle="dataToggle" :data-target="dataTarget" @click="setStore(m)"></a>
            <img class="card-img-top" :src="'storage/'+m.imagem" alt="Imagem Locadora Carros">        
        <div class="card-body">
            <h5 class="card-title">{{m.nome}}</h5>
            <p class="card-text">
                <strong>{{m.numero_portas}}</strong> | <strong>{{m.lugares}}</strong>
            </p>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['dados','dataToggle','dataTarget'],
        methods: {
            setStore(m) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = m
            }
        },
   }
    
</script>
