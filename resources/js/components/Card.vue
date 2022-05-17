<template>
    <div class="container">
        <div class="row">
            <div v-for="d, id in dados" :key="id" class="card col-md-3 m-4" >
                <a href="#" style="hover:background-color:white;" >
                    <img class="card-img-top " :src="d.imagem != '' ? 'storage/'+d.imagem : 'storage/imagens/download.vsg' "  alt="Card image cap"  >
                </a>
                    <!-- <div class="row">
                        <div class="col align-self-end">
                            <slot name="filtro"></slot> 
                        </div>
                    </div> -->
               

   
                
            <div class="row">
                <div class="card-body">
                    <h5 class="card-title"> {{d.nome}}</h5>
                    <p class="card-text">Clique no item para mais informações...</p>
                    <!-- <slot name="conteudo"></slot>
                    <slot name="rodape"></slot> -->
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
            setStore(m) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = m
            }
        },
   }
    
</script>
