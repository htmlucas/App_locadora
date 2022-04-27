<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <card-component titulo="Relação de Locações">

                    <template v-slot:filtro>
                        <div class="d-flex justify-content-end">                     
                            <div class="form-inline">
                                <div class="form-group mx-sm-3 ">
                                    <input-container-component titulo="Pesquisar cliente" id="inputNome" >
                                        <input type="text" class="form-control m-2" id="inputNome" aria-describedby="inputNomeHelp" placeholder="Nome..." v-model="searchcarro">
                                    </input-container-component>
                                </div>
                            </div>
                        </div>                       
                    </template>

                    <template v-slot:conteudo>
                        <table-component 
                            :dados="locacoes.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                cliente_id: {titulo: 'ID Cliente', tipo: 'texto'},
                                cliente: {titulo: 'Nome Cliente', tipo: 'modelo'},
                                carro_id: {titulo: 'ID Carro', tipo: 'texto'},
                                data_inicio_periodo: {titulo: 'Periodo Inicial', tipo: 'texto'},
                                data_final_previsto_periodo: {titulo: 'Periodo Final', tipo: 'texto'},
                                data_final_realizado_periodo: {titulo: 'Periodo Realizado', tipo: 'texto'},
                                valor_diaria: {titulo: 'Valor Diaria', tipo: 'texto'},
                                km_inicial: {titulo: 'KM Inicial', tipo: 'texto'},
                                km_final: {titulo: 'KM Final', tipo: 'texto'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in locacoes.links" :key="key" 
                                        :class="l.active ? 'page-item active' : 'page-item'" 
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalLocacao">Adicionar</button>
                            </div>
                        </div>
                    </template>

                </card-component>
            </div>
        </div>

        <!-- início do modal de inclusão de modelo -->
        <modal-component id="modalLocacao" titulo="Adicionar modelo" modalSize="modal-lg">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>

                    <div class="col form-group">
                        <input-container-component titulo="Clientes" id="cliente_id" id-help="idClienteHelp" texto-ajuda="Informe o cliente">
                            <select  class="form-select form-control" aria-label=".form-select-sm example" id="cliente_id"  v-model="cliente_id">
                                <option selected >Abra o menu para selecionar o cliente</option>
                                <option v-for="m in clientes.data" :value="m.id" :key="m.id">{{m.nome}}</option>
                            </select>
                        </input-container-component>
                    </div>
                    
                    <div class="col form-group">
                        <input-container-component titulo="Carros" id="carro_id" id-help="idCarrosHelp" texto-ajuda="Informe o carro">
                            <select  class="form-select form-control" aria-label=".form-select-sm example" id="carro_id"  v-model="carro_id">
                                <option selected >Abra o menu para selecionar o carro</option>
                                <option v-for="m in carros.data" :value="m.id" :key="m.id">{{m.modelo.nome}}</option>
                            </select>
                        </input-container-component>
                    </div>

                    <div class="col form-group">
                        <input-container-component titulo="Data de Inicio" id="data_inicio_periodo" id-help="dataInicioHelp" texto-ajuda="Informe a data de inicio">
                            <input type="datetime-local" class="form-control" aria-describedby="dataInicioHelp" v-model="data_inicio_periodo">
                        </input-container-component>
                    </div>

                    <div class="col form-group">
                        <input-container-component titulo="Data Final" id="data_final_previsto_periodo" id-help="dataFinalHelp" texto-ajuda="Informe a data final">
                            <input type="datetime-local" class="form-control" aria-describedby="dataFinalHelp" v-model="data_final_previsto_periodo">
                        </input-container-component>
                    </div>

                    <div class="col form-group">
                        <input-container-component titulo="Data Final realizado" id="data_final_realizado_periodo" id-help="dataFinaRealizadolHelp" texto-ajuda="Informe a data final realizado">
                            <input type="datetime-local" class="form-control" aria-describedby="dataFinaRealizadolHelp" v-model="data_final_realizado_periodo">
                        </input-container-component>
                    </div>

                    <div class="col form-group">
                        <input-container-component titulo="Valor da diaria" id="valor_diaria" id-help="valorDiarialHelp" texto-ajuda="Informe o valor da diaria">
                            <input type="number" min="1" step="any" class="form-control" aria-describedby="valorDiarialHelp" v-model="valor_diaria">
                        </input-container-component>
                    </div>

                    <div class="col form-group">
                        <input-container-component titulo="KM Inicial" id="km_inicial" id-help="kmIniciolHelp" texto-ajuda="Informe o KM inicial">
                            <input type="number" min="1" step="any" class="form-control" aria-describedby="kmIniciolHelp" v-model="km_inicial">
                        </input-container-component>
                    </div>

                    <div class="col form-group">
                        <input-container-component titulo="KM Final" id="km_final" id-help="kmFinallHelp" texto-ajuda="Informe o KM final">
                            <input type="number" min="1" step="any" class="form-control" aria-describedby="kmFinallHelp" v-model="km_final">
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
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Id da marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca_id" disabled>
                </input-container-component>

                <input-container-component titulo="Marca">
                    <input type="text" class="form-control" value="" disabled>
                </input-container-component>

                <input-container-component titulo="Modelo">
                    <input type="text" class="form-control" value="" disabled>
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
import InputContainer from './InputContainer.vue'
export default {
  components: { InputContainer },
    data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/locacao',
                urlBaseCliente : 'http://localhost:8000/api/v1/cliente',
                urlBaseCarro : 'http://localhost:8000/api/v1/carro',
                urlPaginacao: '',
                urlFiltro: '',
                searchcarro:'',
                carro_id: '',
                cliente_id:'',
                data_inicio_periodo:'',
                data_final_previsto_periodo:'',
                data_final_realizado_periodo:'',
                valor_diaria:'',
                km_inicial:'',
                km_final:'',
                novonomeModelo: '',
                nomeModelo: '',
                abs: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                carros: { data: [] },
                clientes: { data: [] },
                locacoes: { data: [] },
                busca: { id: '', carro_id: '' },
            }
        },
        methods:{
            carregarCliente() {
                
               let url = this.urlBaseCliente + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.clientes = response.data

                        let urls = []
                        
                        let links = {}

                        if(this.clientes.current_page != this.clientes.last_page ){ // para eu verificar se estou ja na ultima pagina

                             this.clientes.links.forEach(campo =>{                          

                                links[campo] = campo.url
                                urls.push(links[campo])
                            })

                            for(let i = 2;i< (urls.length - 1);i++){ // Aqui eu pego os dados de cada página em clientes, o retorno é quantidade de paginas com a quantidade de dados em cada uma delas
                                url = urls[i]
                                axios.get(url)
                                    .then(response => {
                                        for(let z = 0; z< response.data.data.length;z++){ // aqui eu pego separadamente cada dado da página e adiciono a clientes
                                            this.carros.data.push(response.data.data[z])
                                        }
                                    }).catch(errors => {
                                    console.log(errors)
                                })
                            }
                        }
                        
                        
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarCarro() {
                
               let url = this.urlBaseCarro + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.carros = response.data

                        let urls = []
                        
                        let links = {}

                        if(this.carros.current_page != this.carros.last_page ){ // para eu verificar se estou ja na ultima pagina

                             this.carros.links.forEach(campo =>{                          

                                links[campo] = campo.url
                                urls.push(links[campo])
                            })

                            for(let i = 2;i< (urls.length - 1);i++){ // Aqui eu pego os dados de cada página em carros, o retorno é quantidade de paginas com a quantidade de dados em cada uma delas
                                url = urls[i]
                                axios.get(url)
                                    .then(response => {
                                        for(let z = 0; z< response.data.data.length;z++){ // aqui eu pego separadamente cada dado da página e adiciono a carros
                                            this.carros.data.push(response.data.data[z])
                                        }
                                    }).catch(errors => {
                                    console.log(errors)
                                })
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
                        this.locacoes = response.data
                        console.log(this.locacoes.data)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            paginacao(l) {
                if(l.url) {
                    //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
            salvar() {

                let formData = new FormData();
                formData.append('cliente_id', this.cliente_id)
                formData.append('carro_id', this.carro_id)
                formData.append('data_inicio_periodo', this.data_inicio_periodo)
                formData.append('data_final_previsto_periodo', this.data_final_previsto_periodo)
                formData.append('data_final_realizado_periodo', this.data_final_realizado_periodo)
                formData.append('valor_diaria', this.valor_diaria)
                formData.append('km_inicial', this.km_inicial)
                formData.append('km_final', this.km_final)

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
        },
        watch:{
            searchcarro(valorNovo){

                let filtro = ''
                this.busca.carro_id = valorNovo;


                for(let chave in this.busca) {


                    if(this.busca[chave]) {

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
            this.carregarCarro()
            this.carregarCliente()
        }
}
</script>