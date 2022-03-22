<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">   
                <!-- Inicio do card de busca   -->
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col form-group">
                                <input-container-component 
                                    titulo="ID da Marca"  
                                    id="inputID" 
                                    id-help="idHelp" 
                                    texto-ajuda="Opcional. Informe o ID da Marca"> 
                                    <input type="number" class="form-control" id="inputID" aria-describedby="idHelp" placeholder="ID da Marca">
                                </input-container-component>                                
                            </div>
                            <div class="col form-group">
                                <input-container-component 
                                    titulo="Nome da marca" 
                                    id="inputNome"
                                    id-help="nomeHelp"
                                    texto-ajuda="Opcional. Informe o Nome da Marca"> 
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca   -->

                <!-- Inicio do card de listagem de marcas   -->
                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalMarca">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim do card de listagem de marcas   -->
            
            </div>
        </div>
    <modal-component id="modalMarca" titulo="Adicionar Marca">
        <template v-slot:conteudo>
            <div class="form-group">
                <input-container-component 
                    titulo="Nome da marca" 
                    id="novoNome"
                    id-help="novoNomeHelp"
                    texto-ajuda="Informe o Nome da Marca"> 
                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                </input-container-component>
            </div>
            <div class="form-group">
                <input-container-component 
                    titulo="Imagem" 
                    id="novoImagem"
                    id-help="novoImagemHelp"
                    texto-ajuda="Selecione uma imagem no formato PNG"> 
                    <input type="file" class="form-control-file" id="novoImagem" aria-describedby="nomeHelp" placeholder="Seleciona uma Imagem">
                </input-container-component>
            </div>
        </template>
        <template v-slot:rodape>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary">Salvar</button>
        </template>
    </modal-component>
    </div>
</template>

<script>
 
</script>
