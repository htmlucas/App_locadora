<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- <card-component titulo="Relação de Modelos">

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
                </card-component> -->
                <card-component :dados="modelos.data" dataToggle='modal' dataTarget='#modalModeloVisualizar'>
                    <template v-slot:conteudo>
                    </template>
                </card-component>
            </div>
         </div>

         <!-- início do modal de inclusão de modelo -->
        <modal-component id="modalModelo" titulo="Adicionar modelo" modalSize="modal-lg">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>

                    <div class="col form-group">
                        <input-container-component titulo="Marca" id="idMarca" id-help="idMarcaHelp" texto-ajuda="Informe a marca">
                            <select  class="form-select form-control" aria-label=".form-select-sm example" id="idMarca"  v-model="idMarca">
                                <option selected >Abra o menu para selecionar a marca</option>
                                <option v-for="m in marcas.data" :value="m.id" :key="m.id">{{m.nome}}</option>
                            </select>
                        </input-container-component>
                    </div>

                    <div class="col form-group">
                        <input-container-component titulo="Nome do modelo" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do modelo">
                            <input type="text" class="form-control" aria-describedby="novoNomeHelp" placeholder="Nome do modelo" v-model="novonomeModelo">
                        </input-container-component>
                    </div>

                <div class="col form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" @change="carregarImagem($event)">
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Numero de Portas" id="numero_portas" id-help="numero_portasHelp" texto-ajuda="Informe o numero de portas">
                        <input type="number" class="form-control" aria-describedby="numero_portasHelp" placeholder="Numero de portas" v-model="numero_portas" min="1" max="6">
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Numero de Lugares" id="lugares" id-help="lugaresHelp" texto-ajuda="Informe o numero de lugares">
                        <input type="number" class="form-control" aria-describedby="lugaresHelp" placeholder="Numero de lugares" v-model="lugares">
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Air Bag" id="air_bag" id-help="air_bagHelp" texto-ajuda="Informe se tem Air Bags">
                        <select class="form-select form-control" aria-label=".form-select-sm example" v-model="air_bag">
                            <option selected >Abra o menu para selecionar </option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </input-container-component>
                </div>

                
                <div class="col form-group">
                    <input-container-component titulo="ABS" id="abs" id-help="absHelp" texto-ajuda="Informe se tem ABS">
                        <select class="form-select form-control" aria-label=".form-select-sm example" v-model="abs">
                            <option selected >Abra o menu para selecionar</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </input-container-component>
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
                <div class="col-md-12 text-center">
                    <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem">
                </div>

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
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
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
        <modal-component id="modalModeloAtualizar" titulo="Atualizar modelo"  modalSize="modal-lg">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                
                <div class="col form-group">
                    <input-container-component titulo="Marca" id="idMarca" id-help="idMarcaHelp" texto-ajuda="Informe a marca">
                        <select class="form-select form-control" aria-label=".form-select-sm example" id="idMarca"  v-model="$store.state.item.marca_id">
                            <option selected>Abra o menu para selecionar a marca</option>
                            <option v-for="m in marcas.data" :value="m.id" :key="m.id">{{m.nome}}</option>
                        </select>
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Nome do modelo" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do modelo">
                        <input type="text" class="form-control" aria-describedby="novoNomeHelp" placeholder="Nome do modelo" v-model="$store.state.item.nome">
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control" id="atualizarImagem" aria-describedby="novoImagemHelp" @change="carregarImagem($event)">
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Numero de Portas" id="numero_portas" id-help="numero_portasHelp" texto-ajuda="Informe o numero de portas">
                        <input type="number" class="form-control" aria-describedby="numero_portasHelp" placeholder="Numero de portas" v-model="$store.state.item.numero_portas" min="1" max="6">
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Numero de Lugares" id="lugares" id-help="lugaresHelp" texto-ajuda="Informe o numero de lugares">
                        <input type="number" class="form-control" aria-describedby="lugaresHelp" placeholder="Numero de lugares" v-model="$store.state.item.lugares">
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="Air Bag" id="air_bag" id-help="air_bagHelp" texto-ajuda="Informe se tem Air Bags">
                        <select class="form-select form-control" aria-label=".form-select-sm example" v-model="$store.state.item.air_bag">
                            <option selected >Abra o menu para selecionar </option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </input-container-component>
                </div>

                <div class="col form-group">
                    <input-container-component titulo="ABS" id="abs" id-help="absHelp" texto-ajuda="Informe se tem ABS">
                        <select class="form-select form-control" aria-label=".form-select-sm example" v-model="$store.state.item.abs">
                            <option selected >Abra o menu para selecionar</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
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
                urlBaseMarcas : 'http://localhost:8000/api/v1/marca',
                urlPaginacao: '',
                urlFiltro: '',
                idMarca: '',
                novonomeModelo: '',
                nomeModelo: '',
                arquivoImagem: [],
                numero_portas: '',
                lugares: '',
                air_bag: '',
                abs: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                modelos: { data: [] },
                marcas: { data: [] },
                all_marcas: [],
                busca: { id: '', nome: '' },
            }
        },
        methods:{
            carregarMarcas() {
                
               let url = this.urlBaseMarcas + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.marcas = response.data

                        
                        let urls = []
                        
                        let links = {}

                       

                        if(this.marcas.current_page != this.marcas.last_page ){ // para eu verificar se estou ja na ultima pagina

                             this.marcas.links.forEach(campo =>{                          

                                links[campo] = campo.url
                                urls.push(links[campo])
                            })

                            for(let i = 2;i< (urls.length - 1);i++){ // Aqui eu pego os dados de cada página em marcas, o retorno é quantidade de paginas com a quantidade de dados em cada uma delas
                                url = urls[i]

                                //console.log(url)
                                //console.log(i)

                                axios.get(url)
                                    .then(response => {
                                        //console.log('Página:'+i)
                                        for(let z = 0; z< response.data.data.length;z++){ // aqui eu pego separadamente cada dado da página e adiciono a marcas
                                            //console.log(z)
                                            //console.log(response.data.data[z])
                                            this.marcas.data.push(response.data.data[z])
                                        }
                                }).catch(errors => {
                                    console.log(errors)
                                })

                                //console.log(this.marcas)  
                            }
                        }
                        
                        
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.modelos = response.data
                        console.log(this.modelos.data)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
                },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                console.log(this.nomeMarca, this.arquivoImagem[0], this.idMarca)

                let formData = new FormData();
                formData.append('marca_id', this.idMarca)
                formData.append('nome', this.novonomeModelo)
                formData.append('imagem', this.arquivoImagem[0])
                formData.append('numero_portas', this.numero_portas)
                formData.append('lugares', this.lugares)
                formData.append('air_bag', this.air_bag)
                formData.append('abs', this.abs)

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
                formData.append('marca_id', this.$store.state.item.marca_id)
                if(this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0])
                }
                formData.append('nome', this.$store.state.item.nome)
                formData.append('numero_portas', this.$store.state.item.numero_portas)
                formData.append('lugares', this.$store.state.item.lugares)
                formData.append('air_bag', this.$store.state.item.air_bag)
                formData.append('abs', this.$store.state.item.abs)

                let url = this.urlBase + '/' + this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        console.log('sucesso')
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de marca atualizado com sucesso!'
                        //limpar o campo de seleção de arquivos
                        atualizarImagem.value = ''
                        this.carregarLista()
                        this.carregarMarcas()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        console.log('erro')
                        console.log(errors.response)
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
            paginacao(l) {
                if(l.url) {
                    //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
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
            this.carregarMarcas()
        }
    }
</script>
