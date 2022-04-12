<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <card-component titulo="Relação de Modelos">
                    <template v-slot:filtro>
                    <div class="d-flex justify-content-end">                     
                        <div class="form-inline">
                            <div class="form-group mx-sm-3 ">
                                <input-container-component titulo="Pesquisar modelos" id="inputNome" >
                                    <input type="text" class="form-control m-2" id="inputNome" aria-describedby="inputNomeHelp" placeholder="Nome do modelo" v-model="nomeModelo">
                                </input-container-component>
                            </div>
                        </div>
                    </div>
                       
                    </template>
                    <template v-slot:conteudo>
                        <table-component 
                            :dados="modelos.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                marca_id: {titulo: 'Marca ID', tipo: 'texto'},
                                marca: {titulo:'Nome Marca',tipo:'modelo'},
                                nome: {titulo: 'Nome Modelo', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                numero_portas: {titulo: 'Numero de Portas', tipo: 'texto'},
                                lugares: {titulo: 'Qtº de Lugares', tipo: 'texto'},
                                air_bag: {titulo: 'Air Bag', tipo: 'texto'},
                                abs: {titulo: 'ABS', tipo: 'texto'},
                            }"
                        ></table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in modelos.links" :key="key" 
                                        :class="l.active ? 'page-item active' : 'page-item'" 
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalModelo">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
         </div>

         <!-- início do modal de inclusão de modelo -->
        <modal-component id="modalModelo" titulo="Adicionar modelo" modalSize="modal-xl">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do modelo" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do modelo">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome do modelo" v-model="nomeModelo">
                    </input-container-component>
                    {{ nomeModelo }}
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                    {{ arquivoImagem }}
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- fim do modal de inclusão de modelo -->

        <!-- início do modal de visualização de modelo -->
        <modal-component id="modalModeloVisualizar" titulo="Visualizar Modelo" modalSize="modal-lg">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Id da marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca_id" disabled>
                </input-container-component>

                <input-container-component titulo="Marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca.nome" disabled>
                </input-container-component>

                <input-container-component titulo="Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>


                <input-container-component titulo="Imagem">
                    <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem">
                </input-container-component>

                <input-container-component titulo="Portas">
                    <input type="text" class="form-control" :value="$store.state.item.numero_portas" disabled>
                </input-container-component>

                <input-container-component titulo="Lugares">
                    <input type="text" class="form-control" :value="$store.state.item.lugares" disabled>
                </input-container-component>

                <input-container-component titulo="Air Bag">
                    <input type="text" class="form-control" :value="$store.state.item.air_bag" disabled>
                </input-container-component>

                <input-container-component titulo="Abs">
                    <input type="text" class="form-control" :value="$store.state.item.abs" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- fim do modal de inclusão de modelo -->


        <!-- início do modal de remoção de modelo -->
        <modal-component id="modalModeloRemover" titulo="Remover modelo">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da modelo">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>
        <!-- fim do modal de remoção de modelo -->

        <!-- início do modal de atualização de modelo -->
        <modal-component id="modalModeloAtualizar" titulo="Atualizar modelo">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da modelo" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o nome da modelo">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da modelo" v-model="$store.state.item.nome">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>
        <!-- fim do modal de atualização de modelo -->





    </div>
</template>

<script>

    export default {

        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/modelo',
                urlPaginacao: '',
                urlFiltro: '',
                nomeModelo: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                modelos: { data: [] },
                busca: { id: '', nome: '' },
            }
        },
        methods:{
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.modelos = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
                },
        },
        watch:{
            nomeModelo(valorNovo){

                let filtro = ''
                this.busca.nome = valorNovo;


                for(let chave in this.busca) {


                    if(this.busca[chave]) {
                        //console.log(chave, this.busca[chave])
                        if(filtro != '') {
                            filtro += ";"
                        }
                    
                        filtro += chave + ':like:' + this.busca[chave] + '%'
                    }
                }
    
                if(filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
