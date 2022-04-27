<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Relação de Clientes">

                    <template v-slot:filtro>
                        <div class="d-flex justify-content-end">                     
                            <div class="form-inline">
                                <div class="form-group mx-sm-3 ">
                                    <input-container-component titulo="Pesquisar cliente" id="inputNome" >
                                        <input type="text" class="form-control m-2" id="inputNome" aria-describedby="inputNomeHelp" placeholder="Nome..." v-model="searchnome">
                                    </input-container-component>
                                </div>
                            </div>
                        </div>                       
                    </template>

                    <template v-slot:conteudo>
                        <table-component 
                            :dados="clientes.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in clientes.links" :key="key" 
                                        :class="l.active ? 'page-item active' : 'page-item'" 
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCliente">Adicionar</button>
                            </div>
                        </div>
                    </template>

                </card-component>
            </div>
        </div>

        <!-- início do modal de inclusao de carro -->
         <modal-component id="modalCliente" titulo="Adicionar cliente">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a modelo" v-if="transacaoStatus == 'erro'"></alert-component>                
            </template>

            <template v-slot:conteudo>


                <div class="form-group">
                    <input-container-component titulo="Nome" id="nome" id-help="novaNomeHelp" texto-ajuda="Informe o Nome">
                        <input type="text" class="form-control" id="nome" aria-describedby="novoNomeHelp" placeholder="Informe o nome" v-model="nome">
                    </input-container-component>
                </div>

                
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- fim do modal de inclusão de carro -->

        <!-- início do modal de atualização de carro -->
        <modal-component id="modalClienteAtualizar" titulo="Atualizar informações do cliente">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>            
            </template>

            <template v-slot:conteudo>

               <div class="form-group">
                    <input-container-component titulo="Nome" id="nome" id-help="novaNomeHelp" texto-ajuda="Informe o Nome">
                        <input type="text" class="form-control" id="nome" aria-describedby="novoNomeHelp" placeholder="Informe o nome" v-model="$store.state.item.nome">
                    </input-container-component>
                </div> 
               
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Salvar</button>
            </template>
        </modal-component>
        <!-- fim do modal de atualização de carro  -->

        <!-- início do modal de visualização de carro -->
        <modal-component id="modalClienteVisualizar" titulo="Visualizar cliente" >
            <template v-slot:alertas></template>

            <template v-slot:conteudo>

                 <div class="form-group">
                    <input-container-component titulo="ID" id="id" id-help="idClienteHelp" texto-ajuda="ID do cliente">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>

                 <div class="form-group">
                    <input-container-component titulo="Nome" id="nome" id-help="NomeHelp" texto-ajuda="Nome do cliente">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>


            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- fim do modal de visualização de carro -->

        <!-- início do modal de remoção de modelo -->
        <modal-component id="modalClienteRemover" titulo="Remover cliente">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                
                <div class="form-group">
                    <input-container-component titulo="ID" id="id" id-help="idClienteHelp" texto-ajuda="ID do cliente">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>

                 <div class="form-group">
                    <input-container-component titulo="Nome" id="nome" id-help="NomeHelp" texto-ajuda="Nome do cliente">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>
                
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- fim do modal de remoção de modelo -->
    </div>
</template>

<script>
export default {
    data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/cliente',
                urlPaginacao: '',
                urlFiltro: '',
                id: '',
                nome: '',
                searchnome:'',
                transacaoStatus: '',
                transacaoDetalhes: {},
                clientes: { data: [] },
                busca: { id: '', nome: '' },
            }
        },
        methods:{
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.clientes = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            salvar() {

                let formData = new FormData();
                formData.append('nome', this.nome)
                


                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        }
                        
                        //console.log(response)
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                        //errors.response.data.message
                    })
            },
            atualizar() {

                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)

                let url = this.urlBase + '/' + this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de cliente atualizado com sucesso!'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            remover() {
                let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

                if(!confirmacao) {
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete')

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData)
                    .then(response => {                        
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                    })

            },

        },
        watch:{
            searchnome(valorNovo){

                let filtro = ''
                this.busca.nome = valorNovo;


                for(let chave in this.busca) {


                    if(this.busca[chave]) {
                        //console.log(chave, this.busca[chave])
                        if(filtro != '') {
                            filtro += ";"
                        }
                    
                        filtro += chave + ':like:'+ '%' + this.busca[chave] + '%'
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