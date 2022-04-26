<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Relação de Carros">

                    <template v-slot:filtro>
                        <div class="d-flex justify-content-end">                     
                            <div class="form-inline">
                                <div class="form-group mx-sm-3 ">
                                    <input-container-component titulo="Pesquisar carros" id="inputNome" >
                                        <input type="text" class="form-control m-2" id="inputNome" aria-describedby="inputNomeHelp" placeholder="Nome do carro" v-model="nomeCarro">
                                    </input-container-component>
                                </div>
                            </div>
                        </div>                       
                    </template>

                    <template v-slot:conteudo>
                        <table-component 
                            :dados="carros.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                modelo_id: {titulo: 'Modelo ID', tipo: 'texto'},
                                modelo: {titulo: 'Modelo', tipo: 'modelo'},
                                placa: {titulo:'Placa',tipo:'texto'},
                                disponivel: {titulo: 'Disponivel', tipo: 'texto'},
                                km: {titulo: 'KM', tipo: 'texto'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in carros.links" :key="key" 
                                        :class="l.active ? 'page-item active' : 'page-item'" 
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCarro">Adicionar</button>
                            </div>
                        </div>
                    </template>

                </card-component>
            </div>
        </div>

         <modal-component id="modalCarro" titulo="Adicionar carro">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a modelo" v-if="transacaoStatus == 'erro'"></alert-component>                
            </template>

            <template v-slot:conteudo>

                <div class="form-group">
                    <input-container-component titulo="Modelo" id="modelo_id" id-help="idModeloHelp" texto-ajuda="Informe o modelo">
                        <select  class="form-select form-control" aria-label=".form-select-sm example" id="modelo_id"  v-model="modelo_id">
                            <option selected >Abra o menu para selecionar o modelo</option>
                            <option v-for="m in modelos.data" :value="m.id" :key="m.id">{{m.nome}}</option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Placa" id="novaPlaca" id-help="novaPlacaHelp" texto-ajuda="Informe a Placa">
                        <input type="text" class="form-control" id="novaPlaca" aria-describedby="novoNomeHelp" placeholder="Informe a placa" v-model="placa">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Disponibilidade" id="disponivel" id-help="disponivelHelp" texto-ajuda="Informe a disponibilidade">
                        <select  class="form-select form-control" aria-label=".form-select-sm example" id="disponivel" v-model="disponivel" >
                            <option selected>Abra o menu para selecionar a disponibilidade</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                            
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="KM" id="km" id-help="kmHelp" texto-ajuda="Informe a Kilometragem">
                        <input type="text" class="form-control" id="km" aria-describedby="kmHelp" placeholder="Kilometragem" v-model="km">
                    </input-container-component>

                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
export default {
   data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/carro',
                urlBaseModelos : 'http://localhost:8000/api/v1/modelo',
                urlPaginacao: '',
                urlFiltro: '',
                modelo_id: '',
                nomeCarro: '',
                placa:'',
                km:'',
                disponivel:'',
                transacaoStatus: '',
                transacaoDetalhes: {},
                modelos: { data: [] },
                carros: { data: [] },
                busca: { id: '', nome: '' },
            }
        },
        methods:{
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.carros = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarModelos() {
                
               let url = this.urlBaseModelos + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.modelos = response.data

                        
                        let urls = []
                        
                        let links = {}

                       

                        if(this.modelos.current_page != this.modelos.last_page ){ // para eu verificar se estou ja na ultima pagina

                             this.modelos.links.forEach(campo =>{                          

                                links[campo] = campo.url
                                urls.push(links[campo])
                            })

                            for(let i = 2;i< (urls.length - 1);i++){ // Aqui eu pego os dados de cada página em modelos, o retorno é quantidade de paginas com a quantidade de dados em cada uma delas
                                url = urls[i]

                                //console.log(url)
                                //console.log(i)

                                axios.get(url)
                                    .then(response => {
                                        //console.log('Página:'+i)
                                        for(let z = 0; z< response.data.data.length;z++){ // aqui eu pego separadamente cada dado da página e adiciono os modelos
                                            //console.log(z)
                                            //console.log(response.data.data[z])
                                            this.modelos.data.push(response.data.data[z])
                                        }
                                }).catch(errors => {
                                    console.log(errors)
                                })

                                //console.log(this.modelos)  
                            }
                        }
                        
                        
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            salvar() {
                console.log(this.modelo_id,this.placa,this.disponivel,this.km)

                let formData = new FormData();
                formData.append('modelo_id', this.modelo_id)
                formData.append('placa', this.placa)
                formData.append('disponivel', this.disponivel)
                formData.append('km', this.km)


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
            paginacao(l) {
                if(l.url) {
                    //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
        },
        watch:{
            nomeCarro(valorNovo){

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
            this.carregarModelos()
        }
}
</script>