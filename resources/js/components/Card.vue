<template>

    <div class="container">
        
        <div class="row">
            <div v-for="d, id in dados" :key="id" class="card col-md-3 m-4" >
                <a href="#" :data-toggle="dataToggle" :data-target="dataTarget" @click="setStore(d)" >
                    <img class="card-img-top" :src="d.imagem != '' ? 'storage/'+d.imagem : 'storage/imagens/download.vsg' "  alt="Card image cap"  >
                </a>
            <div class="row">
                <div class="card-body">
                    <h5 class="card-title"> {{d.nome}}</h5>
                    <p class="card-text">Clique no item para mais informações...</p>
                    <!-- <slot name="conteudo"></slot>
                    <slot name="rodape"></slot> -->
                </div>
                <div class="card-fotter">
                    <slot name="footer"></slot>
                </div>
            </div>
            
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dados','dataToggle','dataTarget','imagem','objrelacionado'],
        methods: {
            setStore(d) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = d
            },
        }
   }
    
</script>
